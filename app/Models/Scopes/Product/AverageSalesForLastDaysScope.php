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
        $stock_days = (int) settings()->get('stock:days', 10);

        $days = (int) settings()->get('stock:media:days', 10);

        $startDate = Carbon::now()->subDays($days);
        
        $endDate = Carbon::now();

        $builder
            ->withCount([
                'product_sales as sales_count' => function($query) use ($startDate, $endDate, $days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->selectRaw('count(*) / ?', [$days]);
                },
                'product_sales as quantity_sales' => function($query) use ($startDate, $endDate, $days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("SUM(quantity)"));
                }
            ])
            ->withSum([
                'product_sales as average_sales_media' => function($query) use ($startDate, $endDate, $days, $stock_days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("(
                            CASE 
                                WHEN COALESCE(SUM(quantity), 0) = 0 THEN CAST(0 as DOUBLE)
                                ELSE CAST((COALESCE(SUM(quantity), 0) / $days) as DOUBLE)
                                END
                                )"));
                },
                'product_sales as average_sales_quantity' => function($query) use ($startDate, $endDate, $days, $stock_days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("(
                            CASE 
                                WHEN COALESCE(SUM(quantity), 0) = 0 THEN CAST(0 as DOUBLE)
                                ELSE CAST((average_sales_media * $stock_days ) as DOUBLE)
                                END
                                )"));
                },
                'product_sales as average_sales_difference' => function($query) use ($startDate, $endDate, $days, $stock_days) {
                    $query->whereBetween('created_at', [$startDate, $endDate])
                        ->select(\DB::raw("(
                            CASE 
                                WHEN COALESCE(SUM(quantity), 0) = 0 THEN CAST(products.stock as DOUBLE)
                                ELSE (products.stock - COALESCE(average_sales_quantity, 0))
                                END
                                )"));
                                
                }
            ], 'quantity');
    }
}
