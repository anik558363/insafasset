<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@landmark.com',
            'phone'             => '01700000001',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Rafi Khan',
            'email'             => 'agent@landmark.com',
            'phone'             => '01700000003',
            'password'          => Hash::make('password'),
            'role'              => 'agent',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Rahim Ahmed',
            'email'             => 'customer@example.com',
            'phone'             => '01700000002',
            'password'          => Hash::make('password'),
            'role'              => 'customer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'     => 'Fatema Begum',
            'email'    => 'fatema@example.com',
            'phone'    => '01811000099',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);
    }
}
