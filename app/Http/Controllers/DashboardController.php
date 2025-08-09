<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Withdrawal;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
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
            ->paginate(10);

        $pendingWithdrawals = Withdrawal::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->paginate(10);

        return view('dashboard.admin', [
            'totalRevenue' => $stats['totalRevenue'],
            'totalOrders' => $stats['totalOrders'],
            'totalProducts' => $stats['totalProducts'],
            'totalOperators' => $stats['totalOperators'],
            'recentOrders' => $recentOrders,
            'pendingWithdrawals' => $pendingWithdrawals,
        ]);
    }

    protected function operatorDashboard()
    {
        $user = auth()->user();

        $stats = [
            'balance' => $user->balance,
            'todayOrders' => Order::where('user_id', $user->id)
                ->whereDate('created_at', today())
                ->count(),
            'pendingOrders' => Order::where('user_id', $user->id)
                ->whereIn('status', ['queue', 'process'])
                ->count(),
        ];

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->paginate(10);

        return view('dashboard.operator', compact('stats', 'orders'));
    }
}
