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
            150,
            200,
            250,
            300,
            350,
            400,
        ] as $key => $value) {
            $dimension = Dimension::firstOrCreate([
                'height' => $value,
                'width' => $value,
            ], [
                'visible' => true,
            ]);

            if ($dimension->wasRecentlyCreated) {

                $code = new Code(["value" => 'DIMEN00' . $key]);
                
                $dimension->code()->save($code);
            }
        }
    }
}
