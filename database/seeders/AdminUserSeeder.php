<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Owner
        User::create([
            'name' => 'Owner Warung TM',
            'username' => 'owner',
            'email' => 'owner@warung-tm.com',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // Create Kasir
        User::create([
            'name' => 'Kasir Warung TM',
            'username' => 'kasir',
            'email' => 'kasir@warung-tm.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
            'email_verified_at' => now(),
        ]);
    }
}
