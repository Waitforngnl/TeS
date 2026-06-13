<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột thành phần và hướng dẫn sử dụng vào sau cột mô tả (description)
            $table->text('ingredients')->nullable()->after('description');
            $table->text('usage_instruction')->nullable()->after('ingredients');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Khôi phục lại nếu cần rollback
            $table->dropColumn(['ingredients', 'usage_instruction']);
        });
    }
};