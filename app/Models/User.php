<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Seller -> products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // Buyer -> orders
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'buyer_id');
    }

    // Seller -> sold items (order_items)
    public function soldItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }
}
