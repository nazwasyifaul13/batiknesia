<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Kain Batik Tulis', 'slug' => 'kain-batik-tulis', 'sort_order' => 1],
            ['name' => 'Kain Batik Cap', 'slug' => 'kain-batik-cap', 'sort_order' => 2],
            ['name' => 'Batik Kombinasi', 'slug' => 'batik-kombinasi', 'sort_order' => 3],
            ['name' => 'Baju Batik Pria', 'slug' => 'baju-batik-pria', 'sort_order' => 4],
            ['name' => 'Baju Batik Wanita', 'slug' => 'baju-batik-wanita', 'sort_order' => 5],
            ['name' => 'Aksesoris Batik', 'slug' => 'aksesoris-batik', 'sort_order' => 6],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}