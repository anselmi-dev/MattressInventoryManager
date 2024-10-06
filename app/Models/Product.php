<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
 
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Traits\ScopeTrait;

use App\Observers\ProductObserver;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\Product\{
    AverageSalesForLastDaysScope,
    StockOrderScope
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
        'route_edit'
    ];

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
        'visible' => TRUE,
        'minimum_order_notification_enabled' => FALSE,
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
            'minimum_order' => 'bool',
            'visible' => 'bool',
            'minimum_order' => 'integer',
            'stock' => 'integer'
        ];
    }

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new AverageSalesForLastDaysScope);
        
        static::addGlobalScope(new StockOrderScope);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
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

    public function factusolProduct()
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

    public function order_products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, OrderProduct::class);
    }

    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'product_sale', 'ARTLFA', 'sale_id', 'code', 'id');
    }

    public function product_sales(): HasMany
    {
        return $this->hasMany(ProductSale::class, 'ARTLFA', 'code');
    }

    public function productType()
    {
        return $this->hasOne(ProductType::class, 'name', 'type');
    }

    public function scopeWhereBase(Builder $query)
    {
        $query->where('type', 'base');
    }

    public function scopeWhereNotCombinations(Builder $query)
    {
        return $query->whereHas('productType', function (Builder $query) {
            $query->where('part', true);
        });
    }

    public function scopeWhereCombinations(Builder $query)
    {
        return $query->whereHas('productType', function (Builder $query) {
            $query->where('part', false);
        });
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
        $this->combinedProducts()->get()->map(function($product) use ($quantity) {
            $product->decrementStock($quantity);
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
     * Return route edit model
     *
     * @return string
     */
    public function getRouteEditAttribute (): string
    {
        if ($this->type === 'combination') {
            return route('combinations.model', ['model' => $this->id]);
        }

        return route('products.model', ['model' => $this->id]);
    }

    /**
     * Return route edit model
     *
     * @return string
     */
    public function getRouteShowAttribute (): string
    {
        if ($this->type === 'combination')
            return route('combinations.show', ['model' => $this->id]);

        return route('products.show', ['model' => $this->id]);
    }

    /**
     * Return is combination
     *
     * @return bool
     */
    public function getIsCombinationAttribute () : bool
    {
        return $this->type == 'combination';
    }

    /**
     * Return color of stock
     *
     * @return string|null
     */
    public function getStockColorAttribute () : string|null
    {
        return color_average_stock($this->stock, $this->average_sales_quantity);
    }
}
