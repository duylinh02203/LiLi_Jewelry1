<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Tạo 20 categories giả
        for ($i = 1; $i <= 20; $i++) {
            DB::table('categories')->insert([
                'id' => $i,
                'name' => $faker->words(2, true), // Tên ngẫu nhiên với 2 từ
                'description' => $faker->sentence(), // Mô tả ngẫu nhiên
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
