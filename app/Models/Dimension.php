<?php

namespace App\Models;

use App\Models\Traits\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dimension extends Model
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
        'height',
        'width',
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
        'label'
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
            'height' => 'integer',
            'width' => 'integer',
            'available' => 'bool',
        ];
    }

    /**
     * Get the comments for the blog post.
     */
    public function mattress (): HasMany
    {
        return $this->hasMany(Mattress::class);
    }
    
    public function getLabelAttribute ()
    {
        return "{$this->height}x{$this->width}";   
    }
}
