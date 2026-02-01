<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountingTestAccountSeeder extends Seeder
{
    /**
     * إنشاء أو تحديث حساب الحسابات للتجربة.
     * للتشغيل: php artisan db:seed --class=AccountingTestAccountSeeder
     */
    public function run(): void
    {
        $department = Department::firstOrCreate(
            ['name' => 'Management'],
            ['description' => 'قسم الإدارة']
        );

        $position = Position::firstOrCreate(
            ['name' => 'accountant', 'department_id' => $department->id],
            ['description' => 'محاسب']
        );

        Employee::updateOrCreate(
            ['email' => 'accountant@labeltech.com'],
            [
                'name' => 'موظف الحسابات',
                'email' => 'accountant@labeltech.com',
                'password' => Hash::make('password'),
                'employee_code' => 'LA-TEST-004',
                'department_id' => $department->id,
                'position_id' => $position->id,
                'account_type' => 'حسابات',
                'status' => 'نشط',
                'company_name' => 'Main Company',
            ]
        );

        $this->command->info('تم إنشاء/تحديث حساب الحسابات للتجربة: accountant@labeltech.com / password');
    }
}

/*
php artisan db:seed --class=AccountingTestAccountSeeder
*/