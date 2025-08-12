<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_method' => 'required|in:cash,transfer',
        ];
    }
}
