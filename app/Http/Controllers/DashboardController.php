<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->operatorDashboard();
    }

    protected function adminDashboard()
    {
        $stats = [
            'totalRevenue' => Order::sum('total_price'),
            'totalOrders' => Order::count(),
            'totalProducts' => Product::count(),
            'totalOperators' => User::where('role', 'operator')->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $pendingWithdrawals = Withdrawal::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentOrders', 'pendingWithdrawals'));
    }

    protected function operatorDashboard()
    {
        $user = Auth::user();

        $stats = [
            'balance' => $user->balance,
            'todayOrders' => Order::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->count(),
            'pendingOrders' => Order::where('user_id', $user->id)
                ->whereIn('status', ['queue', 'process'])
                ->count(),
        ];

        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentWithdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard.operator', compact('stats', 'recentOrders', 'recentWithdrawals'));
    }
}
