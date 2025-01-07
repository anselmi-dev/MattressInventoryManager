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

        $subQuery = \DB::table('product_sale')
            ->selectRaw('ARTLFA, CANLFA, SUM(CANLFA) as total_sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('ARTLFA');

        $builder->leftJoinSub($subQuery, 'sales', function($join) {
            $join->on('products.code', '=', 'sales.ARTLFA');
        })
        ->selectRaw("products.*, (
            CASE 
            WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
            ELSE CAST((COALESCE(sales.total_sales, 0) / ?) as DOUBLE)
            END
        ) as average_sales_media", [$days])
        ->selectRaw("products.*, (
            CASE 
            WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
            ELSE CAST((
            (CASE 
                WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
                ELSE CAST((COALESCE(sales.total_sales, 0) / ?) as DOUBLE)
            END)
            * ?) as DOUBLE)
            END
        ) as average_sales_quantity", [$days, $stock_days])
        ->selectRaw("(
                CASE 
                    WHEN COALESCE(total_sales, 0) = 0 THEN CAST(products.stock as DOUBLE)
                    ELSE
                        (
                        CASE
                            WHEN products.stock < 0 THEN (COALESCE(

                            (
                                CASE 
                                WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
                                ELSE CAST((
                                (CASE 
                                    WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
                                    ELSE CAST((COALESCE(sales.total_sales, 0) / ?) as DOUBLE)
                                END)
                                * ?) as DOUBLE)
                                END
                            )
                            
                            , 0) - products.stock)
                        ELSE
                            (products.stock - COALESCE(
                            (
                                CASE 
                                WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
                                ELSE CAST((
                                (CASE 
                                    WHEN COALESCE(sales.total_sales, 0) = 0 THEN CAST(0 as DOUBLE)
                                    ELSE CAST((COALESCE(sales.total_sales, 0) / ?) as DOUBLE)
                                END)
                                * ?) as DOUBLE)
                                END
                            )

                            , 0))
                        END
                        )
                    END
                    ) as average_sales_difference", [
                        $days, $stock_days, $days, $stock_days
                    ]);
    }
}
