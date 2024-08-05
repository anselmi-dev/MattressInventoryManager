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
 
#[ObservedBy([CombinationObserver::class])]
class Combination extends Model
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
        'cover_id',
        'top_id',
        'base_id',
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

    /**
     * Get the Top that owns the COmbination.
     */
    public function top(): BelongsTo
    {
        return $this->belongsTo(Top::class)->withTrashed();
    }

    /**
     * Get the Cover that owns the COmbination.
     */
    public function cover(): BelongsTo
    {
        return $this->belongsTo(Cover::class)->withTrashed();
    }

    /**
     * Get the Base that owns the COmbination.
     */
    public function base(): BelongsTo
    {
        return $this->belongsTo(Base::class)->withTrashed();
    }
    
}
