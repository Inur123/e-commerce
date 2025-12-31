<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

use App\Livewire\SuperAdmin\Dashboard as SuperAdminDashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Seller\Dashboard as SellerDashboard;
use App\Livewire\Buyer\Dashboard as BuyerDashboard;

Route::get('/', function () {
    return view('welcome');
});

// AUTH ROUTES
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

// DASHBOARD ROUTES
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:super_admin'])
        ->get('/super-admin/dashboard', SuperAdminDashboard::class)
        ->name('super_admin.dashboard');

    Route::middleware(['role:admin'])
        ->get('/admin/dashboard', AdminDashboard::class)
        ->name('admin.dashboard');

    Route::middleware(['role:seller'])
        ->get('/seller/dashboard', SellerDashboard::class)
        ->name('seller.dashboard');

    Route::middleware(['role:buyer'])
        ->get('/buyer/dashboard', BuyerDashboard::class)
        ->name('buyer.dashboard');

});
