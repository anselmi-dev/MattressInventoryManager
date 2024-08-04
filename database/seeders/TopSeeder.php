<?php

namespace Database\Seeders;

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
            'code' => 'AS12',
            'height' => 5,
        ], [
            'stock' => 200,
            'description' => 'Tapa de 5cm',
        ]);

        Top::firstOrCreate([
            'code' => 'AS13',
            'height' => 6,
        ], [
            'stock' => 150,
            'description' => 'Tapa de 6cm',
        ]);
    }
}
