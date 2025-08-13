<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTrack extends Model
{
    protected $table = 'order_tracks';

    protected $guarded;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
