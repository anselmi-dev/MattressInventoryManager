<?php

namespace Database\Seeders;

use App\Models\Code;
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
        foreach ([
            100,
            150
        ] as $key => $value) {
            $dimension = Dimension::firstOrCreate([
                'code' => 'DIMEN00' . $key,
            ], [
                'height' => $value,
                'width' => $value,
                'visible' => true,
            ]);
        }
    }
}
