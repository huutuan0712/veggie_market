<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vouchers')->insert([
            [
                'code' => 'WELCOME10',
                'name' => 'Chào mừng khách hàng mới',
                'description' => 'Giảm 10% cho đơn hàng đầu tiên từ 100.000đ',
                'type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 100000,
                'max_discount_amount' => 50000,
                'usage_limit' => 1000,
                'usage_limit_per_user' => 1,
                'used_count' => 245,
                'starts_at' => '2024-01-01',
                'expires_at' => '2024-12-31',
                'is_active' => true,
                'is_public' => true,
                'applicable_categories' => json_encode([]),
                'excluded_categories' => json_encode([]),
                'applicable_products' => json_encode([]),
                'excluded_products' => json_encode([]),
                'created_at' => Carbon::parse('2024-01-01T00:00:00Z'),
                'updated_at' => Carbon::parse('2024-01-15T10:30:00Z'),
            ],
            [
                'code' => 'SAVE50K',
                'name' => 'Tiết kiệm 50K',
                'description' => 'Giảm 50.000đ cho đơn hàng từ 200.000đ',
                'type' => 'fixed',
                'value' => 50000,
                'min_order_amount' => 200000,
                'max_discount_amount' => null,
                'usage_limit' => 500,
                'usage_limit_per_user' => 3,
                'used_count' => 123,
                'starts_at' => '2024-01-01',
                'expires_at' => '2024-06-30',
                'is_active' => true,
                'is_public' => true,
                'applicable_categories' => json_encode([]),
                'excluded_categories' => json_encode([]),
                'applicable_products' => json_encode([]),
                'excluded_products' => json_encode([]),
                'created_at' => Carbon::parse('2024-01-01T00:00:00Z'),
                'updated_at' => Carbon::parse('2024-01-10T14:20:00Z'),
            ],
            [
                'code' => 'FREESHIP',
                'name' => 'Miễn phí giao hàng',
                'description' => 'Miễn phí giao hàng cho đơn hàng từ 150.000đ',
                'type' => 'fixed',
                'value' => 30000,
                'min_order_amount' => 150000,
                'max_discount_amount' => null,
                'usage_limit' => 2000,
                'usage_limit_per_user' => 5,
                'used_count' => 567,
                'starts_at' => '2024-01-01',
                'expires_at' => '2024-12-31',
                'is_active' => true,
                'is_public' => true,
                'applicable_categories' => json_encode([]),
                'excluded_categories' => json_encode([]),
                'applicable_products' => json_encode([]),
                'excluded_products' => json_encode([]),
                'created_at' => Carbon::parse('2024-01-01T00:00:00Z'),
                'updated_at' => Carbon::parse('2024-01-12T09:15:00Z'),
            ],
            [
                'code' => 'VIP20',
                'name' => 'Khách hàng VIP',
                'description' => 'Giảm 20% cho đơn hàng từ 500.000đ (tối đa 100.000đ)',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 500000,
                'max_discount_amount' => 100000,
                'usage_limit' => 100,
                'usage_limit_per_user' => 2,
                'used_count' => 34,
                'starts_at' => '2024-01-01',
                'expires_at' => '2024-03-31',
                'is_active' => false,
                'is_public' => false,
                'applicable_categories' => json_encode([]),
                'excluded_categories' => json_encode([]),
                'applicable_products' => json_encode([]),
                'excluded_products' => json_encode([]),
                'created_at' => Carbon::parse('2024-01-01T00:00:00Z'),
                'updated_at' => Carbon::parse('2024-01-08T16:45:00Z'),
            ],
        ]);
    }
}
