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
        User::create([
            'name' => 'Admin Print',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'balance' => 0,
        ]);

        User::create([
            'name' => 'Operator Print',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('operator'),
            'role' => 'operator',
            'balance' => 500000,
        ]);
    }
}
