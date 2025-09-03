<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductLotPivot extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_lot_product_lot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_lot_id',
        'related_product_lot_id',
        'quantity',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the parent product lot.
     */
    public function parentLot()
    {
        return $this->belongsTo(ProductLot::class, 'product_lot_id');
    }

    /**
     * Get the related product lot.
     */
    public function relatedLot()
    {
        return $this->belongsTo(ProductLot::class, 'related_product_lot_id');
    }
}
