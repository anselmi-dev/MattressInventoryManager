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
    protected $signature = 'app:get-stock-product {--code=} {--all-data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtener el stock de un producto de Factusol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $code = $this->option('code');

        $F_STOC = (new FactusolService())->get_stock($code);

        if ($this->option('all-data')) {
            $this->info(json_encode($F_STOC));
        } else {
            $this->info("El product {$code} posee un stock de {$F_STOC[4]['dato']}");
        }
    }
}
