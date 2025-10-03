<?php

namespace App\Console\Commands\Factusol;

use Illuminate\Console\Command;
use App\Console\Services\FactusolCommandService;
use App\Events\FactusolProductSaleCreated;
use App\Models\FactusolSale;
use Carbon\Carbon;
class ScanSales extends FactusolCommandService
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-sales {--force : No se tendrá en cuenta la fecha de la última sincronización } {--code= : Buscar por el código de la factura} {--no-events : No ejecutar los eventos de creación o actualización de los productos} {--truncate : Truncar la tabla de ventas}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener las ventas de factusol y sincronizarlas a la base de datos';

    public function optionCode(): ?string
    {
        return $this->option('code');
    }

    public function optionForce(): bool
    {
        return $this->option('force');
    }

    public function funcionNameFactusolService(): string
    {
        return 'getSales';
    }

    public function getkeyCacheLastUpdatedDateOf(): string
    {
        return 'last_updated_date_of_sales';
    }

    public function getLastUpdatedDateRecords(): ?Carbon
    {
        // return FactusolSale::orderBy('FECFAC', 'desc')->first()?->FECFAC;
        return Carbon::now()->subDays(2)->startOfDay();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->infoLastUpdatedDateOf();

        if ($this->option('truncate')) {
            // Desactivar temporalmente las verificaciones de claves foráneas
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Truncar las tablas relacionadas primero
            \DB::table('product_sale')->truncate();
            FactusolSale::truncate();

            // Reactivar las verificaciones de claves foráneas
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            $this->info('Tablas truncadas correctamente');
        }

        $records = $this->getDataFactusol();

        $this->withProgressBar($records, function (array $record) {
            $this->firstOrCreateRecord(
                $this->reduceFactusol($record)
            );
        });

        if ($this->option('code') && count($records) === 0) {
            throw new \Exception('No se encontró la venta en Factusol');
        }

        $this->setLastUpdatedDateOf();

        $this->info(PHP_EOL . "PROCESO TERMINADO CORRECTAMENTE" . PHP_EOL);

        return Command::SUCCESS;
    }

    public function firstOrCreateRecord (array $data): void
    {
        $sale = FactusolSale::withoutGlobalScopes()
            ->updateOrCreate([
                'CODFAC' => $data['CODFAC'],
            ], [
                'TOTFAC' => $data['TOTFAC'],
                'FUMFAC' => $data['FUMFAC'],
                'CLIFAC' => $data['CLIFAC'],
                'ESTFAC' => $data['ESTFAC'],
                'CNOFAC' => $data['CNOFAC'],
                'CEMFAC' => $data['CEMFAC'],
                'NET1FAC' => $data['NET1FAC'],
                'IREC1FAC' => $data['IREC1FAC'],
                'FECFAC' => $data['FECFAC'],
                'TIPFAC' => $data['TIPFAC'],
                'IIVA1FAC' => $data['IIVA1FAC']
            ]);

        if (!$data['ARTLFA'])
            return;

        $productSale = $sale
            ->product_sales()
            ->withoutGlobalScopes()
            ->updateOrCreate([
                'sale_id' => (int) $sale->id,
                'ARTLFA' => $data['ARTLFA'],
                'TOTLFA' => $data['TOTLFA'],
            ], [
                'CANLFA' => (int) $data['CANLFA'],
                'DESLFA' => $data['DESLFA'],
                'created_at' => $data['FECFAC'],
                'updated_at' => $data['FECFAC'],
            ]);

        if ($this->option('no-events')) {
            return;
        }

        // if ($productSale->wasRecentlyCreated) {
            // FactusolProductSaleCreated::dispatch($sale);
        // }
    }
}
