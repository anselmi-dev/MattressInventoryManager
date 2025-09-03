<?php

namespace App\Casts;

use App\DataTypes\StatusOrderProductDataType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class StatusOrderProductCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  StatusOrderProductDataType $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
		// return new StatusOrderProductDataType($value);
		return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
