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
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('street_address_1');
            $table->dropColumn('street_address_2');
            $table->string('customer_name')->nullable()->after('title');
            $table->string('email')->nullable()->after('customer_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('street_address')->nullable()->after('phone');
            $table->string('apt_or_floor')->nullable()->after('street_address');
            $table->string('city')->nullable()->after('apt_or_floor');
            $table->string('country')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('street_address_1')->nullable()->after('type');
            $table->string('street_address_2')->nullable()->after('street_address_1');
            $table->dropColumn('customer_name');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('street_address');
            $table->dropColumn('apt_or_floor');
            $table->dropColumn('city');
            $table->dropColumn('country');
        });
    }
};
