<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'adi',
                'email' => 'adi149@gmail.com',
                'password' => Hash::make('adiadi149'),
                'role' => 'support',
            ],
            [
                'name' => 'faris',
                'email' => 'faris123@gmail.com',
                'password' => Hash::make('faris123'),
                'role' => 'support',
            ],
            [
                'name' => 'khabil',
                'email' => 'khabil123@gmail.com',
                'password' => Hash::make('khabil123'),
                'role' => 'user',
            ],
            [
                'name' => 'adil',
                'email' => 'adil123@gmail.com',
                'password' => Hash::make('adil123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->call(TicketSeeder::class);
    }
}
