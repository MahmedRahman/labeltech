<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Departments
        $design = Department::firstOrCreate(
            ['name' => 'Desgine'],
            ['description' => 'قسم التصميم']
        );

        $management = Department::firstOrCreate(
            ['name' => 'Management'],
            ['description' => 'قسم الإدارة']
        );

        $operation = Department::firstOrCreate(
            ['name' => 'Operation'],
            ['description' => 'قسم التشغيل']
        );

        $sales = Department::firstOrCreate(
            ['name' => 'Sales'],
            ['description' => 'قسم المبيعات']
        );

        // Create Positions for Design Department
        Position::firstOrCreate(
            ['name' => 'desgin manager', 'department_id' => $design->id],
            ['description' => 'مدير التصميم']
        );

        Position::firstOrCreate(
            ['name' => 'designer', 'department_id' => $design->id],
            ['description' => 'مصمم']
        );

        // Create Positions for Management Department
        Position::firstOrCreate(
            ['name' => 'accountant', 'department_id' => $management->id],
            ['description' => 'محاسب']
        );

        Position::firstOrCreate(
            ['name' => 'CEO', 'department_id' => $management->id],
            ['description' => 'المدير التنفيذي']
        );

        Position::firstOrCreate(
            ['name' => 'Developer', 'department_id' => $management->id],
            ['description' => 'مطور']
        );

        Position::firstOrCreate(
            ['name' => 'office boy', 'department_id' => $management->id],
            ['description' => 'عامل مكتب']
        );

        Position::firstOrCreate(
            ['name' => 'prodution manager', 'department_id' => $management->id],
            ['description' => 'مدير الإنتاج']
        );

        // Create Positions for Operation Department
        Position::firstOrCreate(
            ['name' => 'assistant', 'department_id' => $operation->id],
            ['description' => 'مساعد']
        );

        Position::firstOrCreate(
            ['name' => 'cutter', 'department_id' => $operation->id],
            ['description' => 'قاطع']
        );

        Position::firstOrCreate(
            ['name' => 'Finisher', 'department_id' => $operation->id],
            ['description' => 'منهي']
        );

        Position::firstOrCreate(
            ['name' => 'Inventory Manager', 'department_id' => $operation->id],
            ['description' => 'مدير المخزون']
        );

        Position::firstOrCreate(
            ['name' => 'prodution manager', 'department_id' => $operation->id],
            ['description' => 'مدير الإنتاج']
        );

        Position::firstOrCreate(
            ['name' => 'Technician Worker', 'department_id' => $operation->id],
            ['description' => 'عامل فني']
        );

        // Create Positions for Sales Department
        Position::firstOrCreate(
            ['name' => 'Sales Agent', 'department_id' => $sales->id],
            ['description' => 'وكيل مبيعات']
        );
    }
}
