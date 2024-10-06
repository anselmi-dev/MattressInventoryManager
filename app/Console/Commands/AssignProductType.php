<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\ProductType;
use App\Jobs\AssignProductTypeJob;

class AssignProductType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-product-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asignar los tipos de producto a los productos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->withProgressBar(Product::all(), function (Product $product) {
            AssignProductTypeJob::dispatchSync($product);
        });
    }

}
