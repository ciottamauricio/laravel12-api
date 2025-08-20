<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table = 'receipt';

    protected $fillable = [
        'receipt_number',
        'issue_date',
        'due_date',
        'total_amount',
        'tax_amount',
        'currency_code',
        'status',
        'customer_id',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns the receipt.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the products for the receipt.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'receipt_product')
                    ->withPivot('quantity', 'unit_price', 'total_price')
                    ->withTimestamps();
    }

    /**
     * Generate a unique receipt number.
     */
    public static function generateReceiptNumber()
    {
        $year = date('Y');
        $lastReceipt = self::where('receipt_number', 'like', "RCP-{$year}-%")
                          ->orderBy('receipt_number', 'desc')
                          ->first();

        if ($lastReceipt) {
            $lastNumber = (int) substr($lastReceipt->receipt_number, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return "RCP-{$year}-{$newNumber}";
    }
}
