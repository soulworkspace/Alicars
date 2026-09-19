<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_orders_table.php
public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('buyer_id')->constrained('users');
        $table->foreignId('listing_id')->constrained('ads'); // أو اسم جدول الإعلانات عندك
        $table->foreignId('seller_id')->constrained('users');
        
        $table->string('size');
        $table->string('color');
        $table->integer('quantity')->default(1);
        $table->decimal('total_price', 10, 2);
        
        $table->string('status')->default('pending');
        $table->string('phone');
        
        // --- الحقول التي تسببت في الخطأ ---
        $table->string('city'); 
        $table->text('shipping_address');
        $table->text('notes')->nullable(); 
        // ---------------------------------

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
