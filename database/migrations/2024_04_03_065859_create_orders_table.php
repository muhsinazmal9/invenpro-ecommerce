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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->foreignId('user_id')->constrained()->restrictOnUpdate();
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('delivery_instruction')->nullable();
            $table->string('delivery_time');
            $table->string('delivery_date');
            $table->string('delivery_type')->comment('pickup, delivery');
            // $table->string('contact_number');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->default('cod');
            $table->string('order_status')->default('placed');
            $table->boolean('is_gift')->default(false);
            $table->string('gift')->nullable();
            $table->string('coupon_code')->nullable();
            $table->double('discount')->nullable();
            $table->double('tax')->nullable();
            $table->double('service_amount')->nullable();
            $table->double('subtotal')->nullable();
            $table->double('shipping_charge')->nullable();
            $table->double('grand_total')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
