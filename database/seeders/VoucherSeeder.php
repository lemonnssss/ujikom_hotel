<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Voucher::create(['code' => 'PROMO10', 'type' => 'percent', 'value' => 10]);
        \App\Models\Voucher::create(['code' => 'SUPER50', 'type' => 'fixed', 'value' => 50000]);
    }
}
