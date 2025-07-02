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
        Schema::table('banners', function (Blueprint $table) {
            $table->enum('position', ['top', 'bottom'])->nullable()->after('id');
            $table->enum('type', ['fixed', 'slider'])->default('slider')->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            if (Schema::hasColumn('banners', 'position')) {
                $table->dropColumn('position');
            }
            if (Schema::hasColumn('banners', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
