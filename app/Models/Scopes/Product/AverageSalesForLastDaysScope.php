<?php

namespace App\Models\Scopes\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

        // $builder->leftJoin('product_lots', 'product_lots.reference', '=', 'products.reference')
        //     ->leftJoin('product_sale', function($join) use ($startDate, $endDate) {
        //         $join->on('product_sale.ARTLFA', '=', 'products.code')
        //             ->whereBetween('product_sale.created_at', [$startDate, $endDate]);
        //     })
        //     ->select('products.*')
        //     ->selectRaw('CAST(COALESCE(SUM(product_lots.quantity), 0) as DOUBLE) as STOCK_LOTES')
        //     ->selectRaw('CAST(COALESCE(SUM(product_sale.CANLFA), 0) as DOUBLE) as AVERAGE_SALES')
        //     ->selectRaw('CAST(COALESCE(SUM(product_sale.CANLFA), 0) / ? AS DOUBLE) as AVERAGE_SALES_PER_DAY', [$stock_days])
        //     ->selectRaw('(CAST(COALESCE(SUM(product_lots.quantity), 0) as DOUBLE) - CAST(COALESCE(SUM(product_sale.CANLFA), 0) as DOUBLE)) as AVERAGE_SALES_DIFFERENCE')
        //     ->groupBy('products.id');

        $builder->select('products.*')
            ->addSelect([
                'LOTES_COUNT' => DB::table('product_lots')->whereColumn('product_lots.reference', 'products.reference')->selectRaw("COUNT(*)")->take(1),
                'STOCK_LOTES' => DB::table('product_lots')->whereColumn('product_lots.reference', 'products.reference')->selectRaw("CAST(COALESCE(SUM(quantity), 0) as DOUBLE)")->take(1),
                // Total de ventas ocurridas en un periodo
                'AVERAGE_SALES' => DB::table('product_sale')->whereColumn('product_sale.ARTLFA', 'products.code')->whereBetween('product_sale.created_at', [$startDate, $endDate])->selectRaw("CAST(COALESCE(SUM(product_sale.CANLFA), 0) AS DOUBLE)")->take(1),
                // Promedio de ventas por día en un periodo
                'AVERAGE_SALES_PER_DAY' => DB::table('product_sale')->selectRaw('CAST((AVERAGE_SALES / ?) AS DOUBLE)', [$stock_days])->take(1),
                // Diferencia entre el stock y el promedio de ventas por día en un periodo
                'AVERAGE_SALES_DIFFERENCE' => DB::table('product_sale')->selectRaw('CAST(STOCK_LOTES - AVERAGE_SALES AS DOUBLE)')->take(1),
            ]);
    }
}
