<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'username', 'password', 'role', 'balance'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function qrTokens()
    {
        return $this->hasMany(QrToken::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOperator()
    {
        return $this->role === 'operator';
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }
    }

}
