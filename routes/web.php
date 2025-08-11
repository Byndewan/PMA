<?php

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
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // QR Login
    Route::get('/qr-login', [QrTokenController::class, 'showQRLogin'])->name('qr.login');
    Route::post('/qr-login', [QrTokenController::class, 'verifyQRToken']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Middleware: auth + admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
    Route::put('/withdrawals/{withdrawal}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
});

// Operator Routes (Middleware: auth + operator)
Route::middleware(['auth', 'role:operator,admin'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::get('/withdrawals/create', [WithdrawalController::class, 'create'])->name('withdrawals.create');
    Route::get('/withdrawals/show/{id}', [WithdrawalController::class, 'show'])->name('withdrawals.show');
    Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
});

// Dashboard (Umum)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
