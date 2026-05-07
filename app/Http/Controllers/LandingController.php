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

    public function search(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'location' => 'nullable|string'
        ]);

        $checkIn = Carbon::parse($request->check_in)->startOfDay();
        $checkOut = Carbon::parse($request->check_out)->startOfDay();
        $location = $request->location;

        $roomTypesQuery = RoomType::query();

        if ($location) {
            if ($location == 'Pusat') {
                $roomTypesQuery->where(function($q) {
                    $q->whereNull('location')->orWhere('location', '');
                });
            } else {
                $roomTypesQuery->where('location', $location);
            }
        }

        // Filter RoomType that has AT LEAST ONE room available in the given date range
        $availableRoomTypes = $roomTypesQuery->whereHas('rooms', function($query) use ($checkIn, $checkOut) {
            $query->where('status', '!=', 'maintenance')
                  ->whereDoesntHave('bookings', function($bQuery) use ($checkIn, $checkOut) {
                      $bQuery->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                             ->where(function ($subQuery) use ($checkIn, $checkOut) {
                                 $subQuery->whereBetween('check_in', [$checkIn, $checkOut])
                                          ->orWhereBetween('check_out', [$checkIn, $checkOut])
                                          ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                              $q->where('check_in', '<=', $checkIn)
                                                ->where('check_out', '>=', $checkOut);
                                          });
                             });
                  });
        })->get();

        return view('search-results', compact('availableRoomTypes', 'checkIn', 'checkOut', 'location'));
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
        
        $availableRooms = Room::where('room_type_id', $roomType->id)
                              ->where('status', 'available')
                              ->count();
                              
        return view('room-detail', compact('roomType', 'availableRooms'));
    }

    public function checkVoucher(Request $request)
    {
        $code = $request->code;
        $voucher = \App\Models\Voucher::where('code', $code)->where('is_active', true)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Voucher tidak ditemukan atau tidak berlaku.']);
        }

        return response()->json([
            'success' => true,
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'type' => $voucher->type,
                'value' => $voucher->value
            ],
            'message' => 'Voucher berhasil diterapkan!'
        ]);
    }

    public function bookingForm(Request $request, $id)
    {
        $roomType = RoomType::findOrFail($id);
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
        $menus = RestaurantMenu::all();
        return view('booking', compact('roomType', 'checkIn', 'checkOut', 'menus'));
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
            'room_qty' => 'required|integer|min:1|max:5',
            'adults_count' => 'required|integer|min:1',
            'children_count' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'menus' => 'nullable|array',
            'menus.*.qty' => 'nullable|integer|min:0',
            'menus.*.id' => 'nullable|integer|exists:restaurant_menus,id',
            'payment_method' => 'required|in:online,offline',
        ]);

        $roomType = RoomType::findOrFail($id);
        
        $checkIn = Carbon::parse($request->check_in)->startOfDay();
        $checkOut = Carbon::parse($request->check_out)->startOfDay();

        // Cari kamar kosong berdasar irisan tanggal (Overlap Checking)
        $rooms = Room::where('room_type_id', $roomType->id)
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
                    })->limit($request->room_qty)->get();

        if ($rooms->count() < $request->room_qty) {
            return redirect()->back()->with('error', 'Maaf, hanya tersedia ' . $rooms->count() . ' kamar pada tanggal tersebut untuk tipe ini.');
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
        $roomPriceOrigin = $days * $roomType->price * $request->room_qty;
        $totalPrice = $roomPriceOrigin;
        
        $discountAmount = 0;
        $voucherId = null;

        if ($request->filled('voucher_code')) {
            $voucher = \App\Models\Voucher::where('code', $request->voucher_code)->where('is_active', true)->first();
            if ($voucher) {
                $voucherId = $voucher->id;
                if ($voucher->type === 'percent') {
                     $discountAmount = $roomPriceOrigin * ($voucher->value / 100);
                } else {
                     $discountAmount = $voucher->value;
                }
                
                if ($discountAmount > $roomPriceOrigin) {
                    $discountAmount = $roomPriceOrigin;
                }
                $totalPrice -= $discountAmount;
            }
        }

        // Simpan booking
        $booking = Booking::create([
            'guest_id' => $guest->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'adults_count' => $request->adults_count,
            'children_count' => $request->children_count ?? 0,
            'room_qty' => $request->room_qty,
            'special_requests' => $request->special_requests,
            'total_price' => $totalPrice, // Sudah dipotong
            'discount_amount' => $discountAmount,
            'voucher_id' => $voucherId,
            'status' => 'pending',
        ]);

        // Attach rooms
        $booking->rooms()->attach($rooms->pluck('id'));

        // Proses Restaurant Order jika ada
        if ($request->has('menus')) {
            $orderTotal = 0;
            $orderDetails = [];

            foreach ($request->menus as $menuInput) {
                if (!empty($menuInput['qty']) && $menuInput['qty'] > 0) {
                    $menuItem = RestaurantMenu::find($menuInput['id']);
                    if ($menuItem) {
                        $qty = $menuInput['qty'];
                        $price = $menuItem->price;
                        $orderTotal += $qty * $price;
                        
                        $orderDetails[] = [
                            'restaurant_menu_id' => $menuItem->id,
                            'quantity' => $qty,
                            'price' => $price,
                        ];
                    }
                }
            }

            if ($orderTotal > 0) {
                $restaurantOrder = RestaurantOrder::create([
                    'guest_id' => $guest->id,
                    'booking_id' => $booking->id,
                    'total_price' => $orderTotal,
                    'status' => 'ordered',
                ]);

                foreach ($orderDetails as $detail) {
                    $detail['restaurant_order_id'] = $restaurantOrder->id;
                    RestaurantOrderDetail::create($detail);
                }
            }
        }

        if ($request->payment_method === 'offline') {
            return redirect()->route('dashboard')->with('success', 'Pemesanan kamar berhasil! Silakan lakukan pembayaran langsung di tempat.');
        }

        return redirect()->route('payment.form', ['type' => 'booking', 'id' => $booking->id])->with('success', 'Pemesanan kamar berhasil disiapkan! Silakan lakukan pembayaran.');
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
            'payment_method' => 'required|in:online,offline',
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

        if ($request->payment_method === 'offline') {
            return redirect()->route('dashboard')->with('success', 'Pesanan restoran berhasil! Silakan bayar di tempat.');
        }

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
            $data = Booking::with(['rooms.roomType', 'restaurantOrder'])->findOrFail($id);
            $totalPrice = $data->total_price;
            if ($data->restaurantOrder) {
                $totalPrice += $data->restaurantOrder->total_price;
            }
        } elseif ($type === 'restaurant') {
            $data = RestaurantOrder::findOrFail($id);
            $totalPrice = $data->total_price;
        } else {
            return redirect('/')->with('error', 'Tipe pembayaran tidak valid.');
        }

        return view('payment', compact('data', 'type', 'totalPrice'));
    }

    // Fungsi proses bayar sekarang ditangani oleh MidtransController
}