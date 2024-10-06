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
            'code' => 'required|unique:products,code,'.$id,
            'reference' => 'required|unique:products,reference,'.$id,
            'name' => 'required|string|max:100',
            'dimension_id' => 'required',
            'stock' => 'required|integer|min:0',
            'description' => 'max:500',
            'products' => ['required', 'array'],
            // 'products.*' => ['integer', 'exists:products,id'],
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($rules)), $rules);
    }

    protected function validationAttributes ()
    {
        $attributes = [
            'code' => __('Code'),
            'name' => __('Name'),
            'reference' => __('Reference'),
            'dimension_id' => __('Dimension'),
            'stock' => __('Stock'),
            'description' => __('Description'),
            'products' => __('Parts'),
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($attributes)), $attributes);
    }

    public function fill () : array 
    {
        return [
            'code',
            'name',
            'reference',
            'dimension_id',
            'stock',
            'description',
            'base_id',
            'cover_id',
            'top_id',
        ];
    }
}
