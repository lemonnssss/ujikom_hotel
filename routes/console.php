<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Booking;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $expiredBookings = Booking::where('status', 'pending')
                ->where('created_at', '<', Carbon::now()->subMinutes(60))
                ->get();
                
    foreach($expiredBookings as $booking) {
        $booking->update(['status' => 'canceled']);
    }
})->everyMinute();
