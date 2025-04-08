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
    // Esto tenemos que hacer lo siguiente:
    // - Si stock_actual >= 1.2*stock_requerido = verde
    // - Si stock_actual >= 1*stock_requerido && stock_actual < 1.2*stock_requerido = naranja
    // - Si stock_actual < stock_requerido = rojo
    function color_average_stock (int $stock, $AVERAGE_SALES)
    {
        if ($stock < 0)
            return 'red';

        if ($AVERAGE_SALES >= ($stock * 1.2))
            return 'green';

        if ($AVERAGE_SALES >= ($stock * 1) && $stock < 1.2 * $AVERAGE_SALES)
            return 'orange';

        if ($stock < $AVERAGE_SALES)
            return 'red';

        return 'emerald';
    }
}

if (!function_exists('color_stock')) {
    function color_stock (int $stock)
    {
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