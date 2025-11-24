<?php

namespace Database\Seeders;

use App\Models\EmployeeServiceDuration;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeServiceDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all employees
        $employees = User::whereHas('roles', function ($query) {
            $query->where('name', 'employee');
        })->get();
        
        // Get all services
        $services = Service::all();
        
        // Create sample employee service durations
        foreach ($employees as $employee) {
            foreach ($services as $service) {
                // Random duration between 15 and 60 minutes
                $duration = rand(15, 60);
                
                EmployeeServiceDuration::updateOrCreate(
                    [
                        'user_id' => $employee->id,
                        'service_id' => $service->id,
                    ],
                    [
                        'duration' => $duration,
                    ]
                );
            }
        }
    }
}
