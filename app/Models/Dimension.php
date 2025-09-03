<?php

namespace App\Models;

use App\Models\Scopes\Product\AverageSalesForLastDaysScope;
use App\Models\Traits\ScopeTrait;
use App\Observers\DimensionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;

#[ObservedBy([DimensionObserver::class])]
class Dimension extends Model
{
    use HasFactory, SoftDeletes, ScopeTrait, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'height',
        'width',
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
        'label',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'code' => '',
        'height' => 0,
        'width' => 0,
        'visible' => TRUE,
        'description' => '',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'height' => 'integer',
            'width' => 'integer',
            'visible' => 'bool',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }

    /**
     * Defines the "one-to-many" relationship between Dimension and Product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope to include the count of products associated with each dimension.
     *
     * This scope allows querying dimensions along with an additional field that contains
     * the number of products linked to each dimension.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The Eloquent query builder instance.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithProductCount(Builder $query)
    {
        return $query->withCount('products');
    }

    /**
     * This attribute formats the height and width of the dimension into a
     * readable label (e.g., "120x200").
     *
     * @return string
     */
    public function getLabelAttribute(): string
    {
        return "{$this->height}x{$this->width}";
    }

    /**
     * Return route edit model
     *
     * @return string
     */
    public function getRouteEditAttribute (): string
    {
        return route('dimensions.model', [
            'model' => $this->id
        ]);
    }

    /**
     * Return route show model
     *
     * @return string
     */
    public function getRouteShowAttribute (): string
    {
        return route('dimensions.show', [
            'model' => $this->id
        ]);
    }
}
