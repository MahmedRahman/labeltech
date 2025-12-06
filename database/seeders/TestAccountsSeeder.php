<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]
        );

        // Get Departments
        $salesDepartment = Department::where('name', 'Sales')->first();
        $designDepartment = Department::where('name', 'Desgine')->first();
        $operationDepartment = Department::where('name', 'Operation')->first();
        $managementDepartment = Department::where('name', 'Management')->first();

        // Get Positions
        $salesPosition = $salesDepartment ? Position::where('department_id', $salesDepartment->id)
            ->where('name', 'Sales Agent')
            ->first() : null;

        $designPosition = $designDepartment ? Position::where('department_id', $designDepartment->id)
            ->where('name', 'designer')
            ->first() : null;

        $operationPosition = $operationDepartment ? Position::where('department_id', $operationDepartment->id)
            ->where('name', 'Technician Worker')
            ->first() : null;

        $accountantPosition = $managementDepartment ? Position::where('department_id', $managementDepartment->id)
            ->where('name', 'accountant')
            ->first() : null;

        // Create Sales Employee
        Employee::updateOrCreate(
            ['email' => 'sales@labeltech.com'],
            [
                'name' => 'موظف المبيعات',
                'email' => 'sales@labeltech.com',
                'password' => Hash::make('password'),
                'employee_code' => 'LA-TEST-001',
                'department_id' => $salesDepartment ? $salesDepartment->id : null,
                'position_id' => $salesPosition ? $salesPosition->id : null,
                'account_type' => 'مبيعات',
                'status' => 'نشط',
                'company_name' => 'Main Company',
            ]
        );

        // Create Designer Employee
        Employee::updateOrCreate(
            ['email' => 'designer@labeltech.com'],
            [
                'name' => 'موظف التصميم',
                'email' => 'designer@labeltech.com',
                'password' => Hash::make('password'),
                'employee_code' => 'LA-TEST-002',
                'department_id' => $designDepartment ? $designDepartment->id : null,
                'position_id' => $designPosition ? $designPosition->id : null,
                'account_type' => 'تصميم',
                'status' => 'نشط',
                'company_name' => 'Main Company',
            ]
        );

        // Create Production Employee
        Employee::updateOrCreate(
            ['email' => 'production@labeltech.com'],
            [
                'name' => 'موظف التشغيل',
                'email' => 'production@labeltech.com',
                'password' => Hash::make('password'),
                'employee_code' => 'LA-TEST-003',
                'department_id' => $operationDepartment ? $operationDepartment->id : null,
                'position_id' => $operationPosition ? $operationPosition->id : null,
                'account_type' => 'تشغيل',
                'status' => 'نشط',
                'company_name' => 'Main Company',
            ]
        );

        // Create Accountant Employee
        Employee::updateOrCreate(
            ['email' => 'accountant@labeltech.com'],
            [
                'name' => 'موظف الحسابات',
                'email' => 'accountant@labeltech.com',
                'password' => Hash::make('password'),
                'employee_code' => 'LA-TEST-004',
                'department_id' => $managementDepartment ? $managementDepartment->id : null,
                'position_id' => $accountantPosition ? $accountantPosition->id : null,
                'account_type' => 'حسابات',
                'status' => 'نشط',
                'company_name' => 'Main Company',
            ]
        );
    }
}

