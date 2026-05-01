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

        if ($user->role == 'admin' || $user->role == 'owner') {
            $hotelsData = \App\Models\Hotel::with('owner')->get();
            
            if ($user->role == 'owner') {
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
            $totalRevenue = \App\Models\Payment::where('payment_status', 'paid')->sum('amount');
            
            $bookingsForStats = \App\Models\Booking::query();
            $roomsForStats = \App\Models\Room::where('status', 'occupied');
            
            if ($selectedHotel) {
                $bookingsForStats->whereHas('room.roomType', function($q) use ($selectedHotel) {
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
            $bookingsQuery = \App\Models\Booking::with(['guest', 'room.roomType', 'payments'])->orderBy('check_in', 'desc');
            if ($selectedHotel) {
                $bookingsQuery->whereHas('room.roomType', function($q) use ($selectedHotel) {
                    if ($selectedHotel == 'Pusat') {
                        $q->whereNull('location')->orWhere('location', '');
                    } else {
                        $q->where('location', $selectedHotel);
                    }
                });
            }
            $allBookings = $bookingsQuery->get();

            return view('dashboard', compact('rooms', 'menus', 'allRooms', 'users', 'totalRevenue', 'totalBookings', 'occupiedRoomsCount', 'allBookings', 'hotelsList', 'selectedHotel', 'hotelsData'));
        } else {
            $guest = \App\Models\Guest::where('email', $user->email)->first();
            $myBookings = collect();
            $myOrders = collect();
            
            if ($guest) {
                $myBookings = \App\Models\Booking::with(['room.roomType', 'payments'])->where('guest_id', $guest->id)->orderBy('created_at', 'desc')->get();
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
    public function updateBookingStatus(Request $request, $id) {
        $booking = \App\Models\Booking::with('payments', 'room', 'guest')->findOrFail($id);
        $user = Auth::user();
        $action = $request->action;

        // Cek keamanan jika user bukan admin/owner
        if ($user->role !== 'admin' && $user->role !== 'owner') {
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
            if($booking->room) {
                $booking->room->update(['status' => 'occupied']);
            }
            return back()->with('success', 'Tamu Check-In. Kamar berstatus Occupied.');
        } 
        elseif ($action == 'check_out') {
            $booking->update(['status' => 'checked_out']);
            if($booking->room) {
                $booking->room->update(['status' => 'available']);
            }
            return back()->with('success', 'Tamu Check-Out! Kamar berstatus Available kembali.');
        }
        elseif ($action == 'cancel') {
            $booking->update(['status' => 'cancelled']);
            if($booking->room) {
                $booking->room->update(['status' => 'available']);
            }
            return back()->with('success', 'Booking Dibatalkan.');
        }

        return back();
    }

    public function updateRestaurantOrderStatus(Request $request, $id) {
        $order = \App\Models\RestaurantOrder::with('payments', 'guest')->findOrFail($id);
        $user = Auth::user();
        $action = $request->action;

        if ($user->role !== 'admin' && $user->role !== 'owner') {
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
        $booking = \App\Models\Booking::with(['room.roomType', 'guest', 'payments', 'restaurantOrder.details.menu'])->findOrFail($id);

        // Security check: Only original guest or admin/owner can download
        if ($user->role !== 'admin' && $user->role !== 'owner') {
            if (!$booking->guest || $booking->guest->email !== $user->email) {
                abort(403, 'Unauthorized access to this invoice.');
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoice', compact('booking'));
        
        return $pdf->download('Invoice_Hotelku_' . $booking->id . '.pdf');
    }
}