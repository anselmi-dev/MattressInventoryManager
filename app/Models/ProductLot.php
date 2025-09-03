<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\ProductLotObserver;

#[ObservedBy([ProductLotObserver::class])]
class ProductLot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'reference',
        'quantity',
        'created_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Belongs to a product
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'reference', 'reference');
    }

    public function productParts(): HasMany
    {
        return $this->hasMany(ProductPart::class);
    }

    /**
     * The related product lots that belong to this product lot.
     */
    public function relatedLots(): HasMany
    {
        return $this->hasMany(ProductLotPivot::class);
    }

    public function scopeWhereIsPart(Builder $query): Builder
    {
        return $query->whereHas('product', function (Builder $query) {
            $query->whereNotCombinations();
        });
    }
}
