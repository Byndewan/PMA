<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true; // Both admin and operator can view products
    }

    public function view(User $user, Product $product)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Product $product)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Product $product)
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Product $product)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Product $product)
    {
        return $user->isAdmin();
    }
}
