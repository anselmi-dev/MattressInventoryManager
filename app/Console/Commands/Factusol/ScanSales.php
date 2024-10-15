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
    protected $signature = 'app:scan-sales {--force}';

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
        $last_updated_date_of_sales = settings()->get('last_updated_date_of_sales');

        $this->last_updated_date_of_sales = $last_updated_date_of_sales ? Carbon::parse($last_updated_date_of_sales) : null;

        $query = \Str::replaceArray('?', [
            (!$this->option('force') && $this->last_updated_date_of_sales) ? "WHERE F_FAC.FECFAC > '{$this->last_updated_date_of_sales->toDateTimeString()}'" : ''
        ], "SELECT F_LFA.CANLFA, F_LFA.ARTLFA, F_LFA.TOTLFA, F_LFA.DESLFA, F_LFA.CODLFA as CODFAC, F_FAC.IREC1FAC, F_FAC.TOTFAC, F_FAC.CLIFAC, F_FAC.CNOFAC, F_FAC.FUMFAC, F_FAC.CEMFAC, F_FAC.ESTFAC, F_FAC.FECFAC, F_FAC.IIVA1FAC, F_FAC.NET1FAC, F_FAC.TIPFAC FROM F_LFA JOIN F_FAC ON F_LFA.CODLFA = F_FAC.CODFAC ? ORDER BY F_FAC.FECFAC ASC");

        $factusolService = new FactusolService();

        $factusol_sales = $factusolService->query($query);

        if (is_null($factusol_sales)) {
            $this->error('Ocurrió un error con la consulta');
            return;
        }

        $total_factusola_sales = count($factusol_sales);

        $bar = $this->output->createProgressBar($total_factusola_sales);

        $bar->start();

        foreach ($factusol_sales as $key => $item) {

            $this->procesarFactusolSale(
                $this->reduceFactusolSale($item)
            );

            $bar->advance();
        }

        $bar->finish();

        $this->info("Total de sales leidos {$total_factusola_sales} para la fecha {$last_updated_date_of_sales}");
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
        $date_to_compare = Carbon::parse($factusol_sale['FECFAC']);

        if (is_null($this->last_updated_date_of_sales) || !$this->last_updated_date_of_sales->greaterThan($date_to_compare)) {

            $this->last_updated_date_of_sales = $date_to_compare;
            
            settings()->set('last_updated_date_of_sales', $date_to_compare->toDateTimeString());
        }

        $sale = Sale::withoutGlobalScopes()->firstOrCreate([
            'CODFAC' => $factusol_sale['CODFAC'],
        ], [
            'TOTFAC' => $factusol_sale['TOTFAC'],
            'ESTFAC' => $factusol_sale['ESTFAC'],
            'FUMFAC' => $factusol_sale['FUMFAC'],
            'CLIFAC' => $factusol_sale['CLIFAC'],
            'CNOFAC' => $factusol_sale['CNOFAC'],
            'CEMFAC' => $factusol_sale['CEMFAC'],
            'NET1FAC' => $factusol_sale['NET1FAC'],
            'IREC1FAC' => $factusol_sale['IREC1FAC'],
            'FECFAC' => $factusol_sale['FECFAC'],
            'TIPFAC' => $factusol_sale['TIPFAC'],
            'IIVA1FAC' => $factusol_sale['IIVA1FAC'],
        ]);

        if ($factusol_sale['ARTLFA']) {
            $productSale = ProductSale::firstOrCreate([
                'sale_id' => (int) $sale->id,
                'ARTLFA' => $factusol_sale['ARTLFA'],
                'CANLFA' => (int) $factusol_sale['CANLFA'],
                'TOTLFA' => $factusol_sale['TOTLFA'],
                'DESLFA' => $factusol_sale['DESLFA'],
                'created_at' => $factusol_sale['FECFAC'],
                'updated_at' => $factusol_sale['FECFAC'],
            ]);
            
            if ($productSale->wasRecentlyCreated) {
                $productSale->created_at = $factusol_sale['FECFAC'];
                $productSale->updated_at = $factusol_sale['FECFAC'];
                $productSale->save();

                if ($sale->is_processed) {
                    $productSale->decrementStock();
                }
            }
        }

        // CAMBIO DE STOCK
        if ($sale->wasRecentlyCreated) {
            $sale->created_at = $factusol_sale['FECFAC'];
            $sale->updated_at = $factusol_sale['FECFAC'];
            $sale->save();
            // if ($sale->ESTFAC != $factusol_sale['ESTFAC']) {
            //     $this->error("La factura {$sale->CODFAC} posee un problema con el Stock de Factusol => F({$factusol_sale['ESTFAC']}) != DB($sale->ESTFAC)");
            // }
        }
    }
}
