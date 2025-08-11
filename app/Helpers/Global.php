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
    // 2 100
    function color_average_stock (int $stock, $AVERAGE_SALES)
    {
        // Si el stock es negativo y la media de ventas es 0
        if ($stock < 0 && $AVERAGE_SALES == 0)
            return 'orange';

        // Si el stock es negativo y la media de ventas es 0
        if ($stock == 0 && $AVERAGE_SALES == 0)
            return 'gray';

        // Si el stock es menor que la media de ventas
        if ($AVERAGE_SALES > $stock)
            return 'red';

        if ($AVERAGE_SALES <= $stock && $AVERAGE_SALES == 0) {
            return 'blue';
        }

        // Si el stock es mayor o igual que la media de ventas
        if (ceil($AVERAGE_SALES * 1.2) <= $stock)
            return 'emerald';

        if ($AVERAGE_SALES <= $stock)
            return 'blue';

        return 'orange';
    }
}

if (!function_exists('message_average_stock')) {
    // Esto tenemos que hacer lo siguiente:
    // - Si stock_actual >= 1.2*stock_requerido = verde
    // - Si stock_actual >= 1*stock_requerido && stock_actual < 1.2*stock_requerido = naranja
    // - Si stock_actual < stock_requerido = rojo
    // 2 100
    function message_average_stock (int $stock, $AVERAGE_SALES, $AVERAGE_SALES_DIFFERENCE = 0)
    {
        // $media = $stock > 0 ? ($AVERAGE_SALES / $stock) * 100 : 0;
        // $message .= "AVERAGE_SALES_DIFFERENCE {$AVERAGE_SALES_DIFFERENCE} <br>";
        // $message .= "AVERAGE_SALES {$AVERAGE_SALES} <br>";
        // $message .= "AVERAGE_SALES_PER_DAY {$AVERAGE_SALES_PER_DAY} <br>";
        // $message .= "TOTAL_SALES {$TOTAL_SALES} <br>";
        // $message .= "sales {$sales} <br>";
        // Si el stock es negativo y la media de ventas es 0
        $days = (int) settings()->get('stock:media:days', 10);

        $stock_days = (int) settings()->get('stock:days', 10);

        if ($stock < 0 && $AVERAGE_SALES == 0) {
            return 'El stock es negativo';
        }

        // Si el stock es negativo y la media de ventas es 0
        if ($stock == 0 && $AVERAGE_SALES == 0)
            return "En {$days} días no se vendieron unidades además del stock actual es cero (0)";

        // Si el stock es menor que la media de ventas
        if ($AVERAGE_SALES > $stock) {
            $AVERAGE_SALES_DIFFERENCE = abs($AVERAGE_SALES_DIFFERENCE);
            return "Se requiere {$AVERAGE_SALES_DIFFERENCE} unidades para cubrir las ventas en {$stock_days} días, pero el stock actual es {$stock} unidades";
        }

        if ($AVERAGE_SALES <= $stock && $AVERAGE_SALES == 0) {
            return "Posee {$stock} unidades, pero no se vendieron unidades en las últimas {$days} días";
        }

        // Si el stock es mayor o igual que la media de ventas
        // if (ceil($AVERAGE_SALES * 1.2) <= $stock) {
        //     $PERCENTAGE = $stock - $AVERAGE_SALES_DIFFERENCE;
        //     return "Posee un {$PERCENTAGE}% más de lo necesario para cubrir las ventas en {$stock_days} días";
        // }

        if ($AVERAGE_SALES <= $stock)
            return "Posee {$stock} unidades, lo que es suficiente para cubrir las ventas en {$stock_days} días";

        return '';
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
