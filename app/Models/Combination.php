<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Combination extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'combined_product_id'
    ];

    /**
     * Relación con el producto combinado
     *
     * @return BelongsTo
     */
    public function combinedProduct() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'combined_product_id');
    }

    /**
     * Relación con el producto que forma parte de la combinación
     *
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
