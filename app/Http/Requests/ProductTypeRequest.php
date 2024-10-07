<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductTypeRequest extends FormRequest
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
            'name' => 'required|unique:product_types,name,'.$id,
            'part' => 'required|unique:product_types,part,'.$id,
            'contains' => 'required',
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($rules)), $rules);
    }

    protected function validationAttributes ()
    {
        $attributes = [
            'name' => __('Name'),
            'part' => __('Part'),
            'contains' => __('Contains'),
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($attributes)), $attributes);
    }

    public function fill () : array 
    {
        return [
            'name',
            'part',
            'contains',
        ];
    }
}
