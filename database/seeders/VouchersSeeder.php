<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VouchersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Voucher 1: berlaku semua produk (percentage)
        $vAll = Voucher::updateOrCreate(
            ['code' => 'HEMAT10'],
            [
                'discount_type' => 'percentage',
                'discount_value' => 10, // 10%
                'max_usage' => 100,
                'used_count' => 0,
                'start_date' => $now->copy()->subDays(1),
                'end_date' => $now->copy()->addDays(30),
                'applies_to' => 'all',
                'status' => 'active',
            ]
        );

        // Voucher 2: selected products (fixed)
        $vSelected = Voucher::updateOrCreate(
            ['code' => 'POTONG20000'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 20000,
                'max_usage' => 50,
                'used_count' => 0,
                'start_date' => $now->copy()->subDays(1),
                'end_date' => $now->copy()->addDays(14),
                'applies_to' => 'selected',
                'status' => 'active',
            ]
        );

        // Attach selected voucher ke beberapa produk aktif
        $products = Product::where('status', 'active')->inRandomOrder()->take(8)->get();
        if ($products->count() > 0) {
            // pivot via belongsToMany
            $vSelected->products()->sync($products->pluck('id')->all());
        }

        // Voucher 3: expired (buat test)
        Voucher::updateOrCreate(
            ['code' => 'EXPIRED5'],
            [
                'discount_type' => 'percentage',
                'discount_value' => 5,
                'max_usage' => 10,
                'used_count' => 0,
                'start_date' => $now->copy()->subDays(30),
                'end_date' => $now->copy()->subDays(1),
                'applies_to' => 'all',
                'status' => 'inactive',
            ]
        );

        $this->command?->info('VouchersSeeder: created vouchers + attached selected products.');
    }
}
