<?php

namespace App\Models;

use App\Observers\ProductTypeObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([ProductTypeObserver::class])]
class ProductType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'part',
        'contains'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'contains' => 'array',
            'part' => 'bool',
        ];
    }

    public function scopeWhereNotCombination (Builder $query)
    {
        $query->where('part', true);
    }

    public function scopeWhereCombination (Builder $query)
    {
        $query->where('part', false);
    }

    /**
     * Veriticar si en los elementos contains está el $string
     *
     * @param string $string
     * @return string|null|bool
     */
    public function getProductTypeByContains (string $string)
    {
        return array_filter($this->contains, function ($word) use ($string) {
            return Str::contains($string, $word);
        });
    }
}
