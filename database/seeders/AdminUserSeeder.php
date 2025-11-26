<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the admin and super_admin roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        
        // Create the admin user with the specified credentials
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@bookify.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        
        // Assign both admin and super_admin roles to the user
        $adminUser->assignRole($adminRole);
        $adminUser->assignRole($superAdminRole);
    }
}