<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
        {
            for ($i = 1; $i <= 40; $i++) {
                Like::firstOrCreate([
                    'user_id' => rand(1, 5),
                    'item_id' => rand(1, 20),
                ]);
            }
        }
}
