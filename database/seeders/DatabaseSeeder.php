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
            'name' => 'Afnan',
            'phone' => '01677756337',
            'password' => Hash::make('123456'),
            'type' => 'admin',
        ]);

        User::create([
            'name' => 'Afnan',
            'phone' => '01677756338',
            'password' => Hash::make('123456'),
            'type' => 'user',
            'po_id' => '1'
        ]);
    }
}
