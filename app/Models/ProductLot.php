<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function stock_change(): HasMany
    {
        return $this->hasMany(StockChange::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'reference', 'reference');
    }

    public function productParts(): HasMany
    {
        return $this->hasMany(ProductPart::class);
    }

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

    public function decrementProductLotStock(int $quantity): void
    {
        $this->decrement('quantity', $quantity);

        // $this->decrementRelatedProductLot($quantity);
    }

    public function manufactureLot(int $quantity, bool $decrementStock = true): void
    {
        $this->increment('quantity', $quantity);

        if ($decrementStock) {
            $this->decrementRelatedProductLot($quantity);
        }
    }

    protected function decrementRelatedProductLot(int $quantity): void
    {
        // Descrementar el stock de los lotes relacionados
        // Esto se hace para que cuando se descremente el stock de un lote, se descremente el stock de los lotes relacionados
        // Esto aplica solo para cuando es una combinación (Colchon)
        $this->relatedLots->map(function(ProductLotPivot $relatedLotPivot) use ($quantity) {
            $relatedLotPivot->relatedLot->decrementProductLotStock($quantity);
        });
    }
}
