<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ['user_id' => 1, 'name' => '革ジャン', 'price' => 15000],
            ['user_id' => 2, 'name' => 'Bluetooth イヤホン', 'price' => 7000],
            ['user_id' => 3, 'name' => 'メンズスニーカー', 'price' => 12000],
            ['user_id' => 4, 'name' => '炊飯器 5.5合', 'price' => 11000],
            ['user_id' => 5, 'name' => 'コーヒーメーカー', 'price' => 9000],
            ['user_id' => 1, 'name' => 'フェイスパック', 'price' => 3500],
            ['user_id' => 2, 'name' => 'ダウンジャケット', 'price' => 6000],
            ['user_id' => 3, 'name' => 'ロードバイク用ヘルメット', 'price' => 12000],
            ['user_id' => 4, 'name' => 'ゲームコントローラー', 'price' => 6500],
            ['user_id' => 5, 'name' => 'ノートPCスタンド', 'price' => 4500],

            ['user_id' => 1, 'name' => 'レディースワンピース', 'price' => 5500],
            ['user_id' => 2, 'name' => 'iPhoneケース', 'price' => 2500],
            ['user_id' => 3, 'name' => '知育本セット', 'price' => 4000],
            ['user_id' => 4, 'name' => 'Switch ゲームソフト', 'price' => 5800],
            ['user_id' => 5, 'name' => 'スウェット上下セット', 'price' => 8000],
            ['user_id' => 1, 'name' => 'カメラ三脚', 'price' => 3000],
            ['user_id' => 2, 'name' => '掃除機', 'price' => 18000],
            ['user_id' => 3, 'name' => '折りたたみ椅子', 'price' => 3500],
            ['user_id' => 4, 'name' => 'ヘッドフォン', 'price' => 20000],
            ['user_id' => 5, 'name' => 'LED卓上ランプ', 'price' => 4000],
        ];

        foreach ($products as $product) {
            Product::create([
                'user_id' => $product['user_id'],
                'name'    => $product['name'],
                'price'   => $product['price'],
            ]);
        }
    }
}