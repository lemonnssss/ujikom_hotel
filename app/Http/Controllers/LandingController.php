<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Booking;
use App\Models\RestaurantMenu; 
use App\Models\RestaurantOrder;
use App\Models\RestaurantOrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        $menus = RestaurantMenu::all(); 
        
        $hotels = collect();
        $grouped = $roomTypes->groupBy(function($item) {
            return $item->location ?: 'Pusat';
        });

        foreach($grouped as $loc => $rooms) {
            $hotels->push((object)[
                'location' => $loc,
                'name' => 'Premium Hotel ' . $loc,
                'foto_url' => $rooms->first()->foto_url,
                'min_price' => $rooms->min('price'),
                'room_count' => $rooms->count(),
            ]);
        }

        return view('welcome', compact('hotels', 'menus', 'roomTypes'));
    }

    public function hotelDetail($location)
    {
        $actualLocation = $location == 'Pusat' ? null : urldecode($location);
        
        if ($actualLocation) {
            $roomTypes = RoomType::where('location', $actualLocation)->get();
        } else {
            // Null or empty location
            $roomTypes = RoomType::whereNull('location')->orWhere('location', '')->get();
            if ($roomTypes->isEmpty()) {
                $roomTypes = RoomType::where('location', 'Pusat')->get();
            }
        }

        $menus = RestaurantMenu::all();
        return view('hotel-detail', compact('roomTypes', 'menus', 'location'));
    }

    public function roomDetail($id)
    {
        $roomType = RoomType::findOrFail($id);
        
        // Simulasikan penghitungan ketersediaan jika ingin ditampilkan
        $availableRooms = Room::where('room_type_id', $roomType->id)
                              ->where('status', 'available')
                              ->count();
                              
        return view('room-detail', compact('roomType', 'availableRooms'));
    }

    // Fungsi baru untuk halaman form booking
    public function bookingForm($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('booking', compact('roomType'));
    }

    // Fungsi untuk memproses data booking
    public function bookingStore(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'identity_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $roomType = RoomType::findOrFail($id);
        
        $checkIn = Carbon::parse($request->check_in)->startOfDay();
        $checkOut = Carbon::parse($request->check_out)->startOfDay();

        // Cari kamar kosong berdasar irisan tanggal (Overlap Checking)
        $room = Room::where('room_type_id', $roomType->id)
                    ->where('status', '!=', 'maintenance')
                    ->whereDoesntHave('bookings', function($query) use ($checkIn, $checkOut) {
                        $query->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                              ->where(function ($subQuery) use ($checkIn, $checkOut) {
                                  $subQuery->whereBetween('check_in', [$checkIn, $checkOut])
                                           ->orWhereBetween('check_out', [$checkIn, $checkOut])
                                           ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                               $q->where('check_in', '<=', $checkIn)
                                                 ->where('check_out', '>=', $checkOut);
                                           });
                              });
                    })->first();

        if (!$room) {
            return redirect()->back()->with('error', 'Maaf, tidak ada kamar tersedia pada tanggal tersebut untuk tipe ini.');
        }

        // Cari atau buat guest baru dari user yang login (karena sudah auth middleware)
        $user = Auth::user();
        $guest = Guest::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'identity_number' => $request->identity_number,
                'address' => $request->address,
                'password' => Hash::make(Str::random(10)),
            ]
        );
        
        // Update data jika email sudah ada tapi identitas kosong
        $guest->update([
            'identity_number' => $request->identity_number,
            'address' => $request->address
        ]);

        // Hitung total harga
        $days = $checkIn->diffInDays($checkOut);
        $days = $days == 0 ? 1 : $days; // Minimal 1 hari
        $totalPrice = $days * $roomType->price;

        // Simpan booking
        $booking = Booking::create([
            'guest_id' => $guest->id,
            'room_id' => $room->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('payment.form', ['type' => 'booking', 'id' => $booking->id])->with('success', 'Pemesanan kamar berhasil! Silakan lakukan pembayaran.');
    }

    // Fungsi untuk form order restoran
    public function restaurantOrderForm($id)
    {
        $menu = RestaurantMenu::findOrFail($id);
        return view('restaurant-order', compact('menu'));
    }

    // Fungsi untuk memproses order restoran
    public function restaurantOrderStore(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'quantity' => 'required|integer|min:1',
            'room_number' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $menu = RestaurantMenu::findOrFail($id);
        $user = Auth::user();
        
        $guest = Guest::firstOrCreate(
            ['email' => $user->email],
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => Hash::make(Str::random(10)), 
            ]
        );

        $totalPrice = $menu->price * $request->quantity;

        $order = RestaurantOrder::create([
            'guest_id' => $guest->id,
            'total_price' => $totalPrice,
            'status' => 'ordered',
        ]);

        RestaurantOrderDetail::create([
            'restaurant_order_id' => $order->id,
            'restaurant_menu_id' => $menu->id,
            'quantity' => $request->quantity,
            'price' => $menu->price,
        ]);

        return redirect()->route('payment.form', ['type' => 'restaurant', 'id' => $order->id])->with('success', 'Pesanan berhasil! Silakan selesaikan pembayaran.');
    }

    // Fungsi halaman pembayaran
    public function paymentForm(Request $request)
    {
        $type = $request->query('type');
        $id = $request->query('id');

        $data = null;
        $totalPrice = 0;

        if ($type === 'booking') {
            $data = Booking::with('room.roomType')->findOrFail($id);
            $totalPrice = $data->total_price;
        } elseif ($type === 'restaurant') {
            $data = RestaurantOrder::findOrFail($id);
            $totalPrice = $data->total_price;
        } else {
            return redirect('/')->with('error', 'Tipe pembayaran tidak valid.');
        }

        return view('payment', compact('data', 'type', 'totalPrice'));
    }

    // Fungsi proses bayar
    public function paymentStore(Request $request)
    {
        $request->validate([
            'type' => 'required|in:booking,restaurant',
            'id' => 'required|integer',
            'payment_method' => 'required|in:cash,transfer,credit_card,e_wallet',
        ]);

        $amount = 0;
        $paymentData = [
            'payment_method' => $request->payment_method,
            'payment_status' => 'paid', // Sebagai simulasi langsung paid
        ];

        if ($request->type === 'booking') {
            $booking = Booking::findOrFail($request->id);
            $amount = $booking->total_price;
            $paymentData['booking_id'] = $booking->id;
            $paymentData['amount'] = $amount;
            
            \App\Models\Payment::create($paymentData);
            $booking->update(['status' => 'confirmed']);

        } elseif ($request->type === 'restaurant') {
            $order = RestaurantOrder::findOrFail($request->id);
            $amount = $order->total_price;
            $paymentData['restaurant_order_id'] = $order->id;
            $paymentData['amount'] = $amount;

            \App\Models\Payment::create($paymentData);
            $order->update(['status' => 'paid']);
        }

        return redirect('/')->with('success', 'Pembayaran berhasil dikonfirmasi! Terima kasih.');
    }
}