<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        
        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $adminUser->assignRole($adminRole);

        // Create employee users
        $employee1 = User::firstOrCreate(
            ['email' => 'employee1@example.com'],
            [
                'name' => 'Employee One',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $employee1->assignRole($employeeRole);

        $employee2 = User::firstOrCreate(
            ['email' => 'employee2@example.com'],
            [
                'name' => 'Employee Two',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $employee2->assignRole($employeeRole);

        $employee3 = User::firstOrCreate(
            ['email' => 'employee3@example.com'],
            [
                'name' => 'Employee Three',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $employee3->assignRole($employeeRole);
    }
}