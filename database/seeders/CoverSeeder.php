<?php

namespace Database\Seeders;

use App\Models\Cover;
use App\Models\Dimension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cover::firstOrCreate([
            'code' => 'FUN0001',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 120
        ]);

        Cover::firstOrCreate([
            'code' => 'FUN0002',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 220
        ]);
    }
}
