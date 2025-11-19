<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'メンズ','レディース','家電','生活雑貨','コスメ',
            '本・メディア','ホビー','ベビー・キッズ','スポーツ','その他'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
