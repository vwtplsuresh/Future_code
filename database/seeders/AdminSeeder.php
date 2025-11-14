<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Admin",
            "email" => "admin@email.com",
            "email_verified_at" => now(),
            "password" => Hash::make("Admin@123")
        ])->assignRole('admin');

        User::create([
            "name" => "Operator",
            "email" => "operator@email.com",
            "email_verified_at" => now(),
            "password" => Hash::make("Operator@123")
        ])->assignRole('operator');

        User::create([
            "name" => "Inspector",
            "email" => "inspector@email.com",
            "email_verified_at" => now(),
            "password" => Hash::make("Inspector@123")
        ])->assignRole('inspector');

        User::create([
            "name" => "User",
            "email" => "user@email.com",
            "email_verified_at" => now(),
            "password" => Hash::make("User@123")
        ])->assignRole('user');

        
    }
}

