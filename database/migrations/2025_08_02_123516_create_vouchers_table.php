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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            // Mã giảm giá (ví dụ: SAVE20, WELCOME) - duy nhất
            $table->string('code')->unique();

            // Tên hiển thị của mã giảm giá
            $table->string('name');

            // Mô tả mã giảm giá (có thể bỏ trống)
            $table->text('description')->nullable();

            // Cấu hình giảm giá
            $table->enum('type', ['percentage', 'fixed']); // Kiểu giảm giá: phần trăm hoặc số tiền cố định
            $table->decimal('value', 10, 2); // Giá trị giảm (phần trăm hoặc số tiền)
            $table->decimal('min_order_amount', 10, 2)->default(0); // Giá trị đơn hàng tối thiểu để áp dụng mã
            $table->decimal('max_discount_amount', 10, 2)->nullable(); // Giảm giá tối đa (áp dụng cho loại phần trăm)

            // Giới hạn sử dụng
            $table->integer('usage_limit')->nullable(); // Tổng số lần sử dụng (null = không giới hạn)
            $table->integer('usage_limit_per_user')->default(1); // Giới hạn số lần sử dụng mỗi người dùng
            $table->integer('used_count')->default(0); // Số lần đã được sử dụng

            // Thời gian hiệu lực
            $table->timestamp('starts_at')->nullable(); // Thời gian bắt đầu áp dụng mã
            $table->timestamp('expires_at')->nullable(); // Thời gian hết hạn của mã

            // Trạng thái và thiết lập
            $table->boolean('is_active')->default(true); // Mã đang hoạt động hay không
            $table->boolean('is_public')->default(true); // Mã công khai hoặc riêng tư/nhắm mục tiêu

            // Phạm vi áp dụng
            $table->json('applicable_categories')->nullable(); // ID danh mục được áp dụng (null = tất cả)
            $table->json('applicable_products')->nullable(); // ID sản phẩm được áp dụng (null = tất cả)
            $table->json('excluded_categories')->nullable(); // ID danh mục bị loại trừ
            $table->json('excluded_products')->nullable(); // ID sản phẩm bị loại trừ

            $table->timestamps();

            // Tạo index để tìm nhanh theo mã và trạng thái
            $table->index(['code', 'is_active']);

            // Tạo index để lọc theo thời gian hiệu lực
            $table->index(['starts_at', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
