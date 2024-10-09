<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'code' => 'required|unique:products,code,'.$id,
            'reference' => 'required|unique:products,reference,'.$id,
            'name' => 'required',
            'type' => 'required',
            'dimension_id' => 'required',
            'stock' => 'required|integer|min:-1',
            'visible' => 'required',
            'description' => 'max:500',
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($rules)), $rules);
    }

    protected function validationAttributes ()
    {
        $attributes = [
            'type' => __('Type'),
            'code' => __('Code'),
            'reference' => __('Reference'),
            'dimension_id' => __('Dimension'),
            'name' => __('Name'),
            'stock' => __('Stock'),
            'visible' => __('Visible'),
            'description' => __('Description'),
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($attributes)), $attributes);
    }

    public function fill () : array 
    {
        return [
            'code',
            'name',
            'type',
            'reference',
            'dimension_id',
            'stock',
            'visible',
            'description',
        ];
    }
}
