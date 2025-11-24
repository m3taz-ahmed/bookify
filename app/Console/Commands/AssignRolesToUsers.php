<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRolesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-roles-to-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to existing users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get or create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        
        // Assign admin role to first user
        $adminUser = User::find(1);
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
            $this->info("Assigned admin role to {$adminUser->name}");
        }
        
        // Assign employee roles to other users
        $employeeUsers = User::where('id', '>', 1)->get();
        foreach ($employeeUsers as $user) {
            $user->assignRole($employeeRole);
            $this->info("Assigned employee role to {$user->name}");
        }
        
        $this->info('Roles assigned successfully!');
    }
}