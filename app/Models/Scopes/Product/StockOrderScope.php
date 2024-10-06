<?php

namespace App\Models\Scopes\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StockOrderScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->withSum([
            'order_products as stock_order' => function($query) {
                $query->where('status', 'pending')
                    ->select(\DB::raw("CAST(COALESCE(SUM(quantity), 0) as DOUBLE)"));
            },
        ], 'quantity');
    }
}
