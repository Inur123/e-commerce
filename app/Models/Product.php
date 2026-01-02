<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'seller_id',
        'name',
        'slug',
        'global_slug',
        'price',
        'stock',
        'description',
        'thumbnail',
        'sale_price',
        'status',
    ];

    protected static function booted(): void
    {
        // ✅ CREATE: generate slug kalau belum ada
        static::creating(function (Product $product) {
            if (empty($product->slug) || empty($product->global_slug)) {
                [$slug, $globalSlug] = self::generateSlugs(
                    $product->name,
                    $product->seller_id,
                    null
                );

                $product->slug = $product->slug ?: $slug;
                $product->global_slug = $product->global_slug ?: $globalSlug;
            }
        });

        // ✅ UPDATE: kalau name berubah, refresh slug (opsional)
        static::updating(function (Product $product) {
            if ($product->isDirty('name')) {
                [$slug, $globalSlug] = self::generateSlugs(
                    $product->name,
                    $product->seller_id,
                    $product->id
                );

                // kamu bisa pilih:
                // - update slug saja (per seller)
                // - global_slug tetap biar link lama tidak mati
                $product->slug = $slug;

                // kalau mau global_slug ikut berubah, uncomment:
                // $product->global_slug = $globalSlug;
            }
        });
    }

    /**
     * Generate:
     * - slug unik per seller (name, name-2, name-3,...)
     * - global_slug unik global (name-xxxxxx) => retry sampai aman
     */
    public static function generateSlugs(string $name, string $sellerId, ?string $ignoreId = null): array
    {
        $base = Str::slug($name) ?: 'product';
        $slug = '';
        $i = 0;

        do {
            // buat random pendek, misal 5 karakter
            $rand = Str::lower(Str::random(5));
            $slug = "{$base}-{$rand}";

            $exists = self::query()
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists();

            $i++;
            // aman, tapi tetap hindari loop tak terbatas
            if ($i > 10) break;
        } while ($exists);

        // global_slug bisa disamakan atau dibuat random lain
        $globalSlug = $slug;

        return [$slug, $globalSlug];
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }


    public function vouchers(): BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'voucher_products', 'product_id', 'voucher_id')
            ->withTimestamps();
    }

    public function finalPrice(): int
    {
        return (int) ($this->sale_price ?? $this->price);
    }

    // ✅ optional: route model binding default pakai global_slug
    public function getRouteKeyName(): string
    {
        return 'global_slug';
    }
}
