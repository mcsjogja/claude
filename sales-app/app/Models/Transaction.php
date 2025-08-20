<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    /**
     * Relasi dengan user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan transaction details
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Check if transaction is sale
     */
    public function isPenjualan()
    {
        return $this->type === 'penjualan';
    }

    /**
     * Check if transaction is purchase
     */
    public function isPembelian()
    {
        return $this->type === 'pembelian';
    }
}
