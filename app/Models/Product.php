<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'format', 'price', 'operator_fee', 'estimate_time', 'is_active'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
