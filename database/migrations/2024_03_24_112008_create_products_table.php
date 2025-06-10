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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('sku')->nullable();
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->enum('discount_type', ['FIXED', 'PERCENTAGE'])->nullable();
            $table->integer('stock')->default(0);
            $table->string('seo_title')->nullable();
            $table->string('keywords')->nullable();
            $table->text('seo_description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('restrict')->nullable();
            $table->foreignId('subcategory_id')->constrained()->onDelete('restrict')->nullable();
            $table->foreignId('brand_id')->constrained()->onDelete('restrict')->nullable();
            $table->boolean('featured')->default(false);
            $table->enum('status', ['PUBLISHED', 'DRAFT'])->default('DRAFT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
