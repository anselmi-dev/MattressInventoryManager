<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CombinationRequest extends FormRequest
{
    protected $prefix;

    public function __construct($prefix = '')
    {
        $this->prefix = $prefix . '.';
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules($id = null): array
    {
        $rules = [
            'code' => 'required|unique:codes,value,'.$id,
            'dimension_id' => 'required',
            'stock' => 'required|integer|min:0',
            'description' => 'max:500',
            'base_id' => 'required',
            'cover_id' => 'required',
            'top_id' => 'required',
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($rules)), $rules);
    }

    protected function validationAttributes ()
    {
        $attributes = [
            'code' => __('Code'),
            'dimension_id' => __('Cover'),
            'cover_id' => __('Cover'),
            'top_id' => __('Top'),
            'base_id' => __('Base'),
            'stock' => __('Stock'),
            'description' => __('Description'),
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($attributes)), $attributes);
    }

    public function fill () : array 
    {
        return [
            'dimension_id',
            'stock',
            'description',
            'base_id',
            'cover_id',
            'top_id',
        ];
    }
}
