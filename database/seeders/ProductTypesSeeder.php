<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = [
            [
                'name' => 'COLCHON',
                'part' => true,
                'contains' => [
                    'COLCHON'
                ]
            ],
            [
                'name' => 'BASE',
                'contains' => [
                    ''
                ]
            ],
            [
                'name' => 'FUNDA',
                'contains' => [
                    'FUNDA'
                ]
            ],
            [
                'name' => 'ALMOHADA',
                'contains' => [
                    'ALMOHADA'
                ]
            ]
        ];

        foreach ($collection as $item) {
            ProductType::firstOrCreate($item);
        }
    }
}
