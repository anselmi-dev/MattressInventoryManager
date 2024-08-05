<?php

namespace Database\Seeders;

use App\Models\Dimension;
use App\Models\Top;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Top::firstOrCreate([
            'code' => 'TAP0001',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 200,
        ]);

        Top::firstOrCreate([
            'code' => 'TAP0002',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 150,
        ]);

        Top::firstOrCreate([
            'code' => 'TAP0003',
            'dimension_id' => Dimension::inRandomOrder()->first()->id
        ], [
            'stock' => 10,
        ]);
    }
}
