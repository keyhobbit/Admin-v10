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
                'password' => bcrypt('superadmin123'),
                'role' => 'super_admin',
                'is_active' => true,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Moderator',
                'email' => 'moderator@example.com',
                'password' => bcrypt('moderator123'),
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
