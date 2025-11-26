<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::firstOrCreate(
            ['phone' => '1234567890'],
            [
                'name' => 'John Doe',
            ]
        );
        
        Customer::firstOrCreate(
            ['phone' => '0987654321'],
            [
                'name' => 'Jane Smith',
            ]
        );
    }
}
