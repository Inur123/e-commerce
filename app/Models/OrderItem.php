<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'seller_id',
        'qty',
        'price',
        'subtotal',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // ✅ FIX: produk bisa null karena sudah dihapus
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id')
            ->withDefault([
                'name' => '[Produk sudah dihapus]',
                'thumbnail' => null,
                'price' => 0,
                'sale_price' => null,
                'status' => 'inactive',
            ]);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
