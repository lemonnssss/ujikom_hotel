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
        $queryRoom = RoomType::query();
        if ($request->has('search_room')) {
            $queryRoom->where('name', 'like', '%' . $request->search_room . '%');
        }
        $rooms = $queryRoom->get();

        $queryMenu = RestaurantMenu::query();
        if ($request->has('search_menu')) {
            $queryMenu->where('name', 'like', '%' . $request->search_menu . '%');
        }
        $menus = $queryMenu->get();

        return view('dashboard', compact('rooms', 'menus'));
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
}