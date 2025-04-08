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
     * 
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $days = (int) settings()->get('stock:media:days', 10);
        
        $stock_days = (int) settings()->get('stock:days', 10);

        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        $endDate = Carbon::now()->endOfDay();

        // OBTENER EL TOTAL DE LAS VENTAS EN UN PERIODO
        $subqueryTotalSales = "CAST(COALESCE(SUM(product_sale.CANLFA), 0) AS DOUBLE)";

        // OBTENER EL PROMEDIO DE LAS VENTAS EN UN PERIODO
        // TOTAL_SALES / DÍAS = PROMEDIO POR DÍA
        $subqueryAverageSalesPerDay = "($subqueryTotalSales / $days)";

        $builder
            ->leftJoin('product_sale', function ($join) use ($startDate, $endDate) {
                $join->on('product_sale.ARTLFA', '=', 'products.code')
                     ->whereBetween('product_sale.created_at', [$startDate, $endDate]);
            })
            ->select('products.*')
            ->selectRaw("$subqueryTotalSales as TOTAL_SALES")
            ->selectRaw("$subqueryAverageSalesPerDay as AVERAGE_SALES_PER_DAY")
            ->selectRaw("($subqueryAverageSalesPerDay * $stock_days) as AVERAGE_SALES")
            ->selectRaw("(CAST(products.stock as DOUBLE)) - ($subqueryAverageSalesPerDay * $stock_days) as AVERAGE_SALES_DIFFERENCE")
            ->groupBy('products.id');
    }
}
