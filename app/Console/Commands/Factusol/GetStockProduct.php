<?php

namespace App\Console\Commands\Factusol;

use App\Services\FactusolService;
use Illuminate\Console\Command;

class GetStockProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-stock-product {--code=}';

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

        $F_STOC = $factusolService->get_stock($code);

        $this->info("El product {$code} posee un stock de {$F_STOC[4]['dato']}");
    }
}
