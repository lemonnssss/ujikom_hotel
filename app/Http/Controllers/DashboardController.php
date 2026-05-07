<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\RestaurantMenu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 'admin' || $user->role == 'manager' || $user->role == 'receptionist') {
            $hotelsData = \App\Models\Hotel::with('owner')->get();
            
            if ($user->role == 'manager') {
                $myHotel = \App\Models\Hotel::where('owner_id', $user->id)->first();
                $selectedHotel = $myHotel ? $myHotel->location_key : 'UNASSIGNED_HOTEL_xxx';
                $hotelsList = collect([$selectedHotel]);
            } else {
                $selectedHotel = $request->query('hotel');
                $hotelsListDb = \App\Models\Hotel::pluck('location_key');
                $hotelsListRt = \App\Models\RoomType::select('location')->distinct()->pluck('location')->map(fn($loc) => $loc ?: 'Pusat');
                $hotelsList = $hotelsListDb->merge($hotelsListRt)->unique();
            }

            $queryRoom = RoomType::query();
            if ($request->has('search_room')) {
                $queryRoom->where('name', 'like', '%' . $request->search_room . '%');
            }
            if ($selectedHotel) {
                if ($selectedHotel == 'Pusat') {
                    $queryRoom->where(function($q) {
                        $q->whereNull('location')->orWhere('location', '');
                    });
                } else {
                    $queryRoom->where('location', $selectedHotel);
                }
            }
            $rooms = $queryRoom->get();

            $queryMenu = RestaurantMenu::query();
            if ($request->has('search_menu')) {
                $queryMenu->where('name', 'like', '%' . $request->search_menu . '%');
            }
            $menus = $queryMenu->get();

            $allRoomsQuery = \App\Models\Room::with('roomType');
            if ($selectedHotel) {
                $allRoomsQuery->whereHas('roomType', function($q) use ($selectedHotel) {
                    if ($selectedHotel == 'Pusat') {
                        $q->whereNull('location')->orWhere('location', '');
                    } else {
                        $q->where('location', $selectedHotel);
                    }
                });
            }
            $allRooms = $allRoomsQuery->get();
            
            $users = \App\Models\User::all();
            
            // Statistik
            $paymentsQuery = \App\Models\Payment::where('payment_status', 'paid');
            if ($selectedHotel) {
                $paymentsQuery->where(function ($q) use ($selectedHotel) {
                    $q->whereHas('booking.rooms.roomType', function($q2) use ($selectedHotel) {
                        if ($selectedHotel == 'Pusat') {
                            $q2->whereNull('location')->orWhere('location', '');
                        } else {
                            $q2->where('location', $selectedHotel);
                        }
                    });
                    if ($selectedHotel == 'Pusat') {
                        $q->orWhereDoesntHave('booking');
                    }
                });
            }
            $totalRevenue = (clone $paymentsQuery)->sum('amount');
            
            // Chart Data (Pendapatan per Bulan tahun ini)
            $revenueData = (clone $paymentsQuery)->select(
                \DB::raw('MONTH(created_at) as month'), 
                \DB::raw('SUM(amount) as total')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

            $chartLabels = [];
            $chartData = [];
            $bulanIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            for ($i = 1; $i <= 12; $i++) {
                $chartLabels[] = $bulanIndo[$i-1];
                $monthData = $revenueData->firstWhere('month', $i);
                $chartData[] = $monthData ? $monthData->total : 0;
            }
            
            $bookingsForStats = \App\Models\Booking::query();
            $roomsForStats = \App\Models\Room::where('status', 'occupied');
            
            if ($selectedHotel) {
                $bookingsForStats->whereHas('rooms.roomType', function($q) use ($selectedHotel) {
                    if ($selectedHotel == 'Pusat') {
                        $q->whereNull('location')->orWhere('location', '');
                    } else {
                        $q->where('location', $selectedHotel);
                    }
                });
                
                $roomsForStats->whereHas('roomType', function($q) use ($selectedHotel) {
                    if ($selectedHotel == 'Pusat') {
                        $q->whereNull('location')->orWhere('location', '');
                    } else {
                        $q->where('location', $selectedHotel);
                    }
                });
            }
            
            $totalBookings = $bookingsForStats->count();
            $occupiedRoomsCount = $roomsForStats->count();

            // Manajemen Reservasi
            $bookingsQuery = \App\Models\Booking::with(['guest', 'rooms.roomType', 'payments'])->orderBy('check_in', 'desc');
            if ($selectedHotel) {
                $bookingsQuery->whereHas('rooms.roomType', function($q) use ($selectedHotel) {
                    if ($selectedHotel == 'Pusat') {
                        $q->whereNull('location')->orWhere('location', '');
                    } else {
                        $q->where('location', $selectedHotel);
                    }
                });
            }
            $allBookings = $bookingsQuery->get();

            $vouchers = \App\Models\Voucher::orderBy('created_at', 'desc')->get();

            return view('dashboard', compact('rooms', 'menus', 'allRooms', 'users', 'totalRevenue', 'totalBookings', 'occupiedRoomsCount', 'allBookings', 'hotelsList', 'selectedHotel', 'hotelsData', 'vouchers', 'chartLabels', 'chartData'));
        } else {
            $guest = \App\Models\Guest::where('email', $user->email)->first();
            $myBookings = collect();
            $myOrders = collect();
            
            if ($guest) {
                $myBookings = \App\Models\Booking::with(['rooms.roomType', 'payments'])->where('guest_id', $guest->id)->orderBy('created_at', 'desc')->get();
                $myOrders = \App\Models\RestaurantOrder::with(['details.menu', 'payments'])->where('guest_id', $guest->id)->orderBy('created_at', 'desc')->get();
            }

            return view('dashboard', compact('myBookings', 'myOrders'));
        }
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = $request->file('foto')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    // --- CRUD HOTEL CABANG (ADMIN) ---
    public function storeHotelBranch(Request $request) {
        \App\Models\Hotel::create([
            'name' => $request->name,
            'location_key' => $request->location_key,
            'owner_id' => $request->owner_id
        ]);
        return back()->with('success', 'Cabang Hotel baru berhasil ditambahkan!');
    }

    public function updateHotelBranch(Request $request, $id) {
        $hotel = \App\Models\Hotel::findOrFail($id);
        $hotel->update([
            'name' => $request->name,
            'location_key' => $request->location_key,
            'owner_id' => $request->owner_id
        ]);
        return back()->with('success', 'Data Cabang Hotel diperbarui!');
    }

    public function deleteHotelBranch($id) {
        \App\Models\Hotel::findOrFail($id)->delete();
        return back()->with('success', 'Cabang Hotel dihapus!');
    }

    // --- CRUD KAMAR ---
    public function storeRoom(Request $request) {
        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('rooms', 'public');
        }

        // Simpan manual bypass Fillable
        $room = new RoomType();
        $room->name = $request->name;
        $room->location = $request->location; // Lokasi Baru
        $room->description = $request->description;
        $room->price = $request->price;
        $room->foto_url = $path ?? 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?q=80&w=800';
        $room->save();

        return back()->with('success', 'Kategori kamar & lokasi berhasil ditambahkan!');
    }

    public function updateRoom(Request $request, $id) {
        $room = RoomType::findOrFail($id);
        
        $room->name = $request->name;
        $room->location = $request->location; // Lokasi Baru
        $room->description = $request->description;
        $room->price = $request->price;

        if ($request->hasFile('foto')) {
            if ($room->foto_url && !\Str::startsWith($room->foto_url, 'http')) {
                Storage::disk('public')->delete($room->foto_url); // Hapus foto lama
            }
            $room->foto_url = $request->file('foto')->store('rooms', 'public');
        }
        $room->save(); // Cara ini dijamin berhasil update!

        return back()->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function deleteRoom($id) {
        $room = RoomType::findOrFail($id);
        if ($room->foto_url && !\Str::startsWith($room->foto_url, 'http')) {
            Storage::disk('public')->delete($room->foto_url);
        }
        $room->delete();
        return back()->with('success', 'Kategori kamar berhasil dihapus!');
    }

    // --- CRUD RESTORAN ---
    public function storeMenu(Request $request) {
        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('menus', 'public');
        }

        $menu = new RestaurantMenu();
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->foto_url = $path ?? 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=800';
        $menu->save();

        return back()->with('success', 'Menu restoran berhasil ditambahkan!');
    }

    public function updateMenu(Request $request, $id) {
        $menu = RestaurantMenu::findOrFail($id);
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;

        if ($request->hasFile('foto')) {
            if ($menu->foto_url && !\Str::startsWith($menu->foto_url, 'http')) {
                Storage::disk('public')->delete($menu->foto_url);
            }
            $menu->foto_url = $request->file('foto')->store('menus', 'public');
        }
        $menu->save();

        return back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function deleteMenu($id) {
        $menu = RestaurantMenu::findOrFail($id);
        if ($menu->foto_url && !\Str::startsWith($menu->foto_url, 'http')) {
            Storage::disk('public')->delete($menu->foto_url);
        }
        $menu->delete();
        return back()->with('success', 'Menu berhasil dihapus!');
    }

    // --- CRUD STOK KAMAR (INDIVIDUAL) ---
    public function storeSpecificRoom(Request $request) {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number'
        ], [
            'room_number.unique' => 'Gagal! Nomor kamar "' . $request->room_number . '" sudah terdaftar di sistem. Silakan gunakan nomor yang berbeda.'
        ]);

        \App\Models\Room::create([
            'room_type_id' => $request->room_type_id,
            'room_number' => $request->room_number,
            'status' => $request->status ?? 'available'
        ]);
        return back()->with('success', 'Data kamar berhasil ditambahkan ke stok!');
    }

    public function updateRoomStatus(Request $request, $id) {
        $room = \App\Models\Room::findOrFail($id);
        $room->status = $request->status;
        $room->save();
        return back()->with('success', 'Status kamar diperbarui!');
    }

    public function deleteSpecificRoom($id) {
        \App\Models\Room::findOrFail($id)->delete();
        return back()->with('success', 'Kamar dihapus dari stok!');
    }

    // --- MANAJEMEN RESERVASI ---
    public function storeManualBooking(Request $request) {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'manager' && $user->role !== 'receptionist') {
            abort(403, 'Anda tidak berhak membuat reservasi manual.');
        }

        $request->validate([
            'guest_name' => 'required|string|max:50',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:15',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'room_qty' => 'required|integer|min:1|max:5',
            'payment_status' => 'required|in:paid,pending',
        ]);

        $roomType = RoomType::findOrFail($request->room_type_id);
        
        $checkIn = \Carbon\Carbon::parse($request->check_in)->startOfDay();
        $checkOut = \Carbon\Carbon::parse($request->check_out)->startOfDay();

        $rooms = \App\Models\Room::where('room_type_id', $roomType->id)
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
            return back()->with('error', 'Gagal: Hanya tersedia ' . $rooms->count() . ' kamar kosong pada tanggal tersebut untuk tipe ' . $roomType->name);
        }

        $guest = \App\Models\Guest::firstOrCreate(
            ['email' => $request->guest_email],
            [
                'name' => $request->guest_name,
                'phone' => $request->guest_phone,
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(10)),
            ]
        );

        $days = $checkIn->diffInDays($checkOut);
        $days = $days == 0 ? 1 : $days;
        $totalPrice = $days * $roomType->price * $request->room_qty;

        $booking = \App\Models\Booking::create([
            'guest_id' => $guest->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'adults_count' => 1,
            'children_count' => 0,
            'room_qty' => $request->room_qty,
            'total_price' => $totalPrice,
            'discount_amount' => 0,
            'status' => $request->payment_status == 'paid' ? 'confirmed' : 'pending',
        ]);

        $booking->rooms()->attach($rooms->pluck('id'));

        if ($request->payment_status == 'paid') {
            \App\Models\Payment::create([
                'booking_id' => $booking->id,
                'amount' => $totalPrice,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
        }

        return back()->with('success', 'Reservasi manual berhasil dibuat!');
    }
    public function updateBookingStatus(Request $request, $id) {
        $booking = \App\Models\Booking::with('payments', 'rooms', 'guest')->findOrFail($id);
        $user = Auth::user();
        $action = $request->action;

        // Cek keamanan jika user bukan admin/manager
        if ($user->role !== 'admin' && $user->role !== 'manager' && $user->role !== 'receptionist') {
            // Hanya izinkan aksi cancel
            if ($action !== 'cancel') {
                abort(403, 'Anda tidak berhak mengubah status ini.');
            }
            // Pastikan pesanan miliknya
            if (!$booking->guest || $booking->guest->email !== $user->email) {
                abort(403, 'Unauthorized access.');
            }
            // Pastikan hanya bisa cancel jika masih pending
            if ($booking->status !== 'pending' && $booking->payments->where('payment_status', 'paid')->count() > 0) {
                return back()->with('error', 'Pesanan lunas tidak bisa dibatalkan secara otomatis.');
            }
        }

        if ($action == 'verify_payment') {
            // Ubah payment pertama menjadi paid
            if ($booking->payments->count() > 0) {
                $payment = $booking->payments->first();
                $payment->update(['payment_status' => 'paid']);
            } else {
                \App\Models\Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_price,
                    'payment_method' => 'cash',
                    'payment_status' => 'paid',
                ]);
            }
            $booking->update(['status' => 'confirmed']);
            return back()->with('success', 'Pembayaran diverifikasi! Status booking menjadi Confirmed.');
        } 
        elseif ($action == 'check_in') {
            $booking->update(['status' => 'checked_in']);
            foreach($booking->rooms as $rm) {
                $rm->update(['status' => 'occupied']);
            }
            return back()->with('success', 'Tamu Check-In. Kamar berstatus Occupied.');
        } 
        elseif ($action == 'check_out') {
            $booking->update(['status' => 'checked_out']);
            foreach($booking->rooms as $rm) {
                $rm->update(['status' => 'available']);
            }
            return back()->with('success', 'Tamu Check-Out! Kamar berstatus Available kembali.');
        }
        elseif ($action == 'cancel') {
            $booking->update(['status' => 'cancelled']);
            foreach($booking->rooms as $rm) {
                $rm->update(['status' => 'available']);
            }
            return back()->with('success', 'Booking Dibatalkan.');
        }

        return back();
    }

    public function updateRestaurantOrderStatus(Request $request, $id) {
        $order = \App\Models\RestaurantOrder::with('payments', 'guest')->findOrFail($id);
        $user = Auth::user();
        $action = $request->action;

        if ($user->role !== 'admin' && $user->role !== 'manager' && $user->role !== 'receptionist') {
            if ($action !== 'cancel') {
                abort(403, 'Anda tidak berhak mengubah status ini.');
            }
            if (!$order->guest || $order->guest->email !== $user->email) {
                abort(403, 'Unauthorized access.');
            }
            if ($order->status !== 'ordered' && $order->payments->where('payment_status', 'paid')->count() > 0) {
                return back()->with('error', 'Pesanan lunas tidak bisa dibatalkan secara otomatis.');
            }
        }
        
        if ($action == 'cancel') {
            $order->update(['status' => 'cancelled']);
            return back()->with('success', 'Pesanan Restoran Dibatalkan.');
        }
        return back();
    }

    public function storeManualRestaurantOrder(Request $request) {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'manager' && $user->role !== 'receptionist') {
            abort(403, 'Anda tidak berhak membuat pesanan manual.');
        }

        $request->validate([
            'guest_name' => 'required|string|max:50',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:15',
            'menu_id' => 'required|exists:restaurant_menus,id',
            'quantity' => 'required|integer|min:1',
            'room_number' => 'nullable|string',
            'note' => 'nullable|string',
            'payment_status' => 'required|in:paid,pending',
        ]);

        $menu = \App\Models\RestaurantMenu::findOrFail($request->menu_id);

        $guest = \App\Models\Guest::firstOrCreate(
            ['email' => $request->guest_email],
            [
                'name' => $request->guest_name,
                'phone' => $request->guest_phone,
                'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(10)),
            ]
        );

        $totalPrice = $menu->price * $request->quantity;

        $order = \App\Models\RestaurantOrder::create([
            'guest_id' => $guest->id,
            'room_number' => $request->room_number,
            'total_price' => $totalPrice,
            'note' => $request->note,
            'status' => 'ordered',
        ]);

        \App\Models\RestaurantOrderDetail::create([
            'restaurant_order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => $request->quantity,
            'price' => $menu->price,
        ]);

        if ($request->payment_status == 'paid') {
            \App\Models\Payment::create([
                'restaurant_order_id' => $order->id,
                'amount' => $totalPrice,
                'payment_method' => 'cash',
                'payment_status' => 'paid',
            ]);
        }

        return back()->with('success', 'Pesanan manual restoran berhasil dibuat!');
    }

    // --- KELOLA PENGGUNA ---
    public function updateUserRole(Request $request, $id) {
        $user = \App\Models\User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return back()->with('success', 'Role user berhasil diubah!');
    }

    public function deleteUser($id) {
        \App\Models\User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    // --- INVOICE PDF ---
    public function downloadInvoice($id)
    {
        $user = Auth::user();
        $booking = \App\Models\Booking::with(['rooms.roomType', 'guest', 'payments', 'restaurantOrder.details.menu'])->findOrFail($id);

        // Security check: Only original guest or admin/manager can download
        if ($user->role !== 'admin' && $user->role !== 'manager' && $user->role !== 'receptionist') {
            if (!$booking->guest || $booking->guest->email !== $user->email) {
                abort(403, 'Unauthorized access to this invoice.');
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoice', compact('booking'));
        
        return $pdf->download('Invoice_Hotelku_' . $booking->id . '.pdf');
    }

    // --- CRUD VOUCHER ---
    public function storeVoucher(Request $request) {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'is_active' => 'required|boolean'
        ]);

        \App\Models\Voucher::create($request->only('code', 'type', 'value', 'is_active'));
        return back()->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function updateVoucher(Request $request, $id) {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code,' . $id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:1',
            'is_active' => 'required|boolean'
        ]);

        $voucher = \App\Models\Voucher::findOrFail($id);
        $voucher->update($request->only('code', 'type', 'value', 'is_active'));
        return back()->with('success', 'Data voucher diperbarui!');
    }

    public function deleteVoucher($id) {
        \App\Models\Voucher::findOrFail($id)->delete();
        return back()->with('success', 'Voucher berhasil dihapus!');
    }

    // --- RESET PENDAPATAN ---
    public function resetRevenue() {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mereset pendapatan.');
        }

        // Hapus semua data payment yang sudah paid
        \App\Models\Payment::where('payment_status', 'paid')->delete();

        return back()->with('success', 'Seluruh data pendapatan berhasil direset ke Rp 0. Histori booking tetap tersimpan.');
    }

    // --- LAPORAN PDF ---
    public function downloadReport() {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'manager') {
            abort(403, 'Unauthorized access to report.');
        }

        $selectedHotel = request('hotel');
        if ($user->role == 'manager') {
            $myHotel = \App\Models\Hotel::where('owner_id', $user->id)->first();
            $selectedHotel = $myHotel ? $myHotel->location_key : 'UNASSIGNED_HOTEL_xxx';
        }
        
        $bookingsForStats = \App\Models\Booking::query();
        $roomsForStats = \App\Models\Room::where('status', 'occupied');
        
        if ($selectedHotel) {
            $bookingsForStats->whereHas('rooms.roomType', function($q) use ($selectedHotel) {
                if ($selectedHotel == 'Pusat') {
                    $q->whereNull('location')->orWhere('location', '');
                } else {
                    $q->where('location', $selectedHotel);
                }
            });
            
            $roomsForStats->whereHas('roomType', function($q) use ($selectedHotel) {
                if ($selectedHotel == 'Pusat') {
                    $q->whereNull('location')->orWhere('location', '');
                } else {
                    $q->where('location', $selectedHotel);
                }
            });
        }
        
        $totalBookings = $bookingsForStats->count();
        $occupiedRoomsCount = $roomsForStats->count();

        $paymentsQuery = \App\Models\Payment::where('payment_status', 'paid');
        if ($selectedHotel) {
            $paymentsQuery->where(function ($q) use ($selectedHotel) {
                $q->whereHas('booking.rooms.roomType', function($q2) use ($selectedHotel) {
                    if ($selectedHotel == 'Pusat') {
                        $q2->whereNull('location')->orWhere('location', '');
                    } else {
                        $q2->where('location', $selectedHotel);
                    }
                });
                if ($selectedHotel == 'Pusat') {
                    $q->orWhereDoesntHave('booking');
                }
            });
        }
        $totalRevenue = (clone $paymentsQuery)->sum('amount');

        $revenueData = (clone $paymentsQuery)->select(
            \DB::raw('MONTH(created_at) as month'), 
            \DB::raw('SUM(amount) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $revenueData->firstWhere('month', $i);
            $chartData[] = [
                'month' => $bulanIndo[$i-1],
                'total' => $monthData ? $monthData->total : 0
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('report', compact(
            'totalBookings', 
            'occupiedRoomsCount', 
            'totalRevenue',
            'chartData',
            'selectedHotel'
        ));
        
        return $pdf->stream('Laporan_Statistik_Hotelku_' . date('Y-m-d') . '.pdf');
    }
}