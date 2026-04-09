<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RestaurantMenu;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Sample Data Tipe Kamar
        $deluxe = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'Kamar luas dengan pemandangan kota, king size bed, dan free WiFi.',
            'price' => 750000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=800&auto=format&fit=crop'
        ]);

        $suite = RoomType::create([
            'name' => 'Presidential Suite',
            'description' => 'Kemewahan paripurna dengan ruang tamu pribadi, bathtub, dan layanan kamar 24 jam.',
            'price' => 2500000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=800&auto=format&fit=crop'
        ]);

        // 2. Sample Data Kamar Fisik
        Room::create(['room_type_id' => $deluxe->id, 'room_number' => '101', 'status' => 'available']);
        Room::create(['room_type_id' => $deluxe->id, 'room_number' => '102', 'status' => 'occupied']);
        Room::create(['room_type_id' => $suite->id, 'room_number' => '201', 'status' => 'available']);

        // 3. Sample Data Menu Restoran
        RestaurantMenu::create([
            'name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan telur mata sapi, sate ayam, dan kerupuk udang.',
            'price' => 45000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=800&auto=format&fit=crop'
        ]);
    }
}