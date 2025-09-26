<?php

namespace App\Console\Commands\Factusol;

use App\Services\FactusolService;
use Illuminate\Console\Command;
use App\Exceptions\GetStockExceptions;
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

        try {
            $F_STOC = (new FactusolService())->get_F_ART_STOCK($code);

        } catch (\Throwable $th) {

            $this->error($th->getMessage());

            return Command::FAILURE;
        }

        if ($this->option('all-data')) {
            $this->info(json_encode($F_STOC));
        } else {
            $this->info("El product {$code} posee un stock de {$F_STOC[1]['dato']}");
        }

        return Command::SUCCESS;
    }
}
