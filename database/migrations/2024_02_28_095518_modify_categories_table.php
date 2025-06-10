<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function ($table) {
            // dropping unnecessary columns from categories table
            $table->dropColumn(
                'renting',
                'min_youngest_driver_age',
                'no_of_adults',
                'no_of_children',
                'no_of_large_case',
                'no_of_small_case',
                'emission_rate',
                'vehicle_description_url',
                'description'
            );

            // adding new columns to categories table
            $table->string('slug')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function ($table) {
            // dropping new columns from categories table
            $table->dropColumn('slug');

            // re-adding unnecessary columns to categories table
            $table->boolean('renting')->default(false);
            $table->unsignedInteger('min_youngest_driver_age');
            $table->unsignedInteger('no_of_adults');
            $table->unsignedInteger('no_of_children');
            $table->unsignedInteger('no_of_large_case');
            $table->unsignedInteger('no_of_small_case');
            $table->double('emission_rate');
            $table->longText('vehicle_description_url');
            $table->longText('description');
        });

    }
};
