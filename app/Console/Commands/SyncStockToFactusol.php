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
    protected $signature = 'app:sync-stock-to-factusol  {--product=}';

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
            $products = Product::withoutGlobalScopes()->when($this->option('product'), function ($query) {
                $query->where('id', $this->option('product'))->orWhere('code', $this->option('product'));
            })->get();

            $this->withProgressBar($products, function (Product $product) {
                if (app()->isProduction()) {
                    $factusolService = new FactusolService();
                    
                    $factusolService->update_stock($product->code, $product->stock);
                }
            });
        });
    }
}
