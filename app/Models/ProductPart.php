<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'product_lot_id',
        'quantity'
    ];

    /**
     * Belongs to a product
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Belongs to a product lot
     *
     * @return BelongsTo
     */
    public function productLot(): BelongsTo
    {
        return $this->belongsTo(ProductLot::class);
    }
}
