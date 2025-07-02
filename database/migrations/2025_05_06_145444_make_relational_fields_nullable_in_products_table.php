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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropForeign(['brand_id']);
            $table->foreignId('category_id')->nullable()->change()->constrained()->onDelete('restrict');
            $table->foreignId('subcategory_id')->nullable()->change()->constrained()->onDelete('restrict');
            $table->foreignId('brand_id')->nullable()->change()->constrained()->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropForeign(['brand_id']);
            $table->foreignId('category_id')->nullable(false)->change()->constrained()->onDelete('restrict');
            $table->foreignId('subcategory_id')->nullable(false)->change()->constrained()->onDelete('restrict');
            $table->foreignId('brand_id')->nullable(false)->change()->constrained()->onDelete('restrict');
        });
    }
};