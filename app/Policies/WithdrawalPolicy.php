<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Auth\Access\HandlesAuthorization;

class WithdrawalPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isOperator();
    }

    public function view(User $user, Withdrawal $withdrawal)
    {
        return $user->isAdmin() || $withdrawal->user_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->isOperator();
    }

    public function update(User $user, Withdrawal $withdrawal)
    {
        return false;
    }

    public function approve(User $user, Withdrawal $withdrawal)
    {
        return $user->isAdmin() && $withdrawal->status === 'pending';
    }

    public function delete(User $user, Withdrawal $withdrawal)
    {
        return $withdrawal->status === 'pending' &&
               ($user->isAdmin() || $withdrawal->user_id === $user->id);
    }

    public function restore(User $user, Withdrawal $withdrawal)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Withdrawal $withdrawal)
    {
        return $user->isAdmin();
    }
}
