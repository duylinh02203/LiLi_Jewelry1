<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Sử dụng Faker để tạo dữ liệu giả
         $faker = \Faker\Factory::create();

         // Giả sử bạn đã có 10 categories trong bảng `categories`
         $categoryIds = range(1, 10);
 
         // Tạo 50 sản phẩm giả
         for ($i = 1; $i <= 50; $i++) {
             $name = $faker->words(3, true);
 
             DB::table('products')->insert([
                 'id' => $i,
                 'name' => $name,
                 'description' => $faker->sentence(),
                 'price' => $faker->numberBetween(10000, 100000), // Giá từ 10,000 đến 100,000
                 'listed_price' => $faker->numberBetween(100000, 200000), // Giá niêm yết từ 100,000 đến 200,000
                 'status' => $faker->randomElement(['active', 'inactive']),
                 'slug' => Str::slug($name, '-'),
                 'category_id' => $faker->randomElement($categoryIds),
                 'created_at' => now(),
                 'updated_at' => now(),
             ]);
         }
    }
}
