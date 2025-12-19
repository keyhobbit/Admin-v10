<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => 'superadmin123', // Will be auto-hashed by model cast
                'role' => 'super_admin',
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'admin123', // Will be auto-hashed by model cast
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@example.com',
                'password' => 'moderator123', // Will be auto-hashed by model cast
                'role' => 'moderator',
                'is_active' => true,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }

        $this->command->info('Created ' . count($admins) . ' admin accounts');
    }
}
