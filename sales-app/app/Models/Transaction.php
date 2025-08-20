<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'jenis_transaksi',
        'user_id',
        'total_amount',
        'keterangan',
        'tanggal_transaksi',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'tanggal_transaksi' => 'datetime',
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
     * Generate nomor transaksi
     */
    public static function generateNomorTransaksi($jenis)
    {
        $prefix = $jenis === 'penjualan' ? 'PJ' : 'PB';
        $date = date('Ymd');
        $lastTransaction = self::where('nomor_transaksi', 'like', $prefix . $date . '%')
                              ->orderBy('nomor_transaksi', 'desc')
                              ->first();
        
        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->nomor_transaksi, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if transaction is sale
     */
    public function isPenjualan()
    {
        return $this->jenis_transaksi === 'penjualan';
    }

    /**
     * Check if transaction is purchase
     */
    public function isPembelian()
    {
        return $this->jenis_transaksi === 'pembelian';
    }
}
