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
        Customer::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'),
        ]);
        
        Customer::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'password' => Hash::make('password'),
        ]);
    }
}
