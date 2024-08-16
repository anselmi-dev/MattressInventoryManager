<?php

namespace Database\Seeders;

use App\Models\Base;
use App\Models\Code;
use App\Models\Combination;
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
        $combination = Combination::firstOrCreate([
            'name' => 'COMB0001'
        ], [
            'dimension_id' => Dimension::inRandomOrder()->first()->id,
            'stock' => 240
        ]);

        $combination->products()->attach([
            Product::where('type', 'cover')->inRandomOrder()->first()->id,
            Product::where('type', 'top')->inRandomOrder()->first()->id,
            Product::where('type', 'base')->inRandomOrder()->first()->id,
        ]);

        if ($combination->wasRecentlyCreated) {
            $code = new Code(["value" => 'COMB0001']);
            $combination->code()->save($code);
        }

        $combination = Combination::firstOrCreate([
            'name' => 'COMB0002'
        ], [
            'dimension_id' => Dimension::inRandomOrder()->first()->id,
            'stock' => 240
        ]);

        $combination->products()->attach([
            Product::where('type', 'cover')->inRandomOrder()->first()->id,
            Product::where('type', 'top')->inRandomOrder()->first()->id,
            Product::where('type', 'base')->inRandomOrder()->first()->id,
        ]);

        if ($combination->wasRecentlyCreated) {
            $code = new Code(["value" => 'COMB0002']);
            $combination->code()->save($code);
        }

        $combination = Combination::firstOrCreate([
            'name' => 'COMB0003'
        ], [
            'dimension_id' => Dimension::inRandomOrder()->first()->id,
            'stock' => 240
        ]);

        $combination->products()->attach([
            Product::where('type', 'cover')->inRandomOrder()->first()->id,
            Product::where('type', 'top')->inRandomOrder()->first()->id,
            Product::where('type', 'base')->inRandomOrder()->first()->id,
        ]);

        if ($combination->wasRecentlyCreated) {
            $code = new Code(["value" => 'COMB0003']);
            $combination->code()->save($code);
        }
    }
}
