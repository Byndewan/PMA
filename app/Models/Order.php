<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $guarded;

    protected $casts = [
        'total_price' => 'decimal:2',
        'operator_fee_total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(OrderTrack::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
