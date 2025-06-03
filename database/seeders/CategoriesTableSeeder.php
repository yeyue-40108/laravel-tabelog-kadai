<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            '和食', '中華', '洋食', 'イタリアン', 'ジャンクフード', '鍋料理', 'カレー', 'ステーキ', '寿司',
            '丼ぶり', 'ラーメン', '居酒屋', 'バー', 'カフェ' 
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
