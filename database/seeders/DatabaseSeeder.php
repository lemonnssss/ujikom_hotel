<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Hotel;
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
        // ===================================================
        // 1. SEED USERS (Admin, Manager, Guest)
        // ===================================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $managerBali = User::firstOrCreate(
            ['email' => 'manager.bali@hotel.com'],
            [
                'name' => 'Made Surya Pratama',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );

        $managerJakarta = User::firstOrCreate(
            ['email' => 'manager.jakarta@hotel.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );

        $managerJogja = User::firstOrCreate(
            ['email' => 'manager.jogja@hotel.com'],
            [
                'name' => 'Sri Wulandari',
                'password' => Hash::make('password'),
                'role' => 'manager',
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

        User::firstOrCreate(
            ['email' => 'receptionist@hotel.com'],
            [
                'name' => 'Receptionist Utama',
                'password' => Hash::make('password'),
                'role' => 'receptionist',
            ]
        );

        // ===================================================
        // 2. SEED HOTELS (3 Cabang)
        // ===================================================
        $hotelBali = Hotel::firstOrCreate(
            ['location_key' => 'Bali'],
            [
                'name' => 'Premium Hotel Bali',
                'owner_id' => $managerBali->id,
            ]
        );

        $hotelJakarta = Hotel::firstOrCreate(
            ['location_key' => 'Jakarta'],
            [
                'name' => 'Premium Hotel Jakarta',
                'owner_id' => $managerJakarta->id,
            ]
        );

        $hotelJogja = Hotel::firstOrCreate(
            ['location_key' => 'Jogjakarta'],
            [
                'name' => 'Premium Hotel Jogjakarta',
                'owner_id' => $managerJogja->id,
            ]
        );

        // ===================================================
        // 3. SEED ROOM TYPES (3 tipe per hotel = 9 total)
        // ===================================================

        // --- BALI ---
        $baliStandard = RoomType::firstOrCreate(
            ['name' => 'Standard Room', 'location' => 'Bali'],
            [
                'description' => 'Kamar standar bernuansa Bali dengan kasur nyaman, AC, TV layar datar, Wi-Fi gratis, dan kamar mandi bershower air hangat. Cocok untuk wisatawan hemat.',
                'price' => 450000,
                'foto_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&auto=format&fit=crop'
            ]
        );

        $baliDeluxe = RoomType::firstOrCreate(
            ['name' => 'Deluxe Garden View', 'location' => 'Bali'],
            [
                'description' => 'Kamar deluxe dengan pemandangan taman tropis Bali, balkon pribadi, fasilitas pembuat teh/kopi, dan akses langsung ke kolam renang.',
                'price' => 850000,
                'foto_url' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&auto=format&fit=crop'
            ]
        );

        $baliVilla = RoomType::firstOrCreate(
            ['name' => 'Private Pool Villa', 'location' => 'Bali'],
            [
                'description' => 'Villa mewah dengan kolam renang pribadi, ruang tamu terpisah, bathtub outdoor bergaya Bali, butler service, dan pemandangan sawah eksotis.',
                'price' => 2500000,
                'foto_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&auto=format&fit=crop'
            ]
        );

        // --- JAKARTA ---
        $jktStandard = RoomType::firstOrCreate(
            ['name' => 'Superior Room', 'location' => 'Jakarta'],
            [
                'description' => 'Kamar superior di jantung kota Jakarta dengan fasilitas modern, Wi-Fi cepat, TV kabel, dan minibar. Ideal untuk perjalanan bisnis.',
                'price' => 550000,
                'foto_url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&auto=format&fit=crop'
            ]
        );

        $jktDeluxe = RoomType::firstOrCreate(
            ['name' => 'Deluxe City View', 'location' => 'Jakarta'],
            [
                'description' => 'Kamar deluxe dengan panorama skyline Jakarta, king-size bed premium, work desk, akses executive lounge, dan sarapan gratis.',
                'price' => 950000,
                'foto_url' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&auto=format&fit=crop'
            ]
        );

        $jktPresidential = RoomType::firstOrCreate(
            ['name' => 'Presidential Suite', 'location' => 'Jakarta'],
            [
                'description' => 'Suite presidensial mewah dengan ruang tamu luas, dining room, kamar tidur master, jacuzzi, pelayanan VIP 24 jam, dan pemandangan kota spektakuler.',
                'price' => 3500000,
                'foto_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&auto=format&fit=crop'
            ]
        );

        // --- JOGJAKARTA ---
        $jogjaStandard = RoomType::firstOrCreate(
            ['name' => 'Heritage Room', 'location' => 'Jogjakarta'],
            [
                'description' => 'Kamar bergaya heritage Jawa dengan ornamen batik, kasur empuk, AC, Wi-Fi, dan pemandangan taman. Nuansa tradisional yang hangat.',
                'price' => 400000,
                'foto_url' => 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?w=800&auto=format&fit=crop'
            ]
        );

        $jogjaDeluxe = RoomType::firstOrCreate(
            ['name' => 'Deluxe Javanese Suite', 'location' => 'Jogjakarta'],
            [
                'description' => 'Suite luas berarsitektur Jawa klasik dengan ruang duduk terpisah, teras pribadi menghadap Merapi, fasilitas spa, dan sarapan tradisional.',
                'price' => 750000,
                'foto_url' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?w=800&auto=format&fit=crop'
            ]
        );

        $jogjaRoyal = RoomType::firstOrCreate(
            ['name' => 'Royal Keraton Villa', 'location' => 'Jogjakarta'],
            [
                'description' => 'Villa eksklusif bertema Keraton dengan private garden, kolam renang alami, pendopo pribadi, layanan butler 24 jam, dan pengalaman budaya Jawa autentik.',
                'price' => 1800000,
                'foto_url' => 'https://images.unsplash.com/photo-1602002418082-a4443e081dd1?w=800&auto=format&fit=crop'
            ]
        );

        // ===================================================
        // 4. SEED ROOMS (Stok Fisik Kamar per Hotel)
        // ===================================================

        // BALI - Standard: 101-105
        for ($i = 1; $i <= 5; $i++) {
            Room::updateOrCreate(['room_number' => 'BL-10' . $i], ['room_type_id' => $baliStandard->id, 'floor' => 1, 'status' => 'available']);
        }
        // BALI - Deluxe: 201-203
        for ($i = 1; $i <= 3; $i++) {
            Room::updateOrCreate(['room_number' => 'BL-20' . $i], ['room_type_id' => $baliDeluxe->id, 'floor' => 2, 'status' => 'available']);
        }
        // BALI - Villa: V1-V2
        Room::updateOrCreate(['room_number' => 'BL-V1'], ['room_type_id' => $baliVilla->id, 'floor' => 1, 'status' => 'available']);
        Room::updateOrCreate(['room_number' => 'BL-V2'], ['room_type_id' => $baliVilla->id, 'floor' => 1, 'status' => 'available']);

        // JAKARTA - Superior: 101-105
        for ($i = 1; $i <= 5; $i++) {
            Room::updateOrCreate(['room_number' => 'JK-10' . $i], ['room_type_id' => $jktStandard->id, 'floor' => 1, 'status' => 'available']);
        }
        // JAKARTA - Deluxe: 201-204
        for ($i = 1; $i <= 4; $i++) {
            Room::updateOrCreate(['room_number' => 'JK-20' . $i], ['room_type_id' => $jktDeluxe->id, 'floor' => 2, 'status' => 'available']);
        }
        // JAKARTA - Presidential: P1-P2
        Room::updateOrCreate(['room_number' => 'JK-P1'], ['room_type_id' => $jktPresidential->id, 'floor' => 3, 'status' => 'available']);
        Room::updateOrCreate(['room_number' => 'JK-P2'], ['room_type_id' => $jktPresidential->id, 'floor' => 3, 'status' => 'available']);

        // JOGJA - Heritage: 101-105
        for ($i = 1; $i <= 5; $i++) {
            Room::updateOrCreate(['room_number' => 'YK-10' . $i], ['room_type_id' => $jogjaStandard->id, 'floor' => 1, 'status' => 'available']);
        }
        // JOGJA - Deluxe: 201-203
        for ($i = 1; $i <= 3; $i++) {
            Room::updateOrCreate(['room_number' => 'YK-20' . $i], ['room_type_id' => $jogjaDeluxe->id, 'floor' => 2, 'status' => 'available']);
        }
        // JOGJA - Royal: R1-R2
        Room::updateOrCreate(['room_number' => 'YK-R1'], ['room_type_id' => $jogjaRoyal->id, 'floor' => 1, 'status' => 'available']);
        Room::updateOrCreate(['room_number' => 'YK-R2'], ['room_type_id' => $jogjaRoyal->id, 'floor' => 1, 'status' => 'available']);

        // ===================================================
        // 5. SEED RESTAURANT MENUS (Variasi lengkap)
        // ===================================================

        // --- Makanan Utama ---
        RestaurantMenu::firstOrCreate(
            ['name' => 'Nasi Goreng Spesial'],
            [
                'description' => 'Nasi goreng autentik dengan telur mata sapi, sate ayam, kerupuk udang, dan acar segar.',
                'price' => 55000,
                'foto_url' => 'https://images.unsplash.com/photo-1623341214825-9f4f963727da?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Soto Ayam Lamongan'],
            [
                'description' => 'Soto ayam khas Lamongan dengan kuah kuning gurih, suwiran ayam, telur rebus, dan koya.',
                'price' => 45000,
                'foto_url' => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Ayam Bakar Madu'],
            [
                'description' => 'Ayam kampung bakar dengan olesan madu spesial, disajikan dengan nasi putih, lalapan, dan sambal terasi.',
                'price' => 65000,
                'foto_url' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Rendang Sapi Padang'],
            [
                'description' => 'Rendang daging sapi empuk masak hingga kering dengan rempah Padang autentik, disajikan dengan nasi hangat.',
                'price' => 75000,
                'foto_url' => 'https://images.unsplash.com/photo-1606491956689-2ea866880049?w=500&auto=format&fit=crop'
            ]
        );

        // --- Western Food ---
        RestaurantMenu::firstOrCreate(
            ['name' => 'Spaghetti Carbonara'],
            [
                'description' => 'Pasta creamy klasik Italia dengan taburan beef bacon gurih dan keju parmesan asli.',
                'price' => 75000,
                'foto_url' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Grilled Salmon Steak'],
            [
                'description' => 'Salmon fillet panggang sempurna dengan saus lemon butter, sayuran panggang, dan mashed potato.',
                'price' => 135000,
                'foto_url' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Wagyu Beef Burger'],
            [
                'description' => 'Burger premium dengan daging wagyu 200gr, keju cheddar, truffle mayo, dan kentang goreng.',
                'price' => 120000,
                'foto_url' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500&auto=format&fit=crop'
            ]
        );

        // --- Minuman ---
        RestaurantMenu::firstOrCreate(
            ['name' => 'Tropical Fresh Juice'],
            [
                'description' => 'Campuran segar dari nanas, jeruk, dan mangga tropis, kaya akan vitamin dan menyegarkan.',
                'price' => 35000,
                'foto_url' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Iced Kopi Susu Gula Aren'],
            [
                'description' => 'Kopi robusta pilihan dengan susu segar dan gula aren asli, disajikan dingin dengan es batu.',
                'price' => 32000,
                'foto_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Matcha Latte'],
            [
                'description' => 'Green tea matcha Jepang premium dengan susu segar, bisa disajikan panas atau dingin.',
                'price' => 38000,
                'foto_url' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?w=500&auto=format&fit=crop'
            ]
        );

        // --- Dessert ---
        RestaurantMenu::firstOrCreate(
            ['name' => 'Es Campur Nusantara'],
            [
                'description' => 'Aneka jelly, cincau, kolang-kaling, nangka, dan alpukat dengan sirup gula merah dan santan.',
                'price' => 28000,
                'foto_url' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=500&auto=format&fit=crop'
            ]
        );

        RestaurantMenu::firstOrCreate(
            ['name' => 'Chocolate Lava Cake'],
            [
                'description' => 'Kue cokelat hangat dengan lelehan cokelat di dalamnya, disajikan dengan es krim vanilla dan berry segar.',
                'price' => 55000,
                'foto_url' => 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=500&auto=format&fit=crop'
            ]
        );
    }
}