<?php

namespace App\Console\Commands\Factusol;

use App\Models\Product;
use App\Models\FactusolProduct;
use Illuminate\Console\Command;
use App\Console\Services\FactusolCommandService;
use Carbon\Carbon;
class ScanProducts extends FactusolCommandService
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-products {--force : No se tendrá en cuenta la fecha de la última sincronización } {--code= : Buscar por el código del producto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Factusol for any new products and verify if there are any discrepancies in the stock levels.';

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
        return 'getProducts';
    }

    public function getkeyCacheLastUpdatedDateOf(): string
    {
        return 'last_updated_date_of_products';
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->infoLastUpdatedDateOf();

        $records = $this->getDataFactusol();

        $this->withProgressBar($records, function (array $record) {
            $this->firstOrCreateRecord(
                $this->reduceFactusol($record)
            );
        });

        if ($this->optionCode() && count($records) === 0) {
            throw new \Exception('No se encontró el producto en Factusol');
        }

        $this->setLastUpdatedDateOf();

        $this->info(PHP_EOL . "PROCESO TERMINADO CORRECTAMENTE" . PHP_EOL);

        return Command::SUCCESS;
    }

    /**
     * Mediante los datos proporcionado de factusol se actualiza o crea el produ
     *
     * @param array $factusol_product
     * @return void
     */
    public function firstOrCreateRecord (array $data): void
    {
        FactusolProduct::firstOrCreate([
            'CODART' => $data['CODART']
        ], $data);

        Product::withoutGlobalScopes()->withTrashed()->updateOrCreate([
            'code' => trim($data['CODART']),
        ], [
            'reference' => trim($data['EANART']) ? trim($data['EANART']) : trim($data['CODART']),
            'name' => $data['DESART'],
            'stock' => $data['ACTSTO']
        ]);
    }

    public function getLastUpdatedDateRecords(): ?Carbon
    {
        $date_to_compare = FactusolProduct::orderBy('FUMART', 'desc')->first()?->FUMART;

        return $date_to_compare;
    }
}
