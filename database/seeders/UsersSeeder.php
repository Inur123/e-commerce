<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );

        // 2) Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // 3) Sellers (5)
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => "seller{$i}@gmail.com"],
                [
                    'name' => "Seller {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'seller',
                    'status' => 'active',
                ]
            );
        }

        // 4) Buyers (10)
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "buyer{$i}@gmail.com"],
                [
                    'name' => "Buyer {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'buyer',
                    'status' => 'active',
                ]
            );
        }
    }
}
