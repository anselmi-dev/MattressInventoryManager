<?php

namespace App\Models\Scopes\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class StockLotsScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->withSum([
            'lots as stock_lots' => function($query) {
                $query->select(DB::raw("CAST(COALESCE(SUM(quantity), 0) as DOUBLE)"));
            },
        ], 'stock_lots');
    }
}
