<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Alice',   'email' => 'alice@test.com'],
            ['name' => 'Bob',     'email' => 'bob@test.com'],
            ['name' => 'Carol',   'email' => 'carol@test.com'],
            ['name' => 'Dave',    'email' => 'dave@test.com'],
            ['name' => 'Ellen',   'email' => 'ellen@test.com'],
            ['name' => 'Keke',    'email' => 'kekeisozaki13@gmail.com']
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'postcode' => '150-0001',
                'address' => '東京都渋谷区神宮前1-1-1',
            ]);
        }
    }
}
