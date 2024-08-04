<?php

namespace App\Models;


use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'stock',
        'available',
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
        'available' => TRUE,
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
            'available' => 'bool',
            'stock' => 'integer'
        ];
    }

    /**
     * Get the mattress for the Cover.
     */
    public function mattress (): HasMany
    {
        return $this->hasMany(Mattress::class);
    }
}
