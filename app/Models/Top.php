<?php

namespace App\Models;

use App\Models\Traits\ScopeTrait;
use App\Observers\TopObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
 
#[ObservedBy([TopObserver::class])]
class Top extends Model
{
    use HasFactory, SoftDeletes, ScopeTrait;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'dimension_id',
        'visible',
        'stock',
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

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'stock' => 0,
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
            'visible' => 'bool',
            'stock' => 'integer'
        ];
    }

    /**
     * Get the Base for the Top.
     */
    public function base (): HasMany
    {
        return $this->hasMany(Base::class)->withTrashed();
    }

    /**
     * Get the Dimension that owns the Base.
     */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class)->withTrashed();
    }
}
