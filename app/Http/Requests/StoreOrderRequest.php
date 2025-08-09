<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ];
    }

    public function messages()
    {
        return [
            'items.*.product_id.exists' => 'Produk yang dipilih tidak valid',
            'items.*.file.max' => 'Ukuran file maksimal 5MB',
            'items.*.file.mimes' => 'Format file harus JPG, PNG, atau PDF',
        ];
    }
}
