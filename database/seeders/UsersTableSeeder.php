<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sử dụng Faker để tạo dữ liệu giả
        $faker = \Faker\Factory::create();

        // Tạo một admin mặc định
        DB::table('users')->insert([
            'user_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Mật khẩu mã hóa
            'role' => 1, // Admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo dữ liệu giả cho user
        for ($i = 2; $i <= 50; $i++) {
            DB::table('users')->insert([
                'user_id' => $i,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 2, // User
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
