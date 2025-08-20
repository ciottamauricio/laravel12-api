<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number', 50)->unique();
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->char('currency_code', 3)->default('USD');
            $table->string('status', 20)->default('issued');
            $table->foreignId('customer_id')->constrained('customer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt');
    }
};