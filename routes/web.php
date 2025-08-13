<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QrTokenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::middleware('guest')->group(function () {
    // Admin/Operator Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Customer Login (menggunakan LoginController yang sudah ada)
    Route::get('/customer/login', [AuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/customer/login', [AuthController::class, 'login']);

    // QR Login
    Route::get('/qr-login', [QrTokenController::class, 'showQRLogin'])->name('qr.login');
    Route::post('/qr-login', [QrTokenController::class, 'verifyQRToken']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Middleware: auth + admin)
Route::prefix('crew')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::put('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
});

// Operator Routes (Middleware: auth + operator)
Route::prefix('crew')->middleware(['auth', 'role:operator,admin'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::get('/withdrawals/create', [WithdrawalController::class, 'create'])->name('withdrawals.create');
    Route::get('/withdrawals/show/{id}', [WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
});

// Customer Routes (Middleware: auth + customer)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    // Products
    Route::get('/products', [CustomerProductController::class, 'index'])->name('customer.products.index');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('customer.products.show');
    Route::post('/products/{product}/favorite', [CustomerProductController::class, 'favorite'])->name('customer.products.favorite');

    // Orders
    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/orders/create/{product}', [CustomerOrderController::class, 'create'])->name('customer.orders.create');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('customer.orders.store');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::post('/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/orders/{order}/upload', [CustomerOrderController::class, 'upload'])->name('customer.orders.upload');

    // Profile
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');

    // Payment
    Route::get('/orders/{order}/payment', [CustomerOrderController::class, 'payment'])->name('customer.orders.payment');
    Route::post('/orders/{order}/payment', [CustomerOrderController::class, 'submitPayment'])->name('customer.orders.submit_payment');
});

// Dashboard Umum (untuk semua role)
Route::prefix('crew')->middleware(['auth', 'role:admin,operator'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

