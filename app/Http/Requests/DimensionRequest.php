<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DimensionRequest extends FormRequest
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
            'code' => 'required|unique:dimensions,code,'.$id,
            'height' => 'required|integer|min:1',
            'width' => 'required|integer|min:1',
            'visible' => 'required',
            'description' => 'max:500',
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($rules)), $rules);
    }

    protected function validationAttributes ()
    {
        $attributes = [
            'code' => __('Code'),
            'height' => __('Height'),
            'width' => __('Width'),
            'visible' => __('Visible'),
            'description' => __('Description'),
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($attributes)), $attributes);
    }

    public function fill () : array 
    {
        return [
            'code',
            'height',
            'width',
            'visible',
            'description',
        ];
    }
}
