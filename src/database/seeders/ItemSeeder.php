<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // 出品者候補を取得（UserSeederが先に動く前提）
        $userIds = User::pluck('id'); // [1,2,3,4,5]

        // ダミー商品データ（URL付き）
        $items = [
            [
                'name'         => '腕時計',
                'price'        => 15000,
                'description'  => 'スタイリッシュなデザインのメンズ腕時計',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'condition_id' => 1, // 良好
            ],
            [
                'name'         => 'HDD',
                'price'        => 5000,
                'description'  => '高速で信頼性の高いハードディスク',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
            ],
            [
                'name'         => '玉ねぎ3束',
                'price'        => 300,
                'description'  => '新鮮な玉ねぎ3束のセット',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'condition_id' => 3, // やや傷や汚れあり
            ],
            [
                'name'         => '革靴',
                'price'        => 4000,
                'description'  => 'クラシックなデザインの革靴',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'condition_id' => 4, // 状態が悪い
            ],
            [
                'name'         => 'ノートPC',
                'price'        => 45000,
                'description'  => '高性能なノートパソコン',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'condition_id' => 1,
            ],
            [
                'name'         => 'マイク',
                'price'        => 8000,
                'description'  => '高音質のレコーディング用マイク',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'condition_id' => 2,
            ],
            [
                'name'         => 'ショルダーバッグ',
                'price'        => 3500,
                'description'  => 'おしゃれなショルダーバッグ',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'condition_id' => 3,
            ],
            [
                'name'         => 'タンブラー',
                'price'        => 500,
                'description'  => '使いやすいタンブラー',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'condition_id' => 4,
            ],
            [
                'name'         => 'コーヒーミル',
                'price'        => 4000,
                'description'  => '手動のコーヒーミル',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'condition_id' => 1,
            ],
            [
                'name'         => 'メイクセット',
                'price'        => 2500,
                'description'  => '便利なメイクアップセット',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'condition_id' => 2,
            ],
        ];

        foreach ($items as $index => $data) {
            // ★ 1. URL から画像を取得して storage/app/public/items に保存
            $imageContents = @file_get_contents($data['url']);

            // 通信エラーなどで取れなかった場合はスキップ（or プレースホルダ画像を使う）
            if ($imageContents === false) {
                continue;
            }

            // 保存先パス（例：items/dummy_1.jpg）
            $filename = 'dummy_' . ($index + 1) . '.jpg';
            $path = 'items/' . $filename;

            // publicディスク（storage/app/public）に保存
            Storage::disk('public')->put($path, $imageContents);

            // ★ 2. items テーブルにレコード作成（image は相対パス）
            Item::create([
                'user_id'      => $userIds->random(),
                'name'         => $data['name'],
                'price'        => $data['price'],
                'description'  => $data['description'],
                'image'        => $path, // ← "items/xxx.jpg"
                'condition_id' => $data['condition_id'],
                'is_sold'      => 0,
            ]);
        }
    }
}
