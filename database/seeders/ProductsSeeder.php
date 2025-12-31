<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $sellers = User::where('role', 'seller')->get();

        if ($sellers->isEmpty()) {
            $this->command?->warn('No sellers found. Run UsersSeeder first.');
            return;
        }

        // total produk: 30 (dibagi rata ke sellers)
        $productNames = [
            'Kaos Polos Premium', 'Hoodie Basic', 'Celana Chino', 'Sepatu Sneakers', 'Tas Ransel',
            'Jam Tangan Casual', 'Kacamata Hitam', 'Topi Baseball', 'Jaket Denim', 'Kemeja Flanel',
            'Sandal Slide', 'Dompet Kulit', 'Ikat Pinggang', 'Kaos Oversize', 'Polo Shirt',
        ];

        $created = 0;

        foreach ($sellers as $seller) {
            // setiap seller bikin 6 produk -> 5 sellers * 6 = 30
            for ($i = 0; $i < 6; $i++) {
                $name = $productNames[array_rand($productNames)] . " - " . strtoupper(substr(md5($seller->id . $i), 0, 4));

                $price = random_int(50000, 500000);
                $hasSale = (random_int(1, 100) <= 40); // 40% ada sale_price
                $salePrice = $hasSale ? (int) max(1000, $price - random_int(5000, (int)($price * 0.3))) : null;

                $product = Product::create([
                    'seller_id' => $seller->id,
                    'name' => $name,
                    'price' => $price,
                    'stock' => random_int(0, 200),
                    'description' => 'Produk contoh untuk testing ecommerce. Kualitas bagus, pengiriman cepat.',
                    'thumbnail' => "products/thumbnails/{$seller->id}/" . uniqid() . ".jpg",
                    'sale_price' => $salePrice,
                    'status' => (random_int(1, 100) <= 85) ? 'active' : 'inactive', // 85% aktif
                ]);

                // Gallery images: 0-4 gambar, sort_order mulai dari 2
                $galleryCount = random_int(0, 4);
                for ($g = 0; $g < $galleryCount; $g++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => "products/gallery/{$product->id}/" . uniqid() . ".jpg",
                        'sort_order' => 2 + $g,
                    ]);
                }

                $created++;
            }
        }

        $this->command?->info("ProductsSeeder: created {$created} products (with random gallery images).");
    }
}
