<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transaction details for the transaction.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get the products for the transaction through transaction details.
     */
    public function products()
    {
        return $this->hasManyThrough(Product::class, TransactionDetail::class);
    }

    /**
     * Check if transaction is penjualan.
     */
    public function isPenjualan()
    {
        return $this->type === 'penjualan';
    }

    /**
     * Check if transaction is pembelian.
     */
    public function isPembelian()
    {
        return $this->type === 'pembelian';
    }
}
