<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Jobs\AssociateDimensionProductJob;

class ScanDimensionByProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scan-dimension-by-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene las dimensiones de los productos mediante su Código';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->withProgressBar(Product::all(), fn(Product $product) => AssociateDimensionProductJob::dispatchSync($product));
    }
}
