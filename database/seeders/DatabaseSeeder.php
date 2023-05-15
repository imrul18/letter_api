<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
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
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'type' => 'admin',
        ]);
        User::create([
            'username' => 'user',
            'password' => Hash::make('123456'),
            'type' => 'user',
        ]);
        User::create([
            'username' => 'delivery',
            'password' => Hash::make('123456'),
            'type' => 'delivery',
        ]);
    }
}
