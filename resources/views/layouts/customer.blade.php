@extends('layouts.app')

@section('styles')
<style>
    .sidebar-link {
        @apply flex items-center px-4 py-3 text-gray-600 hover:bg-gray-100 transition rounded-lg;
    }
    .sidebar-link.active {
        @apply bg-blue-50 text-blue-600 font-medium;
    }
    .sidebar-link i {
        @apply mr-3 text-lg;
    }
</style>
@endsection

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-white border-r border-gray-200 p-4 hidden md:block">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800">Customer Panel</h2>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('customer.dashboard') }}"
               class="sidebar-link {{ request()->is('customer/dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="{{ route('customer.products.index') }}"
               class="sidebar-link {{ request()->is('customer/products*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                Products
            </a>
            <a href="{{ route('customer.orders.index') }}"
               class="sidebar-link {{ request()->is('customer/orders*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                My Orders
            </a>
            <a href="{{ route('customer.profile.edit') }}"
               class="sidebar-link {{ request()->is('customer/profile*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                Profile
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-gray-50">
        <div class="p-6">
            @yield('customer_content')
        </div>
    </div>
</div>
@endsection
