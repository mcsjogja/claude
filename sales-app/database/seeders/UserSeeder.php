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
        User::create([
            "name" => "Administrator",
            "email" => "admin@sales-app.com", 
            "password" => Hash::make("password"),
            "role" => "admin",
        ]);

        User::create([
            "name" => "Kasir 1",
            "email" => "kasir@sales-app.com",
            "password" => Hash::make("password"), 
            "role" => "kasir",
        ]);
    }
}
