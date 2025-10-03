<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
class ProductSale extends Model
{
    use HasFactory;

    protected $table = "product_sale";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id',
        'CANLFA', // CANTIDAD DEL PRODUCTO
        'ARTLFA', // CÓDIGO DEL ARTÍCULO
        'TOTLFA', // TOTAL DE LA LINEA DE LA FACTURA
        'DESLFA', // DESCRIPCIÓN
        'product_lot_id',
        'processed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }

    /**
     * Belongs to a product, including soft-deleted ones.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'ARTLFA', 'code')->withTrashed();
    }

    /**
     * Belongs to a sale
     *
     * @return BelongsTo
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(FactusolSale::class, 'sale_id', 'id');
    }

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
     * Has one special measurement
     *
     * @return HasOne
     */
    public function special_measurement(): HasOne
    {
        return $this->hasOne(SpecialMeasurement::class);
    }

    /**
     * Is Manufactured
     *
     * @return bool
     */
    public function getIsManufacturedAttribute () : bool
    {
        return $this->manufactured_quantity > 0;
    }

    public function isPending() : Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->processed_at) && $this->product_lot_id,
        );
    }

    public function isIncomplete() : Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->product_lot_id),
        );
    }

    public function isProcessed() : Attribute
    {
        return Attribute::make(
            get: fn () => !is_null($this->processed_at) && $this->product_lot_id,
        );
    }

    /**
     * Decrement Stock
     *
     * @return void
     */
    public function decrementStockProductSale() : void
    {
        if ($this->product_lot) {

            $this->product_lot->decrementProductLotStock($this->CANLFA);

            $this->processed_at = Carbon::now();

            $this->save();
        }
    }
}
