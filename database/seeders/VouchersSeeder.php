<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VouchersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ======================
        // Voucher Platform (Admin)
        // ======================
        $vAll = Voucher::updateOrCreate(
            ['code' => 'HEMAT10'],
            [
                'owner_type' => 'platform',
                'seller_id' => null,
                'discount_type' => 'percentage',
                'discount_value' => 10, // 10%
                'max_usage' => 100,
                'used_count' => 0,
                'start_date' => $now->copy()->subDay(),
                'end_date' => $now->copy()->addDays(30),
                'applies_to' => 'all',
                'status' => 'active',
            ]
        );

        // ======================
        // Voucher Seller (contoh 1 toko)
        // ======================
        $seller = User::where('role', 'seller')->inRandomOrder()->first();
        if ($seller) {
            $vSelected = Voucher::updateOrCreate(
                ['code' => 'TOKOHEMAT20'],
                [
                    'owner_type' => 'seller',
                    'seller_id' => $seller->id,
                    'discount_type' => 'fixed',
                    'discount_value' => 20000,
                    'max_usage' => 50,
                    'used_count' => 0,
                    'start_date' => $now->copy()->subDay(),
                    'end_date' => $now->copy()->addDays(14),
                    'applies_to' => 'selected',
                    'status' => 'active',
                ]
            );

            // Ambil beberapa produk dari seller ini
            $products = Product::where('seller_id', $seller->id)
                ->where('status', 'active')
                ->inRandomOrder()
                ->take(5)
                ->get();

            if ($products->count() > 0) {
                $vSelected->products()->sync($products->pluck('id')->all());
            }
        }

        // ======================
        // Voucher Expired (test)
        // ======================
        Voucher::updateOrCreate(
            ['code' => 'EXPIRED5'],
            [
                'owner_type' => 'platform',
                'seller_id' => null,
                'discount_type' => 'percentage',
                'discount_value' => 5,
                'max_usage' => 10,
                'used_count' => 0,
                'start_date' => $now->copy()->subDays(30),
                'end_date' => $now->copy()->subDay(),
                'applies_to' => 'all',
                'status' => 'inactive',
            ]
        );

        $this->command?->info('✅ VouchersSeeder: platform + seller vouchers created successfully.');
    }
}
