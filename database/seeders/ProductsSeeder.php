<?php

namespace Database\Seeders;

use App\Models\Code;
use App\Models\Dimension;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use File;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = json_decode(File::get("database/seeders/data/products.json"));

        foreach ($collection as $key => $products) {
            foreach ($products as $product) {
                Product::firstOrCreate([
                    'code' => $product->code,
                    'name' => $product->code,
                ], [
                    'type' => $key,
                    'minimum_order' => rand(0, 10),
                    'dimension_id' => Dimension::first()->id,
                    'stock' => $product->stock,
                    'visible' => $product->visible,
                ]);
            }
        }
    }
}
