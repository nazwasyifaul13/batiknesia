<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah admin sudah ada, jika belum maka insert
        $adminExists = DB::table('users')->where('email', 'admin@batiknesia.com')->exists();
        
        if (!$adminExists) {
            DB::table('users')->insert([
                'name' => 'Administrator',
                'email' => 'admin@batiknesia.com',
                'password' => Hash::make('AdminBatiknesia2024!'),
                'phone' => '081234567890',
                'role' => 'admin',
                'is_active' => 1,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Cek apakah categories sudah ada
        $categoriesExist = DB::table('categories')->count();
        if ($categoriesExist == 0) {
            DB::table('categories')->insert([
                ['name' => 'Kain Batik', 'slug' => 'kain-batik', 'sort_order' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Baju Batik', 'slug' => 'baju-batik', 'sort_order' => 2, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Aksesoris Batik', 'slug' => 'aksesoris-batik', 'sort_order' => 3, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        // Cek apakah batik_patterns sudah ada
        $patternsExist = DB::table('batik_patterns')->count();
        if ($patternsExist == 0) {
            DB::table('batik_patterns')->insert([
                ['name' => 'Batik Parang', 'slug' => 'batik-parang', 'origin' => 'Yogyakarta', 'philosophy' => 'Melambangkan kesinambungan', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Batik Kawung', 'slug' => 'batik-kawung', 'origin' => 'Yogyakarta', 'philosophy' => 'Melambangkan kesucian', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Batik Mega Mendung', 'slug' => 'batik-mega-mendung', 'origin' => 'Cirebon', 'philosophy' => 'Melambangkan kesabaran', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
        
        // Cek apakah products sudah ada
        $productsExist = DB::table('products')->count();
        if ($productsExist == 0) {
            DB::table('products')->insert([
                [
                    'name' => 'Kain Batik Parang Slondok',
                    'slug' => 'kain-batik-parang-slondok',
                    'description' => 'Kain batik kualitas premium',
                    'price' => 250000,
                    'stock' => 50,
                    'image' => null,
                    'category_id' => 1,
                    'motif_id' => 1,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Baju Batik Pria',
                    'slug' => 'baju-batik-pria',
                    'description' => 'Baju batik pria lengan panjang',
                    'price' => 350000,
                    'stock' => 30,
                    'image' => null,
                    'category_id' => 2,
                    'motif_id' => 2,
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
        
        $this->command->info('Data seeded successfully!');
    }
}