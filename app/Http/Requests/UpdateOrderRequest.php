<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return $this->order->user_id == auth()->id() || auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'status' => 'required|in:queue,process,done,taken',
        ];
    }
}
