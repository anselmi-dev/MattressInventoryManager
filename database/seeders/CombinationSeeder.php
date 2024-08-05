<?php

namespace Database\Seeders;

use App\Models\Base;
use App\Models\Combination;
use App\Models\Cover;
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
        Combination::firstOrCreate([
            'code' => 'COMB0001',
            'cover_id' => Cover::inRandomOrder()->first()->id,
            'base_id' => Base::inRandomOrder()->first()->id,
            'top_id' => Top::inRandomOrder()->first()->id,
        ], [
            'stock' => 240,
            'visible' => true,
        ]);

        Combination::firstOrCreate([
            'code' => 'COMB0002',
            'cover_id' => Cover::inRandomOrder()->first()->id,
            'base_id' => Base::inRandomOrder()->first()->id,
            'top_id' => Top::inRandomOrder()->first()->id,
        ], [
            'stock' => 240,
            'visible' => true,
        ]);

        Combination::firstOrCreate([
            'code' => 'COMB0003',
            'cover_id' => Cover::inRandomOrder()->first()->id,
            'base_id' => Base::inRandomOrder()->first()->id,
            'top_id' => Top::inRandomOrder()->first()->id,
        ], [
            'stock' => 240,
            'visible' => true,
        ]);
    }
}
