<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    public function run()
    {
        DB::table('education')->insert([
            ['title' => 'Sejarah Batik Indonesia', 'description' => 'Pelajari sejarah panjang batik sebagai warisan budaya', 'is_published' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Motif Batik Parang', 'description' => 'Makna filosofis dibalik motif batik Parang', 'is_published' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Motif Batik Mega Mendung', 'description' => 'Keindahan batik khas Cirebon', 'is_published' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cara Merawat Batik', 'description' => 'Tips merawat batik agar tetap awet', 'is_published' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}