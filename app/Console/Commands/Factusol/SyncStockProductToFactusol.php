<?php

namespace App\Console\Commands\Factusol;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\FactusolService;


class SyncStockProductToFactusol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-stock-product-to-factusol  {--product=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza el stock de los productos a Factusol';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::withoutEvents(function () {
            $products = Product::when($this->option('product'), function ($query) {
                $query->where('id', $this->option('product'))->orWhere('code', $this->option('product'));
            })->get();

            $this->output->writeln("\n<fg=green>Starting stock synchronization to Factusol...</fg>\n");

            $this->withProgressBar($products, function (Product $product) {

                if (app()->isProduction()) {

                    try {

                        if ($product->stock < 0) {
                            throw new \Exception('El stock del producto es menor a 0');
                        }

                        (new FactusolService())->setStockFactusol(
                            code: $product->code,
                            stock: $product->stock
                        );

                        $this->output->writeln("<fg=green>OK</fg> The product {$product->code} has a stock of {$product->stock}");

                    } catch (\Throwable $th) {

                        $this->output->writeln("<fg=red>ERROR</fg> The product {$product->code} has a stock of {$product->stock}");
                    }
                }
            });
        });


        $this->output->writeln("\nStock synchronization completed. \n");

        return Command::SUCCESS;
    }
}
