<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ReceiptProduct extends Pivot
{
    /**
     * The table associated with the model.
     */
    protected $table = 'receipt_product';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'receipt_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the receipt that owns the receipt product.
     */
    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    /**
     * Get the product that owns the receipt product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}