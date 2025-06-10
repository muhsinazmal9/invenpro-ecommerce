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
        Schema::table('promos', function (Blueprint $table) {
            $table->string('code');
            $table->double('discount');
            $table->enum('discount_type', ['FIXED', 'PERCENTAGE']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('discount');
            $table->dropColumn('discount_type');

        });
    }
};
