<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'password' => Hash::make('superadmin123'),
                'role' => 'super_admin',
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@example.com',
                'password' => Hash::make('moderator123'),
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
