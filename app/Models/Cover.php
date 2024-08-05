<?php

namespace App\Models;


use App\Models\Traits\ScopeTrait;
use App\Observers\CoverObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
 
#[ObservedBy([CoverObserver::class])]
class Cover extends Model
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
        'dimension_id',
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

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'code' => '',
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
     * Get the Dimension that owns the Base.
     */
    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class)->withTrashed();
    }
    
}
