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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::withoutEvents(function () {
            $products = Product::when($this->option('product'), function ($query) {
                $query->where('id', $this->option('product'))->orWhere('code', $this->option('product'));
            })->get();

            $this->output->writeln('Starting stock synchronization to Factusol...');
            
            $this->withProgressBar($products, function (Product $product) {

                if (app()->isProduction()) {

                    $factusolService = new FactusolService();

                    $F_STOC = $factusolService->get_stock($product->code);

                    if (empty($F_STOC)) {
                        $this->output->writeln("The product {$product->code} has no stock");
                        return;
                    }

                    $this->output->writeln("The product {$product->code} has a stock of {$product->stock} => {$F_STOC[4]['dato']}");
                    
                    $product->stock = $F_STOC;

                    $product->save();
                }
            });
        });
        
        $this->output->writeln('Stock synchronization completed.');
    }
}
