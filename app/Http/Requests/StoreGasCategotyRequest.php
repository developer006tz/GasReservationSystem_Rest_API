<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGasCategotyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required'],
            'image' => ['nullable', 'file', 'mimes:jpg,png,webp,jpeg,svg']
        ];
    }
}
