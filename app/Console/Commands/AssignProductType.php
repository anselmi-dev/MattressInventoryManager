<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Jobs\AssociateProductTypeJob;

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
    protected $description = 'Asociar los tipos de producto a las partes (Productos)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->withProgressBar(Product::all(), fn(Product $product) =>  AssociateProductTypeJob::dispatchSync($product));
    }
}
