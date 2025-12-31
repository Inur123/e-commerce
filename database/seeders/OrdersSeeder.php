<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrdersSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::where('role', 'buyer')->get();
        $products = Product::where('status', 'active')->where('stock', '>', 0)->get();
        $voucherAll = Voucher::where('code', 'HEMAT10')->first();

        if ($buyers->isEmpty() || $products->isEmpty()) {
            $this->command?->warn('OrdersSeeder: buyers/products empty. Run UsersSeeder & ProductsSeeder first.');
            return;
        }

        $statuses = ['pending_payment', 'paid', 'shipped', 'completed', 'canceled', 'expired'];
        $paymentTypes = ['bank_transfer', 'qris', 'credit_card', 'ewallet'];

        $totalOrders = 20;

        for ($i = 1; $i <= $totalOrders; $i++) {
            $buyer = $buyers->random();

            // pilih 1-3 item
            $pickedProducts = $products->random(random_int(1, min(3, $products->count())));

            $subTotalSum = 0;
            $itemsPayload = [];

            foreach ($pickedProducts as $p) {
                $qty = random_int(1, 3);
                $finalPrice = (int)($p->sale_price ?? $p->price);
                $subtotal = $finalPrice * $qty;

                $subTotalSum += $subtotal;

                $itemsPayload[] = [
                    'product' => $p,
                    'seller_id' => $p->seller_id,
                    'qty' => $qty,
                    'price' => $finalPrice,
                    'subtotal' => $subtotal,
                ];
            }

            // 40% order pakai voucher HEMAT10 (applies_to all)
            $useVoucher = ($voucherAll && random_int(1, 100) <= 40);
            $discountAmount = null;
            $voucherId = null;

            if ($useVoucher) {
                // percentage 10%
                $discountAmount = (int) floor($subTotalSum * ((int)$voucherAll->discount_value) / 100);
                $voucherId = $voucherAll->id;
            }

            $totalAmount = $subTotalSum - (int)($discountAmount ?? 0);

            $status = $statuses[array_rand($statuses)];
            $orderCode = 'ORD-' . Carbon::now()->format('YmdHis') . '-' . str_pad((string)$i, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'buyer_id' => $buyer->id,
                'order_code' => $orderCode,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'voucher_id' => $voucherId,
                'status' => $status,
                'address' => 'Jl. Contoh No. ' . random_int(1, 200) . ', Jakarta',
                'phone' => '08' . random_int(1111111111, 9999999999),
                'note' => (random_int(1, 100) <= 50) ? 'Tolong packing rapi ya.' : null,
            ]);

            // buat order items
            foreach ($itemsPayload as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $it['product']->id,
                    'seller_id' => $it['seller_id'],
                    'qty' => $it['qty'],
                    'price' => $it['price'],
                    'subtotal' => $it['subtotal'],
                ]);
            }

            // payments: biasanya ada kalau status paid/shipped/completed (kadang pending juga ada)
            if (in_array($status, ['paid', 'shipped', 'completed', 'pending_payment'], true)) {
                Payment::create([
                    'order_id' => $order->id,
                    'transaction_id' => 'TRX-' . strtoupper(substr(md5($order->id), 0, 10)),
                    'payment_type' => $paymentTypes[array_rand($paymentTypes)],
                    'status' => match ($status) {
                        'pending_payment' => 'pending',
                        'paid' => 'settlement',
                        'shipped' => 'settlement',
                        'completed' => 'settlement',
                        default => 'unknown',
                    },
                    'gross_amount' => $totalAmount,
                    'raw_response' => [
                        'mock' => true,
                        'order_code' => $orderCode,
                        'gateway_status' => $status,
                    ],
                ]);
            }
        }

        $this->command?->info("OrdersSeeder: created {$totalOrders} orders + items + payments.");
    }
}
