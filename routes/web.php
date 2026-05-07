<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MidtransController;

Route::get('/', [LandingController::class, 'index']);
Route::get('/search', [LandingController::class, 'search'])->name('search');
Route::get('/hotel/{location}', [LandingController::class, 'hotelDetail'])->name('hotel.detail');
Route::get('/room/{id}', [LandingController::class, 'roomDetail'])->name('room.detail');

// Rute Login & Register
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost']);
Route::get('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtpPost']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Lupa Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordPost']);
Route::get('/verify-reset-otp', [AuthController::class, 'verifyResetOtp'])->name('verify.reset.otp');
Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtpPost']);
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost']);

// Rute Authenticated (Fitur Pelanggan dan Dasbor)
Route::middleware('auth')->group(function () {
    Route::get('/booking/{id}', [LandingController::class, 'bookingForm'])->name('booking.form');
    Route::post('/booking/{id}', [LandingController::class, 'bookingStore'])->name('booking.store');
    Route::post('/check-voucher', [LandingController::class, 'checkVoucher'])->name('check.voucher');
    Route::get('/restaurant-order/{id}', [LandingController::class, 'restaurantOrderForm'])->name('restaurant.form');
    Route::post('/restaurant-order/{id}', [LandingController::class, 'restaurantOrderStore'])->name('restaurant.store');
    
    Route::get('/payment', [LandingController::class, 'paymentForm'])->name('payment.form');
    Route::post('/midtrans/snap-token', [MidtransController::class, 'getSnapToken'])->name('midtrans.token');
    Route::get('/payment/finish', [MidtransController::class, 'paymentFinish'])->name('payment.finish');

    Route::get('/dashboard/booking/invoice/{id}', [DashboardController::class, 'downloadInvoice'])->name('booking.invoice');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/kamar', [DashboardController::class, 'storeRoom'])->name('store.room');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Kelola Cabang Hotel
    Route::post('/dashboard/hotel', [DashboardController::class, 'storeHotelBranch']);
    Route::post('/dashboard/hotel/update/{id}', [DashboardController::class, 'updateHotelBranch']);
    Route::get('/dashboard/hotel/delete/{id}', [DashboardController::class, 'deleteHotelBranch']);

    // Kelola Pengguna
    Route::post('/dashboard/user/{id}/role', [DashboardController::class, 'updateUserRole']);
    Route::get('/dashboard/user/delete/{id}', [DashboardController::class, 'deleteUser']);
    // Kamar
    Route::post('/dashboard/kamar', [DashboardController::class, 'storeRoom']);
    Route::post('/dashboard/kamar/update/{id}', [DashboardController::class, 'updateRoom']);
    Route::get('/dashboard/kamar/delete/{id}', [DashboardController::class, 'deleteRoom']);

    // Stok Kamar Individual
    Route::post('/dashboard/room-item', [DashboardController::class, 'storeSpecificRoom']);
    Route::post('/dashboard/room-item/update/{id}', [DashboardController::class, 'updateRoomStatus']);
    Route::get('/dashboard/room-item/delete/{id}', [DashboardController::class, 'deleteSpecificRoom']);

    // Manajemen Reservasi
    Route::post('/dashboard/booking/manual-store', [DashboardController::class, 'storeManualBooking']);
    Route::post('/dashboard/booking/{id}/status', [DashboardController::class, 'updateBookingStatus']);
    
    // Status Pesanan Restoran
    Route::post('/dashboard/restaurant-order/manual-store', [DashboardController::class, 'storeManualRestaurantOrder']);
    Route::post('/dashboard/restaurant-order/{id}/status', [DashboardController::class, 'updateRestaurantOrderStatus']);

    // Reset Pendapatan & Laporan
    Route::post('/dashboard/reset-revenue', [DashboardController::class, 'resetRevenue'])->name('dashboard.reset_revenue');
    Route::get('/dashboard/report', [DashboardController::class, 'downloadReport'])->name('dashboard.report');

    // Restoran
    Route::post('/dashboard/menu', [DashboardController::class, 'storeMenu']);
    Route::post('/dashboard/menu/update/{id}', [DashboardController::class, 'updateMenu']);
    Route::get('/dashboard/menu/delete/{id}', [DashboardController::class, 'deleteMenu']);

    // Kelola Voucher
    Route::post('/dashboard/voucher', [DashboardController::class, 'storeVoucher']);
    Route::post('/dashboard/voucher/update/{id}', [DashboardController::class, 'updateVoucher']);
    Route::get('/dashboard/voucher/delete/{id}', [DashboardController::class, 'deleteVoucher']);
});

// Midtrans Webhook (tanpa auth & CSRF)
Route::post('/midtrans/notification', [MidtransController::class, 'handleNotification'])->name('midtrans.notification');

Route::get('/cek-loadbalance', function () {
    return "<h1>Aplikasi HotelKu Jalan!</h1><p>Dilayani oleh Container ID: <b>" . gethostname() . "</b></p>";
});