<?php

namespace App\Console\Commands\Factusol;

use App\Services\FactusolService;
use Illuminate\Console\Command;

class SetStockProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-stock-product {--quantity=} {--code=}';

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
        $factusolService = new FactusolService();

        $code = $this->option('code');

        $quantity = (int) $this->option('quantity');

        if ($factusolService->update_stock($code, $quantity, true)) {
            $this->info("ACTUALIZACIÓN DEL STOCK CORRECTO");
        } else {
            $this->error("OCURRIÓ UN ERROR");
        }
    }
}
