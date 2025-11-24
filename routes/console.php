<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register custom commands
Artisan::command('app:assign-roles-to-users', function () {
    // Get or create roles
    $adminRole = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
    $employeeRole = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'employee']);
    $customerRole = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'customer']);
    
    // Assign admin role to first user
    $adminUser = App\Models\User::find(1);
    if ($adminUser) {
        $adminUser->assignRole($adminRole);
        $this->info("Assigned admin role to {$adminUser->name}");
    }
    
    // Assign employee roles to other users
    $employeeUsers = App\Models\User::where('id', '>', 1)->get();
    foreach ($employeeUsers as $user) {
        $user->assignRole($employeeRole);
        $this->info("Assigned employee role to {$user->name}");
    }
    
    $this->info('Roles assigned successfully!');
})->purpose('Assign roles to existing users');