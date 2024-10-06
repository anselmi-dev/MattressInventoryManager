<?php

namespace App\Models\Scopes\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Carbon\Carbon;

class AverageSalesForLastDaysScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $days = (int) settings()->get('stock:media:days', 10);

        $stock_days = (int) settings()->get('stock:days', 10);
        
        $startDate = Carbon::now()->subDays($days);
        
        $endDate = Carbon::now();

        $builder
            ->withCount([
                // Obtener la cantidad total de ventas en el periodo
                'product_sales as sales_count' => function($query) use ($startDate, $endDate, $days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->selectRaw('count(*) / ?', [$days]);
                },
                // Obtener la cantidad de ventas del producto por su cantidad vendida
                // Es decir, si han ocurrido 3 ventas de ese producto en el periodo, se suman la cantidad vendida para obtener el total
                'product_sales as quantity_sales' => function($query) use ($startDate, $endDate, $days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("CAST(COALESCE(SUM(CANLFA), 0) as DOUBLE)"));
                }
            ])
            ->withSum([
                // Obtener la media de venta del producto en un periodo
                'product_sales as average_sales_media' => function($query) use ($startDate, $endDate, $days, $stock_days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("(
                            CASE 
                                WHEN COALESCE(SUM(CANLFA), 0) = 0 THEN CAST(0 as DOUBLE)
                                ELSE CAST((COALESCE(SUM(CANLFA), 0) / $days) as DOUBLE)
                                END
                                )"));
                },
                // Se obtiene la cantidad de productos que se debe tener en los próximos días ($stock_days)
                'product_sales as average_sales_quantity' => function($query) use ($startDate, $endDate, $days, $stock_days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("(
                            CASE 
                                WHEN COALESCE(SUM(CANLFA), 0) = 0 THEN CAST(0 as DOUBLE)
                                ELSE CAST((average_sales_media * $stock_days) as DOUBLE)
                                END
                                )"));
                },
                // Se obtiene la diferencia que hay entre el stock y la cantidad que debe tener en los próximos días 
                'product_sales as average_sales_difference' => function($query) use ($startDate, $endDate, $days, $stock_days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("(
                            CASE 
                                WHEN COALESCE(SUM(CANLFA), 0) = 0 THEN CAST(products.stock as DOUBLE)
                                ELSE
                                    (
                                    CASE
                                        WHEN products.stock < 0 THEN (COALESCE(average_sales_quantity, 0) - products.stock)
                                    ELSE
                                        (products.stock - COALESCE(average_sales_quantity, 0))
                                    END
                                    )
                                END
                                )"));
                                
                }
            ], 'quantity');
    }
}
