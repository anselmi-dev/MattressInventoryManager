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
    public function rules(): array
    {
        $rules = [
            'code' => 'required',
            'cover_id' => 'required',
            'top_id' => 'required',
            'mattress_id' => 'required',
            'stock' => 'required',
            'available' => 'required',
            'description' => 'max:500',
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($rules)), $rules);
    }

    protected function validationAttributes ()
    {
        $attributes = [
            'code' => __('Code'),
            'cover_id' => __('Cover'),
            'top_id' => __('Top'),
            'mattress_id' => __('Mattress'),
            'stock' => __('Stock'),
            'available' => __('Available'),
            'description' => __('Description'),
        ];

        return array_combine(array_map(fn($k) => $this->prefix . $k, array_keys($attributes)), $attributes);
    }

    public function fill () : array 
    {
        return [
            'code',
            'cover_id',
            'top_id',
            'mattress_id',
            'stock',
            'available',
            'description',
        ];
    }
}
