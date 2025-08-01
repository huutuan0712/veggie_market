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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->unique()->after('user_id');
            $table->decimal('total_amount', 10, 2)->after('amount');
            $table->decimal('shipping_fee', 8, 2)->default(0)->after('total_amount');

            // Shipping information
            $table->string('shipping_name')->after('shipping_fee');
            $table->string('shipping_email')->after('shipping_name');
            $table->string('shipping_phone')->after('shipping_email');
            $table->text('shipping_address')->after('shipping_phone');
            $table->string('shipping_province')->after('shipping_address');
            $table->string('shipping_district')->nullable()->after('shipping_province');
            $table->string('shipping_ward')->nullable()->after('shipping_district');

            // Payment information
            $table->integer('payment_method')->default(1)->after('shipping_ward');
            $table->timestamp('paid_at')->nullable()->after('payment_method');

            $table->text('notes')->nullable()->after('paid_at');

            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['order_number']);

            $table->dropColumn([
                'order_number',
                'total_amount',
                'shipping_fee',
                'shipping_name',
                'shipping_email',
                'shipping_phone',
                'shipping_address',
                'shipping_province',
                'shipping_district',
                'shipping_ward',
                'payment_method',
                'paid_at',
                'notes',
            ]);
        });
    }
};
