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
            $table->foreignId('voucher_id')->nullable()->after('shipping_fee')->constrained()->onDelete('set null');
            $table->string('voucher_code')->nullable()->after('voucher_id');
            $table->index('voucher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropIndex(['voucher_id']);
            $table->dropColumn(['voucher_id', 'voucher_code']);
        });
    }
};
