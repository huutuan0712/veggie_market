<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['kg', 'gói', 'hộp', 'trái'];
        $fruits = ['Táo', 'Chuối', 'Cam', 'Nho', 'Dưa hấu', 'Xoài', 'Lê', 'Dứa', 'Ổi', 'Chôm chôm'];
        $stock = fake()->numberBetween(0, 100);

        foreach ($fruits as $fruit) {
            $category = Category::inRandomOrder()->first();

            Product::create([
                'name' => $fruit,
                'slug' => Str::slug($fruit . '-' . fake()->unique()->numberBetween(1, 999)),
                'category_id' => $category->id,
                'description' => fake()->paragraph(),
                'price' => fake()->randomFloat(2, 10, 100), // từ 10 đến 100 nghìn
                'stock' => $stock,
                'status' => $stock === 0 ? 'out_stock' : 'in_stock',
                'unit' => fake()->randomElement($units),
            ]);
        }
    }
}
