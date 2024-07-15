<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item =[
            [
                'name'=>'Big G',
                'email'=>'benzgoodlnw@gmail.com',
                'password'=>Hash::make('Benz0879924155'),
                'role_id'=>'1',


            ],
            [
                'name'=>'Primaris',
                'email'=>'benzgood@gmail.com',
                'password'=>Hash::make('Benz0879924155'),
                'role_id'=>'2',


            ],
            [
                'name'=>'Marine',
                'email'=>'benz@gmail.com',
                'password'=>Hash::make('Benz0879924155'),
                'role_id'=>'3',


            ]

        ];
        DB::table('users')->insert($item);
    }
}
