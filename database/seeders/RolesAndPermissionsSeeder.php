<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if they don't exist
        Permission::firstOrCreate(['name' => 'view services']);
        Permission::firstOrCreate(['name' => 'create services']);
        Permission::firstOrCreate(['name' => 'edit services']);
        Permission::firstOrCreate(['name' => 'delete services']);
        
        Permission::firstOrCreate(['name' => 'view bookings']);
        Permission::firstOrCreate(['name' => 'create bookings']);
        Permission::firstOrCreate(['name' => 'edit bookings']);
        Permission::firstOrCreate(['name' => 'delete bookings']);
        Permission::firstOrCreate(['name' => 'check-in bookings']);
        
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        
        Permission::firstOrCreate(['name' => 'view shifts']);
        Permission::firstOrCreate(['name' => 'create shifts']);
        Permission::firstOrCreate(['name' => 'edit shifts']);
        Permission::firstOrCreate(['name' => 'delete shifts']);

        // Create roles and assign permissions if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'view services',
            'view bookings',
            'create bookings',
            'edit bookings',
            'check-in bookings',
            'view shifts',
        ]);
        
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'view services',
            'create bookings',
        ]);
    }
}