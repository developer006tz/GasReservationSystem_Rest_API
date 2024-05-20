<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGasPostRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'gas_category_id' => 'required',
            'title' => 'required',
            'image' => 'nullable|file|mimes:jpg,png,webp,jpeg,svg',
            'location' => 'required',
            'in_stock' => 'required',
            'price' => 'required',
            'supplier_id' => 'required',
            'is_published' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
    }
}
