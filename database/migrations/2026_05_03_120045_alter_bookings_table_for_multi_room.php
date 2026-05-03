<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add new columns to bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('adults_count')->default(1)->after('check_out');
            $table->integer('children_count')->default(0)->after('adults_count');
            $table->integer('room_qty')->default(1)->after('children_count');
            $table->text('special_requests')->nullable()->after('room_qty');
        });

        // 2. Create pivot table booking_room
        Schema::create('booking_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Migrate existing room_id data to booking_room
        $bookings = DB::table('bookings')->whereNotNull('room_id')->get();
        foreach ($bookings as $booking) {
            DB::table('booking_room')->insert([
                'booking_id' => $booking->id,
                'room_id' => $booking->room_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Drop room_id from bookings
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->constrained()->onDelete('cascade');
        });

        $bookingRooms = DB::table('booking_room')->get();
        foreach ($bookingRooms as $br) {
            DB::table('bookings')->where('id', $br->booking_id)->update(['room_id' => $br->room_id]);
        }

        Schema::dropIfExists('booking_room');

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['adults_count', 'children_count', 'room_qty', 'special_requests']);
        });
    }
};
