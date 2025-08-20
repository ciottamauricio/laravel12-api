<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'product_name',
        'description',
        'unit_price',
        'tax_rate',
        'currency_code',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the receipts that contain this product.
     */
    public function receipts()
    {
        return $this->belongsToMany(Receipt::class, 'receipt_product')
                    ->withPivot('quantity', 'unit_price', 'total_price')
                    ->withTimestamps();
    }
}
