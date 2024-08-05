<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopeTrait
{
    /**
     * Scope a query to only include avaiable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query)
    {
        return $query->where('visible', true);
    }

    /**
     * Scope a query to only include stock.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include stock.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnavailable(Builder $query)
    {
        return $query->where('stock', '>', 0);
    }
}