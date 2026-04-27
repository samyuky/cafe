<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'full_name' => 'Admin Cafe',
            'name' => 'Admin Cafe',
            'email' => 'admin@cafe.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
        
        User::create([
            'full_name' => 'Manager Cafe',
            'name' => 'Manager Cafe',
            'email' => 'manager@cafe.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);
        
        User::create([
            'full_name' => 'Kasir Satu',
            'name' => 'Kasir Satu',
            'email' => 'kasir@cafe.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);
    }
}
