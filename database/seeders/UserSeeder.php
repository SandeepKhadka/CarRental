<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $user_data = [

            // Admin

            [
                'full_name' => 'Sandeep Admin',
                'username' => 'Admin',
                'email' => 'admin@goodgoods.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active'
            ],

            // Vendor

            [
                'full_name' => 'Sandeep Vendor',
                'username' => 'Vendor',
                'email' => 'vendor@goodgoods.com',
                'password' => Hash::make('vendor123'),
                'role' => 'vendor',
                'status' => 'active'
            ],


            // Customer

            [
                'full_name' => 'Sandeep Customer',
                'username' => 'Customer',
                'email' => 'customer@goodgoods.com',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'status' => 'active'
            ],

        ];

        DB::table('users')->insert($user_data);
    }
}
