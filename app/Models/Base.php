<?php

namespace App\Models;

use App\Models\Traits\ScopeTrait;
use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
 
#[ObservedBy([BaseObserver::class])]
class Base extends Model
{
    use HasFactory, SoftDeletes, ScopeTrait;

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
        'code',
        'stock',
        'visible',
        'dimension_id',
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
        'code' => '',
        'stock' => 0,
        'visible' => TRUE
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'stock' => 'integer',
            'visible' => 'bool'
        ];
    }

    /**
     * Get the Dimension that owns the Base.
     */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class)->withTrashed();
    }
    
}
