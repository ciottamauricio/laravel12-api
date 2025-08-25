<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cosumer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
         //   'name' => 'mauricio',
        //    'email' => 'mauricio@example.com',
        //]);

        // Create sample customers
        $customers = [
            [
                'customer_name' => 'ABC Corporation',
                'email' => 'contact@abc-corp.com',
                'phone' => '+1-555-123-4567',
                'tax_id' => '12-3456789',
                'address' => '123 Business St, New York, NY 10001',
            ],
            [
                'customer_name' => 'XYZ Industries',
                'email' => 'billing@xyz-industries.com',
                'phone' => '+1-555-987-6543',
                'tax_id' => '98-7654321',
                'address' => '456 Industrial Ave, Los Angeles, CA 90210',
            ],
            [
                'customer_name' => 'Tech Solutions LLC',
                'email' => 'accounts@techsolutions.com',
                'phone' => '+1-555-456-7890',
                'tax_id' => '45-6789012',
                'address' => '789 Tech Park Dr, San Francisco, CA 94107',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }

        // Create sample products
        $products = [
            [
                'product_name' => 'Professional Consulting',
                'description' => 'Hourly professional consulting services',
                'unit_price' => 150.00,
                'tax_rate' => 8.25,
                'currency_code' => 'USD',
            ],
            [
                'product_name' => 'Software License',
                'description' => 'Annual software license subscription',
                'unit_price' => 299.99,
                'tax_rate' => 8.25,
                'currency_code' => 'USD',
            ],
            [
                'product_name' => 'Web Development',
                'description' => 'Custom web development services',
                'unit_price' => 75.00,
                'tax_rate' => 8.25,
                'currency_code' => 'USD',
            ],
            [
                'product_name' => 'Database Setup',
                'description' => 'Database design and configuration',
                'unit_price' => 200.00,
                'tax_rate' => 8.25,
                'currency_code' => 'USD',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create sample receipts
        $receipt1 = Receipt::create([
            'receipt_number' => 'RCP-2024-001',
            'issue_date' => '2024-01-15',
            'due_date' => '2024-02-15',
            'total_amount' => 1624.69,
            'tax_amount' => 124.69,
            'currency_code' => 'USD',
            'status' => 'issued',
            'customer_id' => 1,
        ]);

        // Attach products to receipt
        $receipt1->products()->attach(1, [
            'quantity' => 8,
            'unit_price' => 150.00,
            'total_price' => 1200.00,
        ]);

        $receipt1->products()->attach(2, [
            'quantity' => 1,
            'unit_price' => 299.99,
            'total_price' => 299.99,
        ]);

        $receipt2 = Receipt::create([
            'receipt_number' => 'RCP-2024-002',
            'issue_date' => '2024-01-16',
            'due_date' => '2024-02-16',
            'total_amount' => 811.22,
            'tax_amount' => 61.22,
            'currency_code' => 'USD',
            'status' => 'paid',
            'customer_id' => 2,
        ]);

        $receipt2->products()->attach(3, [
            'quantity' => 10,
            'unit_price' => 75.00,
            'total_price' => 750.00,
        ]);
    }
}
