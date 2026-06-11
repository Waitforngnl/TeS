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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->enum('method', ['COD', 'VNPAY'])->default('COD');
            $table->enum('status', ['UNPAID', 'PAID', 'FAILED', 'REFUNDED'])->default('UNPAID');
            $table->timestamp('paid_at')->nullable();
            $table->bigInteger('amount')->default(0);   // Số tiền cần thanh toán

            // Cho bên VNPAY
            $table->string('provider_txn_id')->nullable();
            $table->longText('provider_payload')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
