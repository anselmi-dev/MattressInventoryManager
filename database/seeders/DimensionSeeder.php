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
            'code' => 'MD120',
            'stock' => 120,
            'available' => true,
        ]);

        Dimension::firstOrCreate([
            'height' => 120,
            'width' => 140,
        ], [
            'code' => 'MD140',
            'stock' => 140,
            'available' => true,
        ]);

        Dimension::firstOrCreate([
            'height' => 220,
            'width' => 240,
        ], [
            'code' => 'MD240',
            'stock' => 240,
            'available' => true,
        ]);
    }
}
