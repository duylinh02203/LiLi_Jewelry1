<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sử dụng Faker để tạo dữ liệu giả
        $faker = \Faker\Factory::create();

        // Giả sử bạn đã có 50 sản phẩm trong bảng `products`
        $productIds = range(1, 50);

        // Tạo 100 hình ảnh giả liên kết với các sản phẩmN
        for ($i = 1; $i <= 100; $i++) {
            DB::table('product_images')->insert([
                'product_id' => $faker->randomElement($productIds),
                'image' => $faker->imageUrl(640, 480, 'products', true, 'Faker'), // URL hình ảnh giả
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
