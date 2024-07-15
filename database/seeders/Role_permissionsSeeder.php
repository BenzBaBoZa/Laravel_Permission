<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Role_permissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role_permissions')->insert([
            [
                
                'role' => 'Super Admin',
                'Product_Set' => '2',
                'Profile_Set' => '2',
                'System_Users_Set' => '2',
                'Permissions_Set' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                
                'role' => 'Admin',
                'Product_Set' => '2',
                'Profile_Set' => '2',
                'System_Users_Set' => '1',
                'Permissions_Set' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
            
                'role' => 'User',
                'Product_Set' => '1',
                'Profile_Set' => '2',
                'System_Users_Set' => '0',
                'Permissions_Set' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}