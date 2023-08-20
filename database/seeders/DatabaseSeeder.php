<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Letter;
use App\Models\Type;
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
            'password' => Hash::make('admin'),
            'type' => 1,
        ]);
        // User::create([
        //     'username' => 'user',
        //     'password' => Hash::make('user'),
        //     'po_id' => 1,
        //     'type' => 2,
        // ]);
        // Type::create([
        //     'name' => 'Letter',
        //     'description' => '000',
        // ]);
        // Letter::create([
        //     'file' => '4141-345642-00001.png',
        //     'letter_id' => '4141-345642-00001',
        //     'sender_phone' => 0167,
        //     'receiver_phone' => 01354,
        //     'status' => 1
        // ]);
        // Letter::create([
        //     'file' => '4141-345642-00001.png',
        //     'letter_id' => '4142-345642-00001',
        //     'sender_phone' => 0167,
        //     'receiver_phone' => 01354,
        //     'status' => 1
        // ]);
    }
}
