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
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['PENDING', 'COMPLETED', 'CANCELED'])->default('PENDING');
            $table->enum('delivery_method', ['PICKUP', 'DELIVERY'])->default('PICKUP');
            $table->string('phone_number', 20);
            $table->string('shipping_address', 500)->nullable();
            $table->string('note', 500)->nullable();
            $table->bigInteger('sub_total')->default(0);    // Tổng tiền sản phẩm
            $table->integer('shipping_fee')->default(0);
            $table->bigInteger('total_price')->default(0);  // Tổng tiền sản phẩm + phí ship
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
