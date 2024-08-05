<?php

namespace Database\Seeders;

use App\Models\Dimension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dimension::firstOrCreate([
            'height' => 100,
            'width' => 120,
        ], [
            'code' => 'DIM0001',
            'stock' => 120,
            'visible' => true,
        ]);

        Dimension::firstOrCreate([
            'height' => 120,
            'width' => 140,
        ], [
            'code' => 'DIM0002',
            'stock' => 140,
            'visible' => true,
        ]);

        Dimension::firstOrCreate([
            'height' => 220,
            'width' => 240,
        ], [
            'code' => 'DIM0003',
            'stock' => 240,
            'visible' => true,
        ]);
    }
}
