<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Logout;
use App\Livewire\Landingpage\Home;

use App\Livewire\SuperAdmin\Dashboard as SuperAdminDashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\SuperAdmin\Users as SuperAdminUsers; // ✅ tambah ini

use App\Livewire\Buyer\Dashboard as BuyerDashboard;

use App\Livewire\Seller\Dashboard as SellerDashboard;
use App\Livewire\Seller\Products as SellerProducts;
use App\Livewire\Seller\Orders as SellerOrders;
use App\Livewire\Seller\Vouchers as SellerVouchers;

Route::get('/', Home::class)->name('home');

// AUTH ROUTES
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

// DASHBOARD ROUTES
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', Logout::class)->name('logout');

    // ✅ SUPER ADMIN ROUTES
    Route::middleware(['role:super_admin'])->group(function () {
        Route::get('/super-admin/dashboard', SuperAdminDashboard::class)
            ->name('super_admin.dashboard');
        Route::get('/super-admin/users', SuperAdminUsers::class)
            ->name('super_admin.users');
    });

    Route::middleware(['role:admin'])
        ->get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');

   Route::middleware(['role:admin'])
        ->get('/admin/dashboard', SellerDashboard::class)
        ->name('admin.dashboard');

    // ✅ SELLER
    Route::middleware(['role:seller'])->group(function () {
        Route::get('/seller/dashboard', SellerDashboard::class)
            ->name('seller.dashboard');

        Route::get('/seller/products', SellerProducts::class)
            ->name('seller.products');

        Route::get('/seller/orders', SellerOrders::class)
        ->name('seller.orders');

         Route::get('/seller/vouchers', SellerVouchers::class)
        ->name('seller.vouchers');
    });

    Route::middleware(['role:buyer'])
        ->get('/buyer/dashboard', BuyerDashboard::class)->name('buyer.dashboard');
});
