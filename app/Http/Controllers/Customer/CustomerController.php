<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $recentOrders = $user->orders()->latest()->take(5)->get();
        $favoriteProducts = $user->favoriteProducts()->with('category')->get();

        return view('customer.dashboard', compact('user', 'recentOrders', 'favoriteProducts'));
    }
}
