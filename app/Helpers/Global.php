<?php

use Illuminate\Support\Facades\Cache;
use App\Models\{
    Dimension,
    Product,
};

if (!function_exists('count_dimensions')) {
    function count_dimensions ()
    {
        return Cache::remember('count:dimensions', 100, function () {
            return Dimension::visible()->count();
        });
    }
}

if (!function_exists('count_products')) {
    function count_products ()
    {
        return Cache::remember('count:products', 1000, function () {
            return Product::visible()->count();
        });
    }
}

if (!function_exists('count_combinations')) {
    function count_combinations ()
    {
        return Cache::remember('count:combinations', 1000, function () {
            return Product::whereCombinations()->visible()->count();
        });
    }
}

if (!function_exists('appendCentimeters')) {
    function appendCentimeters (int|string|null $number)
    {
        $number = str_replace('.00', '', $number);

        return $number ? "{$number}cm" : '-';
    }
}

if (!function_exists('color_average_stock')) {
    function color_average_stock (int $stock, $average_sales) {
        $media = $average_sales == 0 ? 0 : ($stock * 100 ) / $average_sales;
    
        if ($media > 110)
            return 'emerald';

        if ($media >= 100)
            return 'orange';

        return 'red';
    }
}

if (!function_exists('color_stock')) {
    function color_stock (int $stock) {

        $danger = Cache::rememberForever('alert:danger:stock', function() {
            return settings()->get('alert:danger', 50);
        });

        $warning = Cache::rememberForever('alert:warning:stock', function() {
            return settings()->get('alert:warning', 100);
        });

        if ($stock <= $danger)
            return 'red';
        
        if ($stock <= $warning)
            return 'yellow';
        
        return 'emerald';
    }
}