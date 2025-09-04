<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\ScopeTrait;
use Closure;
use App\Observers\ProductObserver;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\Product\{
    AverageSalesForLastDaysScope,
    StockOrderScope,
    StockLotsScope
};
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, ScopeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'reference',
        'type',
        'dimension_id',
        'minimum_order_notification_enabled',
        'minimum_order',
        'stock',
        'visible',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
    ];

    protected $with = ['productType'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'code' => '',
        'type' => '',
        'stock' => 0,
        'minimum_order' => 0,
        'minimum_order_notification_enabled' => FALSE,
        'visible' => TRUE,
        'description' => '',
    ];

    public function getRouteKeyName() {
        return 'id';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'minimum_order_notification_enabled' => 'bool',
            'minimum_order' => 'integer',
            'visible' => 'bool',
            'stock' => 'integer'
        ];
    }

    /**
     * Get the type of product.
     *
     * @return BelongsTo
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * Return is combination
     *
     * @return bool
     */
    public function getIsCombinationAttribute () : bool
    {
        return $this->productType?->part == false;
    }

    /**
     * Return color of stock
     *
     * @return string|null
     */
    public function getStockColorAttribute () : string|null
    {
        return color_average_stock($this->stock, $this->AVERAGE_SALES);
    }

    /**
     * Belongs to a dimension, including soft-deleted ones.
     *
     * @return BelongsTo
     */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class)->withTrashed();
    }

    /**
     * Has Many to a ProductLot
     *
     * @return HasMany
     */
    public function lots(): HasMany
    {
        return $this->hasMany(ProductLot::class, 'reference', 'reference');
    }

    /**
     * Has Many to a StockChange
     *
     * @return HasMany
     */
    public function stock_change(): HasMany
    {
        return $this->hasMany(StockChange::class);
    }

    /**
     * Relación muchos a muchos para productos combinados
     *
     * @return BelongsToMany
     */
    public function combinedProducts() : BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'combinations', 'combined_product_id', 'product_id');
    }

    /**
     * Has One to a FactusolProduct
     *
     * @return HasOne
     */
    public function factusolProduct(): HasOne
    {
        return $this->hasOne(FactusolProduct::class, 'CODART', 'code');
    }

    /**
     * Relación inversa de muchos a muchos para productos que son parte de combinaciones
     *
     * @return BelongsToMany
     */
    public function partOfCombinations() : BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'combinations', 'product_id', 'combined_product_id');
    }

    /**
     * Has Many to a OrderProduct
     *
     * @return HasMany
     */
    public function order_products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * Belongs to a Order
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, OrderProduct::class);
    }

    /**
     * Belongs to a Sale
     *
     * @return BelongsToMany
     */
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'product_sale', 'ARTLFA', 'sale_id', 'code', 'id');
    }

    /**
     * Has Many to a ProductPart
     *
     * @return HasMany
     */
    public function productParts(): HasMany
    {
        return $this->hasMany(ProductPart::class);
    }

    /**
     * Has Many to a ProductSale
     *
     * @return HasMany
     */
    public function product_sales(): HasMany
    {
        return $this->hasMany(ProductSale::class, 'ARTLFA', 'code');
    }

    /**
     * Has One to a ProductType
     *
     * @return HasOne
     */
    public function productType(): HasOne
    {
        return $this->hasOne(ProductType::class, 'name', 'type');
    }

    /**
     * Scope para agregar una columna que indique si el producto tiene una orden de pedido.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeStockOrder(Builder $query): void
    {
        $query->withGlobalScope('stock_order', new StockOrderScope());
    }

    /**
     * Scope para agregar una columna que indique si el producto tiene una media de ventas.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeAverageSalesForLastDays(Builder $query): void
    {
        $query->withGlobalScope('average_sales', new AverageSalesForLastDaysScope());
    }

    /**
     * Scope para agregar una columna que indique si el producto tiene relación con factusolProduct.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeWithFactusolPresence(Builder $query): void
    {
        $query->selectRaw(
            'products.*,
             CASE
                WHEN factusol_products.CODART IS NOT NULL THEN 1
                ELSE 0
             END as has_factusol_product'
        )->leftJoin('factusol_products', 'factusol_products.CODART', '=', 'products.code');
    }

    /**
     * Scope para agregar una columna que indique si el producto no es una combinación.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeWhereNotCombinations(Builder $query): void
    {
        $query->whereHas('productType', fn (Builder $query) => $query->where('part', true));
    }

    /**
     * Scope para agregar una columna que indique si el producto es una combinación.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeWhereCombinations(Builder $query): void
    {
        $query->whereHas('productType', fn (Builder $query) => $query->where('part', false));
    }

    /**
     * Descrement parts
     *
     * @param int $quantity
     * @return void
     */
    public function decrementStock (int $quantity) : void
    {
        $this->update([
            'stock' => $this->stock - $quantity
        ]);
    }

    /**
     * Descrement parts
     *
     * @param integer $quantity
     * @return void
     */
    public function decrementStockProducts (int $quantity):void
    {
        $this->productParts()->get()->map(function($product) use ($quantity) {
            $product->productLot->quantity -= $quantity;
            $product->productLot->save();
        });
    }

    /**
     * Manufacture combination
     *
     * @param integer $quantity
     * @return void
     */
    public function manufacture (int $quantity):void
    {
        $this->decrementStockProducts($quantity);

        $this->update([
            'stock' => $this->stock + $quantity
        ]);
    }

    /**
     * Manufacture combination
     *
     * @param ProductLot $productLot
     * @param integer $quantity
     * @return void
     */
    public function manufactureLot (ProductLot $productLot, int $quantity, bool $decrementStock = true):void
    {
        $productLot->update([
            'quantity' => $productLot->quantity + $quantity
        ]);

        if ($decrementStock)
            $productLot->relatedLots()->get()->map(function($item) use ($quantity) {
                $item->relatedLot->quantity -= $quantity;
                $item->relatedLot->save();
            });
    }

    public function validateStockManufacture (int $quantity) : int|null
    {
        $productLotFail = $this->getProductPartsOutStockManufacture($quantity);

        if ($productLotFail) {
            throw new \Exception('La cantidad máxima para fabricar la combinación es ' . $productLotFail->quantity);
        }

        return true;
    }
}
