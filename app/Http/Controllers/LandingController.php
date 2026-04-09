<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\RestaurantMenu; // Tambahkan ini

class LandingController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        $menus = RestaurantMenu::all(); // Tarik data menu
        
        return view('welcome', compact('roomTypes', 'menus'));
    }

    // Fungsi baru untuk halaman form booking
    public function bookingForm($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('booking', compact('roomType'));
    }

    // Fungsi untuk form order restoran
    public function restaurantOrderForm($id)
    {
        $menu = RestaurantMenu::findOrFail($id);
        return view('restaurant-order', compact('menu'));
    }
}