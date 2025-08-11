<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isOperator();
    }

    public function view(User $user, Order $order)
    {
        return $user->isAdmin() || $order->user_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->isOperator();
    }

    public function update(User $user, Order $order)
    {
        return $user->isAdmin() || ($user->isOperator() && $order->user_id === $user->id);
    }

    public function delete(User $user, Order $order)
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Order $order)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Order $order)
    {
        return $user->isAdmin();
    }
}
