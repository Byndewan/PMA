<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Withdrawal;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Policies\WithdrawalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
        Product::class => ProductPolicy::class,
        User::class => UserPolicy::class,
        Withdrawal::class => WithdrawalPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('approve-withdrawal', function (User $user, Withdrawal $withdrawal) {
            return $user->isAdmin() && $withdrawal->status === 'pending';
        });
    }
}
