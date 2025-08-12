<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Please upload your design file',
            'file.mimes' => 'Only JPG, PNG, PDF, DOC/DOCX files are allowed',
            'file.max' => 'File size should not exceed 5MB',
        ];
    }
}
