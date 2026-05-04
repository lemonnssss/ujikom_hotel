<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add 'manager' to the enum (keep 'owner' temporarily)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'owner', 'manager', 'user') DEFAULT 'user'");
        // Step 2: Update existing 'owner' users to 'manager'
        DB::table('users')->where('role', 'owner')->update(['role' => 'manager']);
        // Step 3: Remove 'owner' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'user') DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'owner', 'manager', 'user') DEFAULT 'user'");
        DB::table('users')->where('role', 'manager')->update(['role' => 'owner']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'owner', 'user') DEFAULT 'user'");
    }
};
