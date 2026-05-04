<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Insert Admin User
        DB::table('users')->insert([
            'name' => 'Administrator Batiknesia',
            'email' => 'admin@batiknesia.com',
            'password' => Hash::make('AdminBatiknesia2024!'),
            'phone' => '081234567890',
            'address' => 'Jl. Malioboro No. 123, Yogyakarta',
            'avatar' => null,
            'role' => 'admin',
            'is_active' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Insert Regular User
        DB::table('users')->insert([
            'name' => 'Budi Santoso',
            'email' => 'user@batiknesia.com',
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

        // 3. Insert Categories
        $categories = [
            ['name' => 'Kain Batik Tulis', 'slug' => 'kain-batik-tulis', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kain Batik Cap', 'slug' => 'kain-batik-cap', 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baju Batik Pria', 'slug' => 'baju-batik-pria', 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Baju Batik Wanita', 'slug' => 'baju-batik-wanita', 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Aksesoris Batik', 'slug' => 'aksesoris-batik', 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('categories')->insert($categories);

        // 4. Insert Batik Motifs
        $motifs = [
            [
                'name' => 'Batik Parang',
                'slug' => 'batik-parang',
                'origin' => 'Yogyakarta',
                'philosophy' => 'Melambangkan kesinambungan dan kekuatan',
                'description' => 'Motif parang adalah motif batik tertua di Indonesia',
                'image' => 'images/batik/parang.jpg',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Batik Kawung',
                'slug' => 'batik-kawung',
                'origin' => 'Yogyakarta',
                'philosophy' => 'Melambangkan kesucian dan harapan',
                'description' => 'Motif kawung berbentuk irisan buah kolang-kaling',
                'image' => 'images/batik/kawung.jpg',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Batik Mega Mendung',
                'slug' => 'batik-mega-mendung',
                'origin' => 'Cirebon',
                'philosophy' => 'Melambangkan kesabaran dan ketenangan',
                'description' => 'Motif mega mendung khas Cirebon dengan gradasi warna',
                'image' => 'images/batik/mega-mendung.jpg',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('batik_motifs')->insert($motifs);

        // 5. Insert Sample Products
        $products = [
            [
                'name' => 'Kain Batik Parang Slondok',
                'slug' => 'kain-batik-parang-slondok',
                'description' => 'Kain batik parang dengan motif klasik',
                'price' => 250000,
                'stock' => 50,
                'image' => 'images/products/parang-slondok.jpg',
                'motif_id' => 1,
                'category_id' => 1,
                'is_active' => 1,
                'weight' => 500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Baju Batik Pria Lengan Panjang',
                'slug' => 'baju-batik-pria-lengan-panjang',
                'description' => 'Baju batik pria dengan motif kawung',
                'price' => 350000,
                'stock' => 30,
                'image' => 'images/products/baju-pria.jpg',
                'motif_id' => 2,
                'category_id' => 3,
                'is_active' => 1,
                'weight' => 400,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('products')->insert($products);

        // 6. Insert Education Articles
        $educations = [
            [
                'title' => 'Sejarah Batik Indonesia',
                'slug' => 'sejarah-batik-indonesia',
                'content' => '<p>Batik Indonesia telah diakui UNESCO sebagai Warisan Kemanusiaan untuk Budaya Lisan dan Nonbendawi sejak 2 Oktober 2009.</p>',
                'excerpt' => 'Sejarah panjang batik Indonesia',
                'image' => 'images/education/sejarah-batik.jpg',
                'category' => 'article',
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cara Merawat Batik',
                'slug' => 'cara-merawat-batik',
                'content' => '<p>Cuci batik dengan cara yang benar agar warnanya tetap awet.</p>',
                'excerpt' => 'Tips merawat batik',
                'image' => 'images/education/merawat-batik.jpg',
                'category' => 'article',
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('educations')->insert($educations);

        // 7. Insert Settings
        $settings = [
            ['key' => 'company_name', 'value' => 'Batiknesia', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'company_phone', 'value' => '+62 123 4567 890', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'company_address', 'value' => 'Jl. Batik No. 123, Yogyakarta', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'bca_account', 'value' => '1234567890 a.n PT Batiknesia', 'type' => 'text', 'group' => 'payment', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'mandiri_account', 'value' => '0987654321 a.n PT Batiknesia', 'type' => 'text', 'group' => 'payment', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('settings')->insert($settings);
    }
}