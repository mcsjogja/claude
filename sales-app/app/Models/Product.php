<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'category',
        'stock',
        'purchase_price',
        'selling_price',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'stock' => 'integer',
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
        return $this->selling_price - $this->purchase_price;
    }

    /**
     * Get profit percentage
     */
    public function getProfitPercentage()
    {
        if ($this->purchase_price == 0) return 0;
        return (($this->selling_price - $this->purchase_price) / $this->purchase_price) * 100;
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }
}
