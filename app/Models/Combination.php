<?php

namespace App\Models;

use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Base;
use App\Observers\CombinationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
 
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

#[ObservedBy([CombinationObserver::class])]
class Combination extends Model
{
    use HasFactory, SoftDeletes, ScopeTrait, LogsActivity;
    
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stock',
        'name',
        'dimension_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'dimension_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'stock' => 0,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stock' => 'integer'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty();
    }
    
    public function code()
    {
        return $this->morphOne(Code::class, 'model');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Get the Dimension that owns the Base.
     */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class)->withTrashed();
    }

    public function cover()
    {
        return $this->hasOneThrough(Product::class, CombinationProduct::class, 'combination_id', 'id', 'id', 'product_id')
            ->with('code')
            ->where('type', 'cover');
    }

    public function top()
    {
        return $this->hasOneThrough(Product::class, CombinationProduct::class, 'combination_id', 'id', 'id', 'product_id')
            ->with('code')
            ->where('type', 'top');
    }

    public function base()
    {
        return $this->hasOneThrough(Product::class, CombinationProduct::class, 'combination_id', 'id', 'id', 'product_id')
            ->with('code')
            ->where('type', 'base');
    }

    /**
     * Descrement parts
     *
     * @param integer $quantity
     * @return void
     */
    public function decrementParts (int $quantity):void
    {
        $this->products()->decrement('stock', $quantity);
    }

    /**
     * Descrement parts
     *
     * @param integer $quantity
     * @return void
     */
    public function manufacture (int $quantity):void
    {
        $this->decrementParts($quantity);

        $this->increment('stock', $quantity);
    }
}
