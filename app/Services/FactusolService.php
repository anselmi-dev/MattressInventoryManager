<?php

namespace App\Services;

use Carbon\Carbon;
use App\Services\FactusolHttpService;

class FactusolService
{
    public FactusolHttpService $factusolHttpService;

    public function __construct()
    {
        $this->factusolHttpService = new FactusolHttpService();
    }

    /**
     * Obtener el stock de un producto de factusol de la tabla F_ART
     * Retorna un array con el stock del producto
     *
     * @param string $code
     * @return mixed
     */
    public function getStockFactusol (string $code): mixed
    {
        // $response = $this->factusolHttpService->consultaQuery("SELECT CODART, STOART FROM F_ART WHERE CODART = '$code'");
        $response = $this->factusolHttpService->consultaQuery("SELECT * FROM F_STO WHERE ARTSTO = '$code'");

        if (!is_object($response) || count($response->resultado) === 0) {
            throw new \Exception('No se encontró el producto en Factusol');
        }

        return $response->resultado[0];
    }

    /**
     * Obtener el stock de un producto de factusol de la tabla F_ART
     * Retorna un array con el stock del producto
     *
     * @param string $code
     * @return mixed
     */
    public function getValueStockFactusol (string $code): mixed
    {
        return collect($this->getStockFactusol($code))->firstWhere('columna', 'ACTSTO')->dato;
    }

    /**
     * Setea el stock de un producto de factusol
     *
     * @param string $code
     * @return bool
     */
    public function setStockFactusol (string $code, int $stock): bool
    {
        if (!app()->isProduction())
            return true;
        /*
        * Este código es para obtener el registro del stock
        * y actualizarlo el valor del campo ACTSTO
        * para después actualizarlo en la tabla F_STO
        * PERO CÓMO SOLO NECESITO ACTSTO, ALMOSTO y ACTSTO para actualizarlo en la tabla F_STO
        * entonces voy a crear un array con solo esos campos para actualizarlo en la tabla F_STO
        * Tener en cuenta que esto es si ALMOSTO es GEN siempre!!! ya que desduzco que es así.
        */
        /*
            $stockFactusol = collect($this->getStockFactusol($code))->transform(function ($item) use ($quantity) {
                if ($item->columna === 'ACTSTO') {
                    $item->dato = $quantity;
                }

                return $item;
            });
        */

        $stockFactusol = collect([
            [
                'columna' => 'ARTSTO',
                'dato' => $code
            ],
            [
                'columna' => 'ALMSTO',
                'dato' => 'GEN'
            ],
            [
                'columna' => 'ACTSTO',
                'dato' => $stock
            ]
        ]);

        $response = $this->factusolHttpService->actualizarRegistro([
            'tabla' => 'F_STO',
            'registro' => $stockFactusol->toArray()
        ]);

        return $response->respuesta == 'OK';
    }

    /**
     * Setea el stock de un producto de factusol
     *
     * @param string $code
     * @return bool
     */
    public function addStockFactusol (string $code, int $stock): bool
    {
        if (!app()->isProduction())
            return true;

        $stockFactusol = collect($this->getStockFactusol($code))->transform(function ($item) use ($stock) {
            if ($item->columna === 'ACTSTO') {
                $item->dato += $stock;
            }

            return $item;
        });

        $response = $this->factusolHttpService->actualizarRegistro([
            'tabla' => 'F_STO',
            'registro' => $stockFactusol->toArray()
        ]);

        return $response->respuesta == 'OK';
    }

    /**
     * Actualiza el stock de un producto de factusol
     *
     * @param string $code
     * @param int $stock
     * @param bool $addStock
     * @return bool
     */
    public function updateStockFactusol (string $code, int $stock, bool $addStock = true): bool
    {
        return $addStock ? $this->addStockFactusol($code, $stock) : $this->setStockFactusol($code, $stock);
    }

    /**
     * Obtener los productos de factusol
     * Mediante la query se obtiene los productos de factusol
     *
     * @param string $code
     * @param Carbon $last_updated_date
     * @return array
     */
    public function getProducts (?string $code = null, ?Carbon $last_updated_date = null): array
    {
        $whereCODART = $code ? "AND F_ART.CODART = '{$code}'" : '';

        $whereUpdated = $last_updated_date ? "WHERE F_ART.FUMART > '{$last_updated_date->toDateTimeString()}'" : '';

        $query = str()->replaceArray('?', [
            $whereUpdated,
            $whereCODART,
        ], "SELECT F_ART.FUMART as FUMART, F_ART.CODART as CODART, F_ART.DESART as DESART, F_ART.EANART as EANART, F_STO.ACTSTO as ACTSTO FROM F_ART JOIN F_STO ON F_ART.CODART = F_STO.ARTSTO ? ? ORDER BY F_ART.FUMART DESC");

        $response = $this->factusolHttpService->consultaQuery($query);

        if (!is_object($response) || $response->respuesta !== 'OK') {
            throw new \Exception('Error al obtener los productos de factusol');
        }

        return $response->resultado;
    }

    /**
     * Obtener las ventas de factusol
     * Mediante la query se obtiene las ventas de factusol
     *
     * @param Carbon $last_updated_date
     * @param string $code
     * @return mixed
     */
    public function getSales (?string $code = null, ?Carbon $last_updated_date = null): mixed
    {
        $whereUpdated = $last_updated_date ? "WHERE F_FAC.FECFAC > '{$last_updated_date->toDateTimeString()}'" : '';

        $whereCODFAC = $code ? "AND F_FAC.CODFAC = '{$code}'" : '';

        $query = str()->replaceArray('?', [
            $whereUpdated,
            $whereCODFAC,
        ], "SELECT
            F_LFA.CANLFA,
            F_LFA.ARTLFA,
            F_LFA.TOTLFA,
            F_LFA.DESLFA,
            F_LFA.CODLFA as CODFAC,
            F_FAC.IREC1FAC,
            F_FAC.TOTFAC,
            F_FAC.CLIFAC,
            F_FAC.CNOFAC,
            F_FAC.FUMFAC,
            F_FAC.CEMFAC,
            F_FAC.ESTFAC,
            F_FAC.FECFAC,
            F_FAC.IIVA1FAC,
            F_FAC.NET1FAC,
            F_FAC.TIPFAC
            FROM F_LFA JOIN F_FAC ON F_LFA.CODLFA = F_FAC.CODFAC ? ? ORDER BY F_FAC.FECFAC ASC");

        $response = $this->factusolHttpService->consultaQuery($query);

        if (!is_object($response) || $response->respuesta !== 'OK') {
            throw new \Exception('Error al obtener las ventas de factusol');
        }

        return $response->resultado;
    }

    /**
     * Obtener las ventas de factusol
     * Mediante la query se obtiene las ventas de factusol
     *
     * @param Carbon $last_updated_date
     * @param string $code
     * @return mixed
     */
    public function getSale (?string $code = null): mixed
    {
        return $this->getSales(code: $code);
    }
}
