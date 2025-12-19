<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');

        if ($userIds->isEmpty()) {
            return;
        }

        $items = [
            [
                'name'         => '腕時計',
                'brand'        => 'ARMANI',
                'price'        => 15000,
                'description'  => 'スタイリッシュなデザインのメンズ腕時計',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'condition_id' => 1,
                'categories'   => ['メンズ', 'ファッション' ,'アクセサリー'],
            ],
            [
                'name'         => 'HDD',
                'brand'        => 'Western Digital',
                'price'        => 5000,
                'description'  => '高速で信頼性の高いハードディスク',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'condition_id' => 2,
                'categories'   => ['家電'],
            ],
            [
                'name'         => '玉ねぎ3束',
                'brand'        => '北海道産',
                'price'        => 300,
                'description'  => '新鮮な玉ねぎ3束のセット',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'condition_id' => 3,
                'categories'   => ['キッチン'],
            ],
            [
                'name'         => '革靴',
                'brand'        => 'REGAL',
                'price'        => 4000,
                'description'  => 'クラシックなデザインの革靴',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'condition_id' => 4,
                'categories'   => ['メンズ','ファッション'],
            ],
            [
                'name'         => 'ノートPC',
                'brand'        => 'Dell',
                'price'        => 45000,
                'description'  => '高性能なノートパソコン',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'condition_id' => 1,
                'categories'   => ['家電'],
            ],
            [
                'name'         => 'マイク',
                'brand'        => 'Audio-Technica',
                'price'        => 8000,
                'description'  => '高音質のレコーディング用マイク',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'condition_id' => 2,
                'categories'   => ['家電'],
            ],
            [
                'name'         => 'ショルダーバッグ',
                'brand'        => 'COACH',
                'price'        => 3500,
                'description'  => 'おしゃれなショルダーバッグ',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'condition_id' => 3,
                'categories'   => ['レディース','ファッション'],
            ],
            [
                'name'         => 'タンブラー',
                'brand'        => 'STARBUCKS',
                'price'        => 500,
                'description'  => '使いやすいタンブラー',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'condition_id' => 4,
                'categories'   => ['キッチン'],
            ],
            [
                'name'         => 'コーヒーミル',
                'brand'        => 'HARIO',
                'price'        => 4000,
                'description'  => '手動のコーヒーミル',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'condition_id' => 1,
                'categories'   => ['キッチン'],
            ],
            [
                'name'         => 'メイクセット',
                'brand'        => 'CANMAKE',
                'price'        => 2500,
                'description'  => '便利なメイクアップセット',
                'url'          => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'condition_id' => 2,
                'categories'   => ['コスメ'],
            ],
        ];

        foreach ($items as $index => $data) {
            $imageContents = @file_get_contents($data['url']);

            if ($imageContents === false) {
                continue;
            }

            $extension = pathinfo(parse_url($data['url'], PHP_URL_PATH) ?? '', PATHINFO_EXTENSION);
            $extension = $extension !== '' ? $extension : 'jpg';

            $filename = 'dummy_' . ($index + 1) . '.' . $extension;
            $path = 'items/' . $filename;

            Storage::disk('public')->put($path, $imageContents);

            $item = Item::create([
                'user_id'      => $userIds->random(),
                'buyer_id'     => null,
                'name'         => $data['name'],
                'brand'        => $data['brand'],
                'description'  => $data['description'],
                'price'        => $data['price'],
                'image'        => $path,
                'condition_id' => $data['condition_id'],
                'is_sold'      => false,
            ]);

            $categoryIds = Category::whereIn('name', $data['categories'])->pluck('id')->all();
            $item->categories()->sync($categoryIds);
        }
    }
}
