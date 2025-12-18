<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Test Player 1', 'email' => 'player1@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Test Player 2', 'email' => 'player2@example.com', 'password' => Hash::make('password123')],
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('admin123')],
            ['name' => 'Demo User', 'email' => 'demo@example.com', 'password' => Hash::make('demo123')],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        $this->command->info('Created ' . count($users) . ' test users.');
    }
}
