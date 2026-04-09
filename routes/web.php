<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [LandingController::class, 'index']);
Route::get('/booking/{id}', [LandingController::class, 'bookingForm'])->name('booking.form');
Route::get('/restaurant-order/{id}', [LandingController::class, 'restaurantOrderForm'])->name('restaurant.form');
// Rute Login & Register
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Dashboard (Hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/kamar', [DashboardController::class, 'storeRoom'])->name('store.room');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Kamar
    Route::post('/dashboard/kamar', [DashboardController::class, 'storeRoom']);
    Route::post('/dashboard/kamar/update/{id}', [DashboardController::class, 'updateRoom']);
    Route::get('/dashboard/kamar/delete/{id}', [DashboardController::class, 'deleteRoom']);

    // Restoran
    Route::post('/dashboard/menu', [DashboardController::class, 'storeMenu']);
    Route::post('/dashboard/menu/update/{id}', [DashboardController::class, 'updateMenu']);
    Route::get('/dashboard/menu/delete/{id}', [DashboardController::class, 'deleteMenu']);
});