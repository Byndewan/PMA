<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'phone' => '08123456789',
            'address' => 'Jl. Contoh No. 1',
            'role' => 'admin',
            'balance' => 1000000,
        ]);

        // Operator
        User::create([
            'name' => 'Operator',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('operator'),
            'phone' => '08123456780',
            'address' => 'Jl. Contoh No. 1',
            'role' => 'operator',
            'balance' => 500000,
        ]);

        // Customer
        User::create([
            'name' => 'Customer 1',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer'),
            'phone' => '08123456781',
            'address' => 'Jl. Contoh No. 1',
            'role' => 'customer',
            'balance' => 0,
        ]);
    }
}
