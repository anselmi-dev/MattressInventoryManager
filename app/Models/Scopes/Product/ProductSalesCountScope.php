<?php

namespace App\Models\Scopes\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ProductSalesCountScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->withSum([
            'product_sales as product_sales_count' => function($query) {
                $query->select(\DB::raw("CAST(SUM(CANLFA) as DOUBLE)"));
            },
        ], 'CANLFA');
    }
}
