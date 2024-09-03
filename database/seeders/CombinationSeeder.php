<?php

namespace Database\Seeders;

use App\Models\Base;
use App\Models\Code;
use App\Models\Cover;
use App\Models\Dimension;
use App\Models\Product;
use App\Models\Top;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CombinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_combination = Product::firstOrCreate([
            'code' => 'COMB0001',
            'name' => 'COMB0001',
            'type' => 'combination'
        ], [
            'dimension_id' => Dimension::inRandomOrder()->first()->id,
            'stock' => 100
        ]);

        $product_combination->combinedProducts()->attach([
            Product::where('dimension_id', 1)->where('type', 'cover')->inRandomOrder()->first()->id,
            Product::where('dimension_id', 1)->where('type', 'top')->inRandomOrder()->first()->id,
            Product::where('dimension_id', 1)->where('type', 'base')->inRandomOrder()->first()->id,
        ]);
    }
}
