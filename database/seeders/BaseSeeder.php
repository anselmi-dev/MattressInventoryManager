<?php

namespace Database\Seeders;

use App\Models\Base;
use App\Models\Dimension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Base::firstOrCreate([
            'code' => 'MD120',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 120,
            'visible' => true,
        ]);

        Base::firstOrCreate([
            'code' => 'MD140',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 140,
            'visible' => true,
        ]);

        Base::firstOrCreate([
            'code' => 'MD240',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 240,
            'visible' => true,
        ]);
    }
}
