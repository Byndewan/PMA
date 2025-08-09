<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $fillable = ['user_id', 'token', 'expired_at', 'used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
