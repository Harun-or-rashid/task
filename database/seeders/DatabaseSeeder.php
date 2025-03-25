<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create multiple admin users
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('00000000'),
            'role' => 'Admin',
            'employee_id' => null,
            'manage_organization' => true,
            'manage_team' => true,
            'manage_employee' => true,
            'manage_maneger' => true,
            'manage_report' => true,
        ]);

        Admin::create([
            'name' => 'Manager Admin',
            'email' => 'manager@admin.com',
            'password' => Hash::make('00000000'),
            'role' => 'Manager',
            'employee_id' => null,
            'manage_organization' => false,
            'manage_team' => true,
            'manage_employee' => true,
            'manage_maneger' => false,
            'manage_report' => false,
        ]);
    }
}
