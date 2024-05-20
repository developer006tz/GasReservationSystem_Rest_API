<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }


    public function rules():array
    {
        return [
            "supplier_id" => "required",
            "customer_id" => "required",
            "post_id" => "required",
            "quantity" => "required",
            "price" => "required",
            "total_amount" => "required",
        ];
    }
}
