<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
            'username' => 'samuel@hotmail.com',
            'password' => bcrypt('teste123'),
            'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'nicolas@hotmail.com',
                'password' => bcrypt('teste1234'),
                'created_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'username' => 'unifil@hotmail.com',
                    'password' => bcrypt('teste12345'),
                    'created_at' => date('Y-m-d H:i:s'),
                    ],
            ]);
    }
}
