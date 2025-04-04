<?php

namespace App\Console\Commands\Factusol;

use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use App\Services\FactusolService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScanSales extends Command
{
    protected $last_updated_date_of_sales;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-sales {--force} {--factusol}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("ÚLTIMO PROCE DE IMPORTACIÓN LANZADO EL " . settings()->get('last_updated_date_of_sales'));
        
        $this->last_updated_date_of_sales = Carbon::now()->subDays(60);

        $query = \Str::replaceArray('?', [
            (!$this->option('force') && $this->last_updated_date_of_sales) ? "WHERE F_FAC.FECFAC > '{$this->last_updated_date_of_sales->toDateTimeString()}'" : ''
        ], "SELECT F_LFA.CANLFA, F_LFA.ARTLFA, F_LFA.TOTLFA, F_LFA.DESLFA, F_LFA.CODLFA as CODFAC, F_FAC.IREC1FAC, F_FAC.TOTFAC, F_FAC.CLIFAC, F_FAC.CNOFAC, F_FAC.FUMFAC, F_FAC.CEMFAC, F_FAC.ESTFAC, F_FAC.FECFAC, F_FAC.IIVA1FAC, F_FAC.NET1FAC, F_FAC.TIPFAC FROM F_LFA JOIN F_FAC ON F_LFA.CODLFA = F_FAC.CODFAC ? ORDER BY F_FAC.FECFAC ASC");

        $factusol_products = (new FactusolService())->query($query);

        $this->withProgressBar($factusol_products, function (array $factusol_product) {
            $this->procesarFactusolSale(
                $this->reduceFactusolSale($factusol_product)
            );
        });

        settings()->set('last_updated_date_of_sales', Carbon::now()->toDateTimeString());

        $this->info(PHP_EOL . "PROCESO TERMINADO CORRECTAMENTE" . PHP_EOL);
    }

    /**
     * Formatear la data que proviene de factusol.
     * Cada linea de la factuta se formatea para mejor acceso
     *
     * @param array $item
     * @return array
     */
    protected function reduceFactusolSale (array $item):array
    {
        return array_reduce($item, function ($carry, $row) {
            $carry[$row['columna']] = $row['dato'];
            return $carry;
        }, []);
    }

    /**
     * Procesar la data de factusol para crear el producto de cada linea de la factura
     *
     * @param array $factusol_sale
     * @return void
     */
    protected function procesarFactusolSale (array $factusol_sale): void
    {
        $sale = Sale::withoutGlobalScopes()
            ->updateOrCreate([
                'CODFAC' => $factusol_sale['CODFAC'],
            ], [
                'TOTFAC' => $factusol_sale['TOTFAC'],
                'FUMFAC' => $factusol_sale['FUMFAC'],
                'CLIFAC' => $factusol_sale['CLIFAC'],
                'ESTFAC' => $factusol_sale['ESTFAC'],
                'CNOFAC' => $factusol_sale['CNOFAC'],
                'CEMFAC' => $factusol_sale['CEMFAC'],
                'NET1FAC' => $factusol_sale['NET1FAC'],
                'IREC1FAC' => $factusol_sale['IREC1FAC'],
                'FECFAC' => $factusol_sale['FECFAC'],
                'TIPFAC' => $factusol_sale['TIPFAC'],
                'IIVA1FAC' => $factusol_sale['IIVA1FAC']
            ]);

        /* Se verifica que la factura no contenga líneas de productos. */
        if (!$factusol_sale['ARTLFA'])
            return;

        $productSale = ProductSale::withoutGlobalScopes()
            ->updateOrCreate([
                'sale_id' => (int) $sale->id,
                'ARTLFA' => $factusol_sale['ARTLFA'],
            ], [
                'CANLFA' => (int) $factusol_sale['CANLFA'],
                'TOTLFA' => $factusol_sale['TOTLFA'],
                'DESLFA' => $factusol_sale['DESLFA'],
                'created_at' => $factusol_sale['FECFAC'],
                'updated_at' => $factusol_sale['FECFAC'],
                // 'processed_at' => $sale->is_processed ? Carbon::now() : null,
            ]);

        if ($productSale->wasRecentlyCreated) {
            $productSale->decrementStock();
        }
        
        /* Verifica que la venta esté en estado "procesada" y que no se haya emitido un decremento de stock previamente en el product_sale. */
        //if ($sale->is_processed && is_null($productSale->processed_at)) {
        //    $productSale->decrementStock();
        //}
    }
}
