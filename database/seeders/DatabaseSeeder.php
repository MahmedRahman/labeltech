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

        // Create default admin user
        // Email: admin@labeltech.com
        // Password: password
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
        ]);

        // Seed Departments and Positions
        $this->call(DepartmentPositionSeeder::class);
        
        // Seed Clients
        $this->call(ClientSeeder::class);
        
        // Seed Employees
        $this->call(EmployeeDataSeeder::class);
    }
}
