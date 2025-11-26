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
        // Service permissions
        Permission::firstOrCreate(['name' => 'ViewAny:Service']);
        Permission::firstOrCreate(['name' => 'View:Service']);
        Permission::firstOrCreate(['name' => 'Create:Service']);
        Permission::firstOrCreate(['name' => 'Update:Service']);
        Permission::firstOrCreate(['name' => 'Delete:Service']);
        Permission::firstOrCreate(['name' => 'Restore:Service']);
        Permission::firstOrCreate(['name' => 'ForceDelete:Service']);
        Permission::firstOrCreate(['name' => 'ForceDeleteAny:Service']);
        Permission::firstOrCreate(['name' => 'RestoreAny:Service']);
        Permission::firstOrCreate(['name' => 'Replicate:Service']);
        Permission::firstOrCreate(['name' => 'Reorder:Service']);
        
        // Booking permissions
        Permission::firstOrCreate(['name' => 'ViewAny:Booking']);
        Permission::firstOrCreate(['name' => 'View:Booking']);
        Permission::firstOrCreate(['name' => 'Create:Booking']);
        Permission::firstOrCreate(['name' => 'Update:Booking']);
        Permission::firstOrCreate(['name' => 'Delete:Booking']);
        Permission::firstOrCreate(['name' => 'Restore:Booking']);
        Permission::firstOrCreate(['name' => 'ForceDelete:Booking']);
        Permission::firstOrCreate(['name' => 'ForceDeleteAny:Booking']);
        Permission::firstOrCreate(['name' => 'RestoreAny:Booking']);
        Permission::firstOrCreate(['name' => 'Replicate:Booking']);
        Permission::firstOrCreate(['name' => 'Reorder:Booking']);
        Permission::firstOrCreate(['name' => 'check-in bookings']);
        
        // Customer permissions
        Permission::firstOrCreate(['name' => 'ViewAny:Customer']);
        Permission::firstOrCreate(['name' => 'View:Customer']);
        Permission::firstOrCreate(['name' => 'Create:Customer']);
        Permission::firstOrCreate(['name' => 'Update:Customer']);
        Permission::firstOrCreate(['name' => 'Delete:Customer']);
        Permission::firstOrCreate(['name' => 'Restore:Customer']);
        Permission::firstOrCreate(['name' => 'ForceDelete:Customer']);
        Permission::firstOrCreate(['name' => 'ForceDeleteAny:Customer']);
        Permission::firstOrCreate(['name' => 'RestoreAny:Customer']);
        Permission::firstOrCreate(['name' => 'Replicate:Customer']);
        Permission::firstOrCreate(['name' => 'Reorder:Customer']);
        
        // User permissions
        Permission::firstOrCreate(['name' => 'ViewAny:User']);
        Permission::firstOrCreate(['name' => 'View:User']);
        Permission::firstOrCreate(['name' => 'Create:User']);
        Permission::firstOrCreate(['name' => 'Update:User']);
        Permission::firstOrCreate(['name' => 'Delete:User']);
        Permission::firstOrCreate(['name' => 'Restore:User']);
        Permission::firstOrCreate(['name' => 'ForceDelete:User']);
        Permission::firstOrCreate(['name' => 'ForceDeleteAny:User']);
        Permission::firstOrCreate(['name' => 'RestoreAny:User']);
        Permission::firstOrCreate(['name' => 'Replicate:User']);
        Permission::firstOrCreate(['name' => 'Reorder:User']);
        
        // Role permissions
        Permission::firstOrCreate(['name' => 'ViewAny:Role']);
        Permission::firstOrCreate(['name' => 'View:Role']);
        Permission::firstOrCreate(['name' => 'Create:Role']);
        Permission::firstOrCreate(['name' => 'Update:Role']);
        Permission::firstOrCreate(['name' => 'Delete:Role']);
        Permission::firstOrCreate(['name' => 'Restore:Role']);
        Permission::firstOrCreate(['name' => 'ForceDelete:Role']);
        Permission::firstOrCreate(['name' => 'ForceDeleteAny:Role']);
        Permission::firstOrCreate(['name' => 'RestoreAny:Role']);
        Permission::firstOrCreate(['name' => 'Replicate:Role']);
        Permission::firstOrCreate(['name' => 'Reorder:Role']);

        // Create roles and assign permissions if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        // Create super_admin role and give all permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->givePermissionTo([
            'ViewAny:Service',
            'ViewAny:Booking',
            'Create:Booking',
            'Update:Booking',
            'check-in bookings',
        ]);
        
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->givePermissionTo([
            'ViewAny:Service',
            'Create:Booking',
        ]);
    }
}