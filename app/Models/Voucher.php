<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'owner_type',
        'seller_id',
        'code',
        'discount_type',
        'discount_value',
        'max_usage',
        'used_count',
        'max_usage_per_user',
        'min_purchase',
        'start_date',
        'end_date',
        'applies_to',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_value' => 'integer',
        'max_usage' => 'integer',
        'used_count' => 'integer',
        'max_usage_per_user' => 'integer',
        'min_purchase' => 'integer',
    ];

    // ✅ RELASI ke seller (user)
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // ✅ jika voucher applies_to = selected
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'voucher_products', 'voucher_id', 'product_id')
            ->withTimestamps();
    }

    // ✅ dipakai di orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'voucher_id');
    }
}
