<?php

namespace App\Models;

use App\Models\Scopes\Product\QuantitySalesScope;
use App\Observers\SaleObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FactusolSale extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'CODFAC', // CÓDIGO DE LA FACTURA
        'TOTFAC', // TOTAL DE LA FACTURA
        'CLIFAC',  // CÓDIGO DEL CLIENTE
        'CNOFAC',  // NOMBRE DEL CLIENTE
        'CEMFAC',  // CORREO DEL CLIENTE
        'ESTFAC',  // ESTATUS DE LA FACTURA
        'FECFAC',  // FECHA DE CREACIÓN
        'IIVA1FAC', // IMPORTE DE LA FACTURA
        'NET1FAC', // IMPORTE NETO
        'TIPFAC', // TIPO DE FACTURA
        'IREC1FAC', // TARIFA ADICIONAL
    ];

    protected $casts = [
        'FECFAC' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'FECFAC' => 'datetime',
        ];
    }

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new QuantitySalesScope);
    }

    /**
     * Get the product sales associated with the sale.
     *
     * @return HasMany
     */
    public function product_sales(): HasMany
    {
        return $this->hasMany(ProductSale::class, 'sale_id', 'id');
    }

    /**
     * Get the product sales special measures associated with the sale.
     *
     * @return HasMany
     */
    public function product_sales_special_measures(): HasMany
    {
        return $this->hasMany(ProductSale::class)->where('DESLFA', 'like', "%MED. ESPECIAL%")->orWhere('DESLFA', 'like', "%MEDIDA ESPECIAL%");
    }

    /**
     * Get the products associated with the sale.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sale', 'sale_id', 'ARTLFA', 'id', 'code')->withTimestamps();
    }

    public function decrementStock(): void
    {
        if ($this->getIsProcessedAttribute()) {

            $product_sales = $this->products()->whereHas('product')->with('product')->get();

            foreach ($this->product_sales as $product_sales) {
                $product_sales->decrementStock();
            }
        }
    }

    public function getIsProcessedAttribute(): bool
    {
        return $this->ESTFAC == 2;
    }

    public function getStatusAttribute(): string
    {
        switch ($this->ESTFAC) {
            case 0:
                return 'pending';
                break;
            case 1:
                return 'pending';
                break;
            case 2:
                return 'processed';
                break;
            case 4:
                return 'error';
                break;
            default:
                return '-';
                break;
        }
    }
}
