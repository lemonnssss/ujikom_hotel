<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RestaurantMenu;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'guest@hotel.com'],
            [
                'name' => 'Demo Guest',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 2. Seed Room Types
        $standard = RoomType::firstOrCreate(
            ['name' => 'Standard Room'],
            [
                'description' => 'Kamar standar dengan fasilitas kasur nyaman, TV layar datar, Wi-Fi gratis, dan kamar mandi dalam bershower air hangat.',
                'price' => 500000,
                'location' => 'Lantai 1 - Gedung Utama',
                'foto_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&auto=format&fit=crop'
            ]
        );

        $deluxe = RoomType::firstOrCreate(
            ['name' => 'Deluxe Room'],
            [
                'description' => 'Kamar lebih luas dengan balkon pribadi, pemandangan kota, fasilitas pembuat teh/kopi, dan akses kolam renang.',
                'price' => 850000,
                'location' => 'Lantai 2 - Menara Selatan',
                'foto_url' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&auto=format&fit=crop'
            ]
        );

        $suite = RoomType::firstOrCreate(
            ['name' => 'Executive Suite'],
            [
                'description' => 'Kamar mewah bergaya apartemen dengan ruang tamu terpisah, bathtub besar, akses VIP Lounge, dan pelayanan pribadi.',
                'price' => 1500000,
                'location' => 'Lantai Atas - Menara Utama',
                'foto_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&auto=format&fit=crop'
            ]
        );

        // 3. Seed Rooms (Stok Fisik Kamar)
        // Standard rooms: 101 - 105
        for ($i = 1; $i <= 5; $i++) {
            Room::firstOrCreate([
                'room_number' => '10' . $i,
            ], [
                'room_type_id' => $standard->id,
                'status' => 'available'
            ]);
        }

        // Deluxe rooms: 201 - 203
        for ($i = 1; $i <= 3; $i++) {
            Room::firstOrCreate([
                'room_number' => '20' . $i,
            ], [
                'room_type_id' => $deluxe->id,
                'status' => 'available'
            ]);
        }

        // Suite rooms: VIP-1, VIP-2
        Room::firstOrCreate(['room_number' => 'VIP-1'], ['room_type_id' => $suite->id, 'status' => 'available']);
        Room::firstOrCreate(['room_number' => 'VIP-2'], ['room_type_id' => $suite->id, 'status' => 'available']);

        // 4. Seed Restaurant Menus
        RestaurantMenu::firstOrCreate(
            ['name' => 'Nasi Goreng Spesial'],
            [
                'description' => 'Nasi goreng autentik dengan telur mata sapi, sate ayam, dan kerupuk udang.',
                'price' => 450000, // wait let's make it realistic
                'foto_url' => 'https://images.unsplash.com/photo-1623341214825-9f4f963727da?w=500&auto=format&fit=crop'
            ]
        );
        $nasiGoreng = RestaurantMenu::where('name', 'Nasi Goreng Spesial')->first();
        $nasiGoreng->update(['price' => 55000]); // Realisti price

        RestaurantMenu::firstOrCreate(
            ['name' => 'Spaghetti Carbonara'],
            [
                'description' => 'Pasta creamy klasik Italia dengan taburan beef bacon gurih dan keju parmesan.',
                'price' => 75000,
                'foto_url' => 'https://images.unsplash.com/photo-1612874687590-c6b76cb5febe?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Tropical Fresh Juice'],
            [
                'description' => 'Campuran dari nanas, jeruk, dan mangga tropis segar, kaya akan vitamin.',
                'price' => 35000,
                'foto_url' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=500&auto=format&fit=crop'
            ]
        );
    }
}