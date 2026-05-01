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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('note');
            $table->string('midtrans_transaction_id')->nullable()->after('snap_token');
            $table->string('midtrans_order_id')->nullable()->unique()->after('midtrans_transaction_id');
        });

        // Update payment_method enum untuk mendukung Midtrans methods
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method VARCHAR(50) DEFAULT NULL");

        // Update payment_status enum untuk mendukung expired
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_status VARCHAR(20) DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_transaction_id', 'midtrans_order_id']);
        });

        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method ENUM('cash', 'transfer', 'credit_card', 'e_wallet')");
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending'");
    }
};
