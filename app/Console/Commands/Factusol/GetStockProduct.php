<?php

namespace App\Console\Commands\Factusol;

use App\Services\FactusolService;
use Illuminate\Console\Command;
use App\Models\Product;
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
    protected $description = 'Obtener el stock de un producto de Factusol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $code = $this->option('code');

        try {

            $this->info("Obteniendo el stock del producto {$code}");

            $F_STOC = (new FactusolService())->getValueStockFactusol($code);

            $this->info("Stock factusol: {$F_STOC}");

            $product = Product::code($code)->firstOrFail();

            $this->info("Stock local: {$product->stock}");

            if ($product->stock != $F_STOC) {

                $this->error("Stock están desincronizados");

                return Command::FAILURE;

            }

            $this->info("Stock están sincronizados");

            return Command::SUCCESS;

        } catch (\Throwable $th) {

            $this->error($th->getMessage());

            return Command::FAILURE;
        }
    }
}
