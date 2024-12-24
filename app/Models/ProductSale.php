<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->belongsTo(Sale::class);
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
     * Decrement Stock
     *
     * @return void
     */
    public function decrementStock() : void
    {
        if ($this->product)
        {
            $this->product->decrementStock($this->CANLFA);

            $this->processed_at = Carbon::now();

            $this->save();
        }
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
}
