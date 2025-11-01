<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Suilma Mata',
                'email' => 'suilma@gmail.com',
                'password' => Hash::make('12345678'),
                'id_rol' => 1
            ],
            [
                'name' => 'Jose Hernandez',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'id_rol' => 1
            ]
        ]);

        DB::table('asks_security')->insert([
            [
                'id_user' => 1,
                'ask' => '¿Como te llamas?',
                'answer' => encrypt('suilma')
            ],
            [
                'id_user' => 2,
                'ask' => '¿Como te llamas?',
                'answer' => encrypt('jose'),
            ],
            [
                'id_user' => 2,
                'ask' => '¿edad en el 2023?',
                'answer' => encrypt(22),
            ],
            [
                'id_user' => 2,
                'ask' => '¿perrito?',
                'answer' => encrypt('cafe'),
            ]
        ]);

        DB::table('roles')->insert([
            [ 'role' => 'Admin'],
            [ 'role' => 'User' ]
        ]);
    }
}
