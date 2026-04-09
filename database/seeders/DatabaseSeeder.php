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
        // 1. Data Tipe Kamar
        $standard = RoomType::create([
            'name' => 'Standard Room',
            'description' => 'Kamar nyaman dengan fasilitas dasar, AC, TV kabel, dan kamar mandi dalam.',
            'price' => 450000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?q=80&w=800&auto=format&fit=crop'
        ]);

        $deluxe = RoomType::create([
            'name' => 'Deluxe Room',
            'description' => 'Kamar luas dengan pemandangan kota, king size bed, kulkas mini, dan free WiFi.',
            'price' => 750000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=800&auto=format&fit=crop'
        ]);

        $suite = RoomType::create([
            'name' => 'Presidential Suite',
            'description' => 'Kemewahan paripurna dengan ruang tamu pribadi, bathtub, dan layanan kamar 24 jam.',
            'price' => 2500000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=800&auto=format&fit=crop'
        ]);

        // 2. Data Kamar Fisik
        Room::create(['room_type_id' => $standard->id, 'room_number' => '101', 'status' => 'available']);
        Room::create(['room_type_id' => $standard->id, 'room_number' => '102', 'status' => 'available']);
        Room::create(['room_type_id' => $deluxe->id, 'room_number' => '201', 'status' => 'available']);
        Room::create(['room_type_id' => $deluxe->id, 'room_number' => '202', 'status' => 'occupied']);
        Room::create(['room_type_id' => $suite->id, 'room_number' => '301', 'status' => 'available']);

        // 3. Data Menu Restoran
        RestaurantMenu::create([
            'name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan telur mata sapi, sate ayam, dan kerupuk udang.',
            'price' => 45000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=800&auto=format&fit=crop'
        ]);

        RestaurantMenu::create([
            'name' => 'Ayam Bakar Madu',
            'description' => 'Ayam bakar dengan olesan madu murni, disajikan dengan sambal terasi dan lalapan.',
            'price' => 55000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1598514982205-f36b96d1e8dd?q=80&w=800&auto=format&fit=crop'
        ]);

        RestaurantMenu::create([
            'name' => 'Pasta Carbonara',
            'description' => 'Spaghetti creamy dengan smoked beef, keju parmesan, dan taburan peterseli.',
            'price' => 65000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?q=80&w=800&auto=format&fit=crop'
        ]);

        RestaurantMenu::create([
            'name' => 'Kopi Susu Gula Aren',
            'description' => 'Espresso dengan susu segar dan manisnya gula aren asli yang khas.',
            'price' => 25000.00,
            'foto_url' => 'https://images.unsplash.com/photo-1593988673739-166115994fbc?q=80&w=800&auto=format&fit=crop'
        ]);
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@hotel.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Adib Rijal',
            'email' => 'adib@hotel.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}