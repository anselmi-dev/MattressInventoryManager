<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Services\FactusolService;

class SyncStockToFactusol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-stock-to-factusol  {--product=} {--stock=}';

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
            $products = Product::withoutGlobalScopes()->when($this->option('product'), function ($query) {
                $query->where('id', $this->option('product'))->orWhere('code', $this->option('product'));
            })->get();

            $this->output->writeln('Starting stock synchronization to Factusol...');

            $this->withProgressBar($products, function (Product $product) {

                if (app()->isProduction()) {

                    if ($product->stock < 0) {
                        $product->stock = 0;
                        $product->save();
                    }

                    $factusolService = new FactusolService();

                    $factusolService->update_stock(
                        $product->code,
                        $this->option('stock') ? (int) $this->option('stock') : $product->stock
                    );
                }
            });
        });

        $this->output->writeln('Stock synchronization completed.');
    }
}
