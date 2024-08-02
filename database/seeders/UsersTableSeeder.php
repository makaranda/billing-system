<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Users::create([
            'username' => 'adminmakara',
            'email' => 'adminmakara@gmail.com',
            'privilege' => 'admin',
            'password' => Hash::make('882553477v'),
            'status' => 2,
            'extensions' => 'admin',
        ]);

        Users::create([
            'username' => 'usermakara',
            'email' => 'usermakara@gmail.com',
            'privilege' => 'user',
            'password' => Hash::make('882553477v'),
            'status' => 1,
            'extensions' => 'user',
        ]);
    }
}
