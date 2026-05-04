<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RestaurantMenu;

class HotelSeeder extends Seeder
{
    public function run()
    {
        // This seeder is now handled by DatabaseSeeder.
        // Call the main seeder instead.
        $this->call(DatabaseSeeder::class);
    }
}