<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {

        $users = [
            [
                'name' => 'Seller Holland Bakery',
                'email' => 'seller@lastbite.com',
                'password' => Hash::make('password123'),
                'role' => 'seller',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Customer Test',
                'email' => 'customer@lastbite.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            $existingUser = User::where('email', $userData['email'])->first();

            if (!$existingUser) {
                User::create($userData);
            }
        }

        $this->command->info('✅ Users checked/created successfully!');
    }
}
