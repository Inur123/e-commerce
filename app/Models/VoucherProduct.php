<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoucherProduct extends Model
{
    use HasUuids;

    protected $table = 'voucher_products';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'voucher_id',
        'product_id',
    ];

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
