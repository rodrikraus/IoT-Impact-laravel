<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserReactSeeder extends Seeder
{
    public function run()
    {
        DB::table('usersReact')->insert([
            [
                'email' => 'test',
                'password' => Hash::make('a'),
            ],
            [
                'email' => 'admin@iaw.com',
                'password' => Hash::make('admin123'),
            ],
        ]);
        
    }
}
