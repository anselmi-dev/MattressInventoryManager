<?php

use App\Models\{
    Combination,
    Dimension,
    Product,
};
use Illuminate\Support\Facades\Cache;

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

if (!function_exists('count_bases')) {
    function count_bases ()
    {
        return Cache::remember('count:bases', 1000, function () {
            return Product::where('type', 'base')->visible()->count();
        });
    }
}

if (!function_exists('count_covers')) {
    function count_covers ()
    {
        return Cache::remember('count:covers', 1000, function () {
            return Product::where('type', 'cover')->visible()->count();
        });
    }
}

if (!function_exists('count_tops')) {
    function count_tops ()
    {
        return Cache::remember('count:tops', 1000, function () {
            return Product::where('type', 'top')->visible()->count();
        });
    }
}

if (!function_exists('count_combinations')) {
    function count_combinations ()
    {
        return Cache::remember('count:combinations', 100, function () {
            return Combination::count();
        });
    }
}

if (!function_exists('appendCentimeters')) {
    function appendCentimeters (int|string $number)
    {
        $number = str_replace('.00', '', $number);

        return "{$number}cm";
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
            return 'emerald';
    
        return 'yellow';
    }
}