<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class InitializeProductLots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialize-product-lots';

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
        Product::whereDoesntHave('lots')->get()->each(function ($product) {
            $product->lots()->create([
                'name' => 'LOT-0002025',
                'reference' => $product->reference,
                'quantity' => $product->stock,
            ]);
        });
    }
}
