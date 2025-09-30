<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Observers\StockChangeObserver;

#[ObservedBy([StockChangeObserver::class])]
class StockChange extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_lot_id',
        'quantity',
        'operation_type',
        'old',
        'new',
        'message',
    ];

    /**
     * Belongs to a product lot
     *
     * @return BelongsTo
     */
    public function product_lot(): BelongsTo
    {
        return $this->belongsTo(ProductLot::class);
    }

    /**
     * Get the product through the product lot relationship
     */
    public function getProductAttribute()
    {
        return $this->productLot?->product;
    }

    public function getIsProcessedAttribute ()
    {
        return $this->status == 'processed';
    }

    public function getIsPendingAttribute ()
    {
        return $this->status == 'pending';
    }

    public function setStatusProcessed ()
    {
        $this->status = 'processed';

        $this->save();
    }

    public function setStatusPending ()
    {
        $this->status = 'pending';

        $this->save();
    }

    /**
     * Check if operation is add type
     */
    public function isAddOperation(): bool
    {
        return $this->operation_type === 'add';
    }

    /**
     * Check if operation is set type
     */
    public function isSetOperation(): bool
    {
        return $this->operation_type === 'set';
    }

    /**
     * Set operation type to add
     */
    public function setAddOperation(): void
    {
        $this->operation_type = 'add';
    }

    /**
     * Set operation type to set
     */
    public function setSetOperation(): void
    {
        $this->operation_type = 'set';
    }
}
