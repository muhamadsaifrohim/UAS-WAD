<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Hanya untuk tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Hanya untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Admin DAN staff: melihat daftar
    Route::resource('categories', CategoryController::class)->only(['index']);
    Route::resource('suppliers', SupplierController::class)->only(['index']);
    Route::resource('products', ProductController::class)->only(['index']);

    // Admin DAN staff: melihat dan mencatat transaksi stok
    Route::resource('stock-transactions', StockTransactionController::class)
        ->only(['index', 'create', 'store']);

    // Khusus ADMIN
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
        Route::resource('suppliers', SupplierController::class)->except(['index', 'show']);
        Route::resource('products', ProductController::class)->except(['index', 'show']);

        // Manajemen pengguna
        Route::resource('users', UserController::class)->except(['show']);
    });
});
