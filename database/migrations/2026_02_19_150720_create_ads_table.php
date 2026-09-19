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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('price_type', ['fixed', 'negotiable', 'free'])->default('fixed');
            $table->enum('currency', ['DZD', 'USD', 'EUR'])->default('DZD');
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('used');
            $table->enum('status', ['pending', 'active', 'rejected', 'sold', 'archived'])->default('pending');
            $table->enum('template', ['real_estate', 'car', 'general'])->default('general');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_messenger')->nullable();
            $table->boolean('show_contact_info')->default(true);
            $table->boolean('accept_offers')->default(false);
            $table->boolean('is_negotiable')->default(false);
            $table->json('seo_meta')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
