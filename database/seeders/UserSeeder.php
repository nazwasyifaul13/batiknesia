<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        DB::table('users')->insert([
            'name' => 'Administrator Batiknesia',
            'email' => 'admin@batiknesia.com',
            'password' => Hash::make('AdminBatiknesia2024!'),
            'phone' => '081234567890',
            'address' => 'Jl. Malioboro No. 123, Yogyakarta',
            'avatar' => 'images/avatars/admin-avatar.jpg',
            'role' => 'admin',
            'is_active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sample regular user 1
        DB::table('users')->insert([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567891',
            'address' => 'Jl. Sudirman No. 45, Jakarta',
            'avatar' => null,
            'role' => 'user',
            'is_active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sample regular user 2
        DB::table('users')->insert([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567892',
            'address' => 'Jl. Diponegoro No. 78, Surabaya',
            'avatar' => null,
            'role' => 'user',
            'is_active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sample regular user 3 - untuk testing
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@batiknesia.com',
            'password' => Hash::make('test123456'),
            'phone' => '081234567893',
            'address' => 'Jl. Merdeka No. 1, Bandung',
            'avatar' => null,
            'role' => 'user',
            'is_active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}