<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'), // Ganti dengan password yang aman
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Petugas
        User::create([
            'first_name' => 'Staff',
            'last_name' => 'User',
            'username' => 'staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('staff'), // Ganti dengan password yang aman
            'role' => 'petugas',
            'status' => 'active',
        ]);
    }
}
