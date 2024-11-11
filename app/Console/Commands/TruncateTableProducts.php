<?php

namespace App\Console\Commands;

use App\Jobs\UpdateStockFactusol;
use App\Models\Product;
use Illuminate\Console\Command;

class TruncateTableProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:truncate-table-products {--factusol} {--force} {--product=} {--not-delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borrar de manera lógica todo los productos. además, se le aplicará el stock 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (app()->isProduction() && !$this->option('force')) {
            $this->error('El comando solo se podrá lanzar en producción');
            return;
        }
        
        Product::withoutEvents(function () {
            $products = Product::withoutGlobalScopes()->when($this->option('product'), function ($query) {
                $query->where('id', $this->option('product'))->orWhere('code', $this->option('product'));
            })->get();

            $this->withProgressBar($products, function (Product $product) {
                $product->update(['stock' => 0]);
                
                if ($this->option('factusol')) {
                    UpdateStockFactusol::dispatchSync($product->code, 0, true);
                }
    
                if (!$this->option('not-delete'))
                    $product->delete();
            });
        });

        $this->info('Se reinició el stock de todo los productos. además, se aplicó el softdelete');
    }
}
