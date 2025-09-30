<?php

namespace App\Console\Commands\Factusol;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\FactusolService;


class SyncStockFactusolToProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-stock-factusol-to-product  {--product=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza el stock de los productos de Factusol a los productos de la base de datos';

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

                        $F_STOC = (new FactusolService())->getStockFactusol($product->code);

                        $this->output->writeln("<fg=green>The product {$product->code} has a stock of {$product->stock} => {$F_STOC[1]['dato']}</fg>");

                        $product->stock = $F_STOC[1]['dato'];

                        $product->save();

                    } catch (\Throwable $th) {

                        $this->output->writeln($th->getMessage());

                    }
                }
            });
        });

        $this->output->writeln("\n<fg=green>Stock synchronization completed.</fg>\n");

        return Command::SUCCESS;
    }
}
