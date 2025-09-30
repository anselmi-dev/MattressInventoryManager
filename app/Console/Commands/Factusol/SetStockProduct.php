<?php

namespace App\Console\Commands\Factusol;

use App\Services\FactusolService;
use GPBMetadata\Temporal\Api\Enums\V1\Common;
use Illuminate\Console\Command;

class SetStockProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-stock-product {--stock= : Cantidad del stock} {--code= : Codigo del producto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setea el stock de un producto de factusol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $code = $this->option('code');

        $stock = (int) $this->option('stock');

        if ((new FactusolService())->setStockFactusol($code, $stock)) {

            $this->info("ACTUALIZACIÓN DEL STOCK CORRECTO");

            return Command::SUCCESS;
        }

        $this->error("OCURRIÓ UN ERROR");

        return Command::FAILURE;
    }
}
