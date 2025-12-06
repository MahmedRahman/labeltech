<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seed Departments and Positions first
        $this->call(DepartmentPositionSeeder::class);
        
        // Seed Test Accounts (Admin, Sales, Designer, Production)
        $this->call(TestAccountsSeeder::class);
        
        // Seed Clients
        $this->call(ClientSeeder::class);
        
        // Seed Employees
        $this->call(EmployeeDataSeeder::class);
        
        // Seed Materials
        $this->call(MaterialSeeder::class);
        
        // Seed Additions
        $this->call(AdditionSeeder::class);
        
        // Seed Wastes (Printing)
        $this->call(WasteSeeder::class);
    }
}
