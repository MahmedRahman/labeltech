<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        // Filter by name
        if ($request->filled('search_name')) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // Filter by employee code
        if ($request->filled('search_code')) {
            $query->where('employee_code', 'like', '%' . $request->search_code . '%');
        }

        // Filter by department
        if ($request->filled('filter_department')) {
            $query->where('department_id', $request->filter_department);
        }

        $employees = $query->with('department', 'position')->latest()->paginate(10)->withQueryString();

        // Get departments for filter
        $departments = Department::orderBy('name')->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $positions = Position::with('department')->orderBy('name')->get();
        return view('employees.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'national_id' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'account_type' => 'nullable|string|in:مبيعات,تصميم,تشغيل,حسابات,مدير',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
            'insurance_date' => 'nullable|date',
            'insurance_number' => 'nullable|string|max:255',
            'employee_code' => 'nullable|string|max:255|unique:employees,employee_code',
            'birth_date' => 'nullable|date',
            'company_name' => 'nullable|string|max:255',
            'resignation_date' => 'nullable|date',
            'status' => 'nullable|string|in:نشط,استقال,معطل',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Generate employee code if empty
        if (empty($validated['employee_code'])) {
            $validated['employee_code'] = $this->generateEmployeeCode();
        }

        Employee::create($validated);

        return redirect()->route('employees.index')
            ->with('success', 'تم إضافة الموظف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load('department', 'position');
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();
        $positions = Position::with('department')->orderBy('name')->get();
        return view('employees.edit', compact('employee', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'national_id' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|integer|min:0',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'account_type' => 'nullable|string|in:مبيعات,تصميم,تشغيل,حسابات,مدير',
            'salary' => 'nullable|numeric|min:0',
            'hire_date' => 'nullable|date',
            'insurance_date' => 'nullable|date',
            'insurance_number' => 'nullable|string|max:255',
            'employee_code' => 'nullable|string|max:255|unique:employees,employee_code,' . $employee->id,
            'birth_date' => 'nullable|date',
            'company_name' => 'nullable|string|max:255',
            'resignation_date' => 'nullable|date',
            'status' => 'nullable|string|in:نشط,استقال,معطل',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Hash password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'تم حذف الموظف بنجاح');
    }

    /**
     * Export employees to CSV
     */
    public function export()
    {
        $employees = Employee::with('department', 'position')->orderBy('name')->get();

        $filename = 'employees_export_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($employees) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            fputcsv($file, [
                'الاسم',
                'البريد الإلكتروني',
                'الهاتف',
                'الرقم القومي',
                'كود الموظف',
                'تاريخ الميلاد',
                'عدد سنوات الخبرة',
                'المنصب',
                'القسم',
                'نوع الحساب',
                'الراتب',
                'تاريخ التعيين',
                'تاريخ التأمين',
                'الرقم التأميني',
                'اسم الشركة',
                'تاريخ الاستقالة',
                'الحالة',
                'العنوان',
                'الملاحظات'
            ]);

            // Add data
            foreach ($employees as $employee) {
                fputcsv($file, [
                    $employee->name ?? '',
                    $employee->email ?? '',
                    $employee->phone ?? '',
                    $employee->national_id ?? '',
                    $employee->employee_code ?? '',
                    $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '',
                    $employee->years_of_experience ?? '',
                    $employee->position->name ?? '',
                    $employee->department->name ?? '',
                    $employee->account_type ?? '',
                    $employee->salary ?? '',
                    $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '',
                    $employee->insurance_date ? $employee->insurance_date->format('Y-m-d') : '',
                    $employee->insurance_number ?? '',
                    $employee->company_name ?? '',
                    $employee->resignation_date ? $employee->resignation_date->format('Y-m-d') : '',
                    $employee->status ?? '',
                    $employee->address ?? '',
                    $employee->notes ?? ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import employees from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $data = array_map('str_getcsv', file($path));
        
        // Remove BOM if present
        if (!empty($data[0][0])) {
            $data[0][0] = preg_replace('/\x{EF}\x{BB}\x{BF}/u', '', $data[0][0]);
        }
        
        // Remove header row
        $header = array_shift($data);
        
        $imported = 0;
        $skipped = 0;
        $errors = [];

        foreach ($data as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Map CSV columns to database fields
            $employeeData = [
                'name' => isset($row[0]) ? trim($row[0]) : null,
                'email' => isset($row[1]) && !empty(trim($row[1])) ? trim($row[1]) : null,
                'phone' => isset($row[2]) && !empty(trim($row[2])) ? trim($row[2]) : null,
                'national_id' => isset($row[3]) && !empty(trim($row[3])) ? trim($row[3]) : null,
                'employee_code' => isset($row[4]) && !empty(trim($row[4])) ? trim($row[4]) : null,
                'birth_date' => isset($row[5]) && !empty(trim($row[5])) ? trim($row[5]) : null,
                'years_of_experience' => isset($row[6]) && $row[6] !== '' ? (int)$row[6] : null,
                'position_id' => isset($row[7]) && !empty(trim($row[7])) ? Position::where('name', trim($row[7]))->first()?->id : null,
                'department_id' => isset($row[8]) && !empty(trim($row[8])) ? Department::where('name', trim($row[8]))->first()?->id : null,
                'account_type' => isset($row[9]) && !empty(trim($row[9])) ? trim($row[9]) : null,
                'salary' => isset($row[10]) && $row[10] !== '' ? (float)$row[10] : null,
                'hire_date' => isset($row[11]) && !empty(trim($row[11])) ? trim($row[11]) : null,
                'insurance_date' => isset($row[12]) && !empty(trim($row[12])) ? trim($row[12]) : null,
                'insurance_number' => isset($row[13]) && !empty(trim($row[13])) ? trim($row[13]) : null,
                'company_name' => isset($row[14]) && !empty(trim($row[14])) ? trim($row[14]) : null,
                'resignation_date' => isset($row[15]) && !empty(trim($row[15])) ? trim($row[15]) : null,
                'status' => isset($row[16]) && !empty(trim($row[16])) ? trim($row[16]) : 'نشط',
                'address' => isset($row[17]) && !empty(trim($row[17])) ? trim($row[17]) : null,
                'notes' => isset($row[18]) && !empty(trim($row[18])) ? trim($row[18]) : null,
            ];

            // Validate name is required
            if (empty($employeeData['name'])) {
                $skipped++;
                $errors[] = "السطر " . ($index + 2) . ": الاسم مطلوب";
                continue;
            }

            // Generate employee code if empty
            if (empty($employeeData['employee_code'])) {
                $employeeData['employee_code'] = $this->generateEmployeeCode();
            }

            // Check if employee_code already exists (if provided)
            $existingEmployee = null;
            if (!empty($employeeData['employee_code'])) {
                $existingEmployee = Employee::where('employee_code', $employeeData['employee_code'])->first();
            }
            
            if ($existingEmployee) {
                // Update existing employee
                try {
                    $existingEmployee->update($employeeData);
                    $imported++;
                } catch (\Exception $e) {
                    $skipped++;
                    $errors[] = "السطر " . ($index + 2) . ": " . $e->getMessage();
                }
            } else {
                // Create new employee
                try {
                    Employee::create($employeeData);
                    $imported++;
                } catch (\Exception $e) {
                    $skipped++;
                    $errors[] = "السطر " . ($index + 2) . ": " . $e->getMessage();
                }
            }
        }

        $message = "تم استيراد {$imported} موظف بنجاح";
        if ($skipped > 0) {
            $message .= "، تم تخطي {$skipped} سطر";
        }

        return redirect()->route('employees.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    /**
     * Generate automatic employee code in format LA-{number}
     */
    private function generateEmployeeCode(): string
    {
        // Get all employee codes that start with LA-
        $employees = Employee::where('employee_code', 'like', 'LA-%')
            ->get()
            ->map(function ($employee) {
                if (preg_match('/LA-(\d+)/', $employee->employee_code, $matches)) {
                    return (int)$matches[1];
                }
                return 0;
            })
            ->filter()
            ->sort()
            ->values();

        // Get the highest number
        if ($employees->isNotEmpty()) {
            $nextNumber = $employees->last() + 1;
        } else {
            $nextNumber = 1;
        }

        return 'LA-' . $nextNumber;
    }
}
