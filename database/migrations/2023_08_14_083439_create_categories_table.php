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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('renting')->default(false);
            $table->longText('description');
            $table->unsignedInteger('min_youngest_driver_age');
            $table->string('image')->nullable();
            $table->unsignedInteger('no_of_adults');
            $table->unsignedInteger('no_of_children');
            $table->unsignedInteger('no_of_large_case');
            $table->unsignedInteger('no_of_small_case');
            $table->double('emission_rate');
            $table->longText('vehicle_description_url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
