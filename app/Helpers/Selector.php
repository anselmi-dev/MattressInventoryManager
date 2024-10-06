<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Models\ProductType;
use App\Models\Dimension;

class  Selector 
{
    public static function productTypes ()
    {
        return Cache::rememberForever('selector:product_types', function () {
            $product_types =ProductType::whereNotCombination()
                ->orderBy('name')
                ->select('name')
                ->get()
                ->pluck('name', 'name')
                ->toArray();

            return [
                ...[
                    '' => 'Tipo de parte'
                ],
                ...$product_types
            ];
        });
    }

    public static function stocks ()
    {
        return [
            '' => __('All'),
            'available' => __('Available'),
            'unavailable' => __('Unavailable'),
        ];
    }

    public static function dimensions ()
    {
        return Cache::rememberForever('selector:dimensions', function () {
            return Dimension::orderBy('id')
                ->get()
                ->map(function ($dimension) {
                    return [
                        'value' => $dimension->id,
                        'label' => $dimension->code,
                        'description' => $dimension->description ?? $dimension->label
                    ];
                });
        });
    }
}