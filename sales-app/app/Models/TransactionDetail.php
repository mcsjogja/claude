<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    /**
     * Relasi dengan transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Relasi dengan product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calculate subtotal automatically
     */
    protected static function booted()
    {
        static::saving(function ($transactionDetail) {
            $transactionDetail->subtotal = $transactionDetail->quantity * $transactionDetail->price;
        });
    }
}
