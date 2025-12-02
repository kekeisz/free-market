<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            Comment::firstOrCreate([
                'user_id' => rand(1, 5),
                'item_id' => rand(1, 10),
                'body' => 'これはテストコメント '.$i,
            ]);
        }
    }
}
