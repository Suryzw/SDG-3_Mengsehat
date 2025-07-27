<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
         User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'role' => UserRole::Admin,
        ]);

        // 10 User biasa
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => "user{$i}@gmail.com",
                'password' => Hash::make('12345678'),
                'role' => UserRole::User,
            ]);
        }
        // User::factory(10)->create([
        //     'name' => 'user',
        //     'email' => 'user@gmail.com',
        //     'password' => Hash::make('12345678'),
        //     'role' => UserRole::User,
        //     'points' => 0,
        // ]);
    }
}