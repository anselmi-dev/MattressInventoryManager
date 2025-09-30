<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Jobs\AssociateProductTypeJob;

class AddProductTypeToProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-product-type {--code= : Codigo del producto}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Agregar los tipos de producto a las partes (Productos)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->withProgressBar(Product::when($this->option('code'), function ($query) {
            $query->where('code', $this->option('code'));
        })->get(), fn(Product $product) =>  AssociateProductTypeJob::dispatchSync($product));
    }
}
