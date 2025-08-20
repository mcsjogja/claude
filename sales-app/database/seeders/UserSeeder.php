<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user sesuai spesifikasi
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Additional users for testing
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        User::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
        ]);
    }
}
