<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Helper function to parse date from MM/DD/YY or MM/DD/YYYY format
        $parseDate = function($dateString) {
            if (empty($dateString) || $dateString === 'غير مؤمن عليه') {
                return null;
            }
            
            try {
                // Handle MM/DD/YY format
                if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2})$/', $dateString, $matches)) {
                    $month = $matches[1];
                    $day = $matches[2];
                    $year = $matches[3];
                    // If year is 2 digits, assume 20XX if > 50, else 19XX
                    $fullYear = $year > 50 ? 1900 + $year : 2000 + $year;
                    return Carbon::createFromDate($fullYear, $month, $day)->format('Y-m-d');
                }
                // Handle MM/DD/YYYY format
                if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateString, $matches)) {
                    $month = $matches[1];
                    $day = $matches[2];
                    $year = $matches[3];
                    return Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                return null;
            }
            
            return null;
        };

        // Get departments and positions
        $departments = [
            'Desgine' => Department::where('name', 'Desgine')->first(),
            'Management' => Department::where('name', 'Management')->first(),
            'Operation' => Department::where('name', 'Operation')->first(),
            'Sales' => Department::where('name', 'Sales')->first(),
        ];

        // Employee data from the image
        $employees = [
            // Main Company
            [
                'name' => 'عمرو عبد الرحمن رمضان محمود',
                'national_id' => '27409150101571',
                'hire_date' => '11/1/19',
                'insurance_date' => '3/20/20',
                'employee_code' => 'LA-0001',
                'birth_date' => '9/15/74',
                'position_name' => 'CEO',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'اسامة سعد ابراهيم بدوى',
                'national_id' => '27412070104014',
                'hire_date' => '11/1/19',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0002',
                'birth_date' => '12/7/74',
                'position_name' => 'CEO',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'مصطفي اسامة سعد ابراهيم',
                'national_id' => '30506010103113',
                'hire_date' => '1/7/25',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0003',
                'birth_date' => '6/1/05',
                'position_name' => 'Developer',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'سيد عبد القوى عبد اللطيف السيد',
                'national_id' => '27012292100159',
                'hire_date' => '5/1/19',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0004',
                'birth_date' => '12/29/70',
                'position_name' => 'desgin manager',
                'department_name' => 'Desgine',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'شهد سيد عبد القوي',
                'national_id' => '30503220100703',
                'hire_date' => '7/1/25',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0005',
                'birth_date' => '3/22/05',
                'position_name' => 'designer',
                'department_name' => 'Desgine',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'محمد عادل كمال محمد',
                'national_id' => '29403041400893',
                'hire_date' => '5/1/19',
                'insurance_date' => '01/02/2023',
                'employee_code' => 'LA-0006',
                'birth_date' => '3/4/94',
                'position_name' => 'Technician Worker',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'محمد احمد محمد احمد فرج',
                'national_id' => '30106241402794',
                'hire_date' => '6/1/21',
                'insurance_date' => '10/1/22',
                'employee_code' => 'LA-0007',
                'birth_date' => '6/24/01',
                'position_name' => 'Sales Agent',
                'department_name' => 'Sales',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'كريم سيد عبد القوي',
                'national_id' => '29809260102152',
                'hire_date' => '1/1/24',
                'insurance_date' => '8/1/24',
                'employee_code' => 'LA-0008',
                'birth_date' => '9/26/98',
                'position_name' => 'Sales Agent',
                'department_name' => 'Sales',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'محمد احمد محمد عواد',
                'national_id' => '30101261400397',
                'hire_date' => '6/1/22',
                'insurance_date' => '2/1/23',
                'employee_code' => 'LA-0009',
                'birth_date' => '1/26/01',
                'position_name' => 'accountant',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'احمد محمد عبد الرازق',
                'national_id' => '29904301400832',
                'hire_date' => '8/1/25',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0010',
                'birth_date' => '4/30/99',
                'position_name' => 'accountant',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'مصطفى محمود کامل ابراهيم محمد',
                'national_id' => '29810011400559',
                'hire_date' => '1/1/22',
                'insurance_date' => '5/1/22',
                'employee_code' => 'LA-0011',
                'birth_date' => '10/1/98',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'حمدی محمد حمدى عبد القادر',
                'national_id' => '29912051401172',
                'hire_date' => '6/1/20',
                'insurance_date' => '1/1/21',
                'employee_code' => 'LA-0012',
                'birth_date' => '12/5/99',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'عمرو محمد عاشور فهمی',
                'national_id' => '30305061400397',
                'hire_date' => '1/1/19',
                'insurance_date' => '10/1/23',
                'employee_code' => 'LA-0013',
                'birth_date' => '5/6/03',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'عبد المحسن علي عبد العزيز محمد غريب',
                'national_id' => '30202211402012',
                'hire_date' => '1/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0014',
                'birth_date' => '2/21/02',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'محمود رضا عنتر موسي',
                'national_id' => '29805051702074',
                'hire_date' => '1/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0015',
                'birth_date' => '5/5/98',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'اسلام ناصر مصطفي علي بدران',
                'national_id' => '29501011403113',
                'hire_date' => '1/1/23',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0016',
                'birth_date' => '1/1/95',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'عصام سید سلیمان',
                'national_id' => '30802230105174',
                'hire_date' => '01/01/2023',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0017',
                'birth_date' => '2/23/08',
                'position_name' => 'assistant',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'محمد ياسر عيسي عبد الحميد',
                'national_id' => '30601011406414',
                'hire_date' => '01/01/2022',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0018',
                'birth_date' => '1/1/06',
                'position_name' => 'cutter',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'حسان طاهر حسان محمد',
                'national_id' => '29211031700418',
                'hire_date' => '7/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0019',
                'birth_date' => '11/3/92',
                'position_name' => 'cutter',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'کرم اشرف حسان محمد',
                'national_id' => '30007151701395',
                'hire_date' => '1/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0020',
                'birth_date' => '7/15/00',
                'position_name' => 'cutter',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'بلال',
                'national_id' => '',
                'hire_date' => '1/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0021',
                'birth_date' => '11/25/07',
                'position_name' => 'cutter',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'مؤمن ياسر عيسي عبد الحميد',
                'national_id' => '30305171401496',
                'hire_date' => '1/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0022',
                'birth_date' => '5/17/03',
                'position_name' => 'prodution manager',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'اسامة عبد الرحمن طه امام منصور',
                'national_id' => '30111251401471',
                'hire_date' => '9/15/21',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0023',
                'birth_date' => '11/25/01',
                'position_name' => 'Inventory Manager',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'محمود احمد محمد عواد',
                'national_id' => '30508281402534',
                'hire_date' => '9/1/23',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0024',
                'birth_date' => '8/28/05',
                'position_name' => 'prodution manager',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'يوسف احمد محمد عواد',
                'national_id' => '30904131400534',
                'hire_date' => '6/1/25',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0025',
                'birth_date' => '4/13/09',
                'position_name' => 'Finisher',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'احمد كوتشا',
                'national_id' => '',
                'hire_date' => '5/1/25',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0026',
                'birth_date' => '9/1/12',
                'position_name' => 'Finisher',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'يحي ناصر محمد سید',
                'national_id' => '30610141400794',
                'hire_date' => '10/1/24',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0027',
                'birth_date' => '1/14/06',
                'position_name' => 'Finisher',
                'department_name' => 'Operation',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'أسماء عزب محمد محمد',
                'national_id' => '29401021400401',
                'hire_date' => '1/1/20',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0028',
                'birth_date' => '1/2/94',
                'position_name' => 'office boy',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            [
                'name' => 'عصام جميل امين عبد الرحمن',
                'national_id' => '28105122500316',
                'hire_date' => '3/1/25',
                'insurance_date' => 'غير مؤمن عليه',
                'employee_code' => 'LA-0029',
                'birth_date' => '5/12/81',
                'position_name' => 'office boy',
                'department_name' => 'Management',
                'company_name' => 'Main Company',
            ],
            // 2nd Company
            [
                'name' => 'اسلام سعد ابراهيم ابراهيم',
                'national_id' => '28612060104051',
                'hire_date' => '1/1/20',
                'insurance_date' => '1/1/21',
                'employee_code' => 'LA-0030',
                'birth_date' => '12/6/86',
                'position_name' => 'prodution manager',
                'department_name' => null, // Empty in the image
                'company_name' => '2nd Company',
            ],
            [
                'name' => 'عمرو احمد يوسف',
                'national_id' => '29202210100858',
                'hire_date' => '1/1/20',
                'insurance_date' => '1/1/21',
                'employee_code' => 'LA-0031',
                'birth_date' => '2/21/92',
                'position_name' => 'Technician Worker',
                'department_name' => null,
                'company_name' => '2nd Company',
            ],
            [
                'name' => 'هاني عبد الرحمن محمود البابلي',
                'national_id' => '27604030103933',
                'hire_date' => '1/1/20',
                'insurance_date' => '5/1/22',
                'employee_code' => 'LA-0032',
                'birth_date' => '4/3/76',
                'position_name' => 'cutter',
                'department_name' => null,
                'company_name' => '2nd Company',
            ],
            [
                'name' => 'عبد الرحمن محمود عبد الخالق محمد',
                'national_id' => '29509171402157',
                'hire_date' => '1/1/20',
                'insurance_date' => '1/1/21',
                'employee_code' => 'LA-0033',
                'birth_date' => '9/17/95',
                'position_name' => 'Technician Worker',
                'department_name' => null,
                'company_name' => '2nd Company',
            ],
            [
                'name' => 'سید معتمد قناوی',
                'national_id' => '27201310104377',
                'hire_date' => '1/1/20',
                'insurance_date' => '9/1/22',
                'employee_code' => 'LA-0034',
                'birth_date' => '1/31/72',
                'position_name' => 'cutter',
                'department_name' => null,
                'company_name' => '2nd Company',
            ],
            [
                'name' => 'حمدي احمد عبد اللطيف علي',
                'national_id' => '27811042603155',
                'hire_date' => '1/1/20',
                'insurance_date' => '1/1/21',
                'employee_code' => 'LA-0035',
                'birth_date' => '11/4/78',
                'position_name' => 'Technician Worker',
                'department_name' => null,
                'company_name' => '2nd Company',
            ],
            [
                'name' => 'اسامه سعيد شحاته يوسف',
                'national_id' => '28312051401538',
                'hire_date' => '1/1/24',
                'insurance_date' => '9/1/24',
                'employee_code' => 'LA-0036',
                'birth_date' => '12/5/83',
                'position_name' => 'Sales Agent',
                'department_name' => null,
                'company_name' => '2nd Company',
            ],
        ];

        foreach ($employees as $empData) {
            // Find department
            $department = null;
            if ($empData['department_name']) {
                $department = Department::where('name', $empData['department_name'])->first();
            }

            // Find position
            $position = null;
            if ($department) {
                $position = Position::where('department_id', $department->id)
                    ->where('name', $empData['position_name'])
                    ->first();
            } else {
                // For 2nd Company employees, try to find position without department
                $position = Position::where('name', $empData['position_name'])->first();
                if ($position) {
                    $department = $position->department;
                }
            }

            // Determine account_type based on department
            $accountType = null;
            if ($department) {
                if ($department->name === 'Sales') {
                    $accountType = 'مبيعات';
                } elseif ($department->name === 'Desgine') {
                    $accountType = 'تصميم';
                } elseif ($department->name === 'Operation') {
                    $accountType = 'تشغيل';
                } elseif ($department->name === 'Management') {
                    if ($position && in_array($position->name, ['CEO', 'accountant'])) {
                        $accountType = 'حسابات';
                    } else {
                        $accountType = 'مدير';
                    }
                }
            }

            Employee::updateOrCreate(
                ['employee_code' => $empData['employee_code']],
                [
                    'name' => $empData['name'],
                    'national_id' => !empty($empData['national_id']) ? $empData['national_id'] : null,
                    'hire_date' => $parseDate($empData['hire_date']),
                    'insurance_date' => $parseDate($empData['insurance_date']),
                    'employee_code' => $empData['employee_code'],
                    'birth_date' => $parseDate($empData['birth_date']),
                    'department_id' => $department ? $department->id : null,
                    'position_id' => $position ? $position->id : null,
                    'company_name' => $empData['company_name'],
                    'account_type' => $accountType,
                    'status' => 'نشط',
                    'password' => Hash::make('password'), // Default password
                ]
            );
        }
    }
}
