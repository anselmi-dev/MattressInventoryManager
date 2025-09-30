<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Casts\StatusOrderProductCast;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = "order_product";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'order_id',
        'attribute_data',
        'status',
        'quantity',
        'return',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'attribute_data' => 'array',
            'status' => StatusOrderProductCast::class
        ];
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
