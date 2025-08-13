<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $orders = $user->orders()->get();
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $favoriteProducts = $user->favoriteProducts()->with('category')->get();

        return view('dashboard.customer', compact('user', 'recentOrders', 'favoriteProducts','orders'));
    }
}
