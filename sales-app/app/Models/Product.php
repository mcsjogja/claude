<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori',
        'stok',
        'harga_beli',
        'harga_jual',
        'deskripsi',
    ];

    protected function casts(): array
    {
        return [
            'harga_beli' => 'decimal:2',
            'harga_jual' => 'decimal:2',
            'stok' => 'integer',
        ];
    }

    /**
     * Relasi dengan transaction details
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get profit margin
     */
    public function getProfitMargin()
    {
        return $this->harga_jual - $this->harga_beli;
    }

    /**
     * Get profit percentage
     */
    public function getProfitPercentage()
    {
        if ($this->harga_beli == 0) return 0;
        return (($this->harga_jual - $this->harga_beli) / $this->harga_beli) * 100;
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stok > 0;
    }
}
