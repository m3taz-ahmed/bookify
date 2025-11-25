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
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $adminUser->assignRole($adminRole);

        // Create employee users
        $employee1 = User::create([
            'name' => 'Employee One',
            'email' => 'employee1@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $employee1->assignRole($employeeRole);

        $employee2 = User::create([
            'name' => 'Employee Two',
            'email' => 'employee2@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $employee2->assignRole($employeeRole);

        $employee3 = User::create([
            'name' => 'Employee Three',
            'email' => 'employee3@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
        $employee3->assignRole($employeeRole);
    }
}