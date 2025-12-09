<x-app-layout>
    @php
        $title = 'بيانات الموظف';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">بيانات الموظف</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $employee->name }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('employees.edit', $employee) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('employees.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الاسم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->name }}</dd>
            </div>

            @if($employee->email)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">البريد الإلكتروني</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->email }}</dd>
            </div>
            @endif

            @if($employee->phone)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الهاتف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->phone }}</dd>
            </div>
            @endif

            @if($employee->position)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">المنصب</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->position->name }}</dd>
            </div>
            @endif

            @if($employee->department)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">القسم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->department->name }}</dd>
            </div>
            @endif

            @if($employee->account_type)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نوع الحساب</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->account_type }}</dd>
            </div>
            @endif

            @if($employee->salary)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الراتب</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($employee->salary, 2) }} جنيه</dd>
            </div>
            @endif

            @if($employee->national_id)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الرقم القومي</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->national_id }}</dd>
            </div>
            @endif

            @if($employee->employee_code)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">كود الموظف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->employee_code }}</dd>
            </div>
            @endif

            @if($employee->birth_date)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الميلاد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->birth_date->format('Y-m-d') }}</dd>
            </div>
            @endif

            @if($employee->years_of_experience !== null)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد سنوات الخبرة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->years_of_experience }} سنة</dd>
            </div>
            @endif

            @if($employee->hire_date)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ التعيين</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->hire_date->format('Y-m-d') }}</dd>
            </div>
            @endif

            @if($employee->insurance_date)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ التأمين</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->insurance_date->format('Y-m-d') }}</dd>
            </div>
            @endif

            @if($employee->insurance_number)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الرقم التأميني</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->insurance_number }}</dd>
            </div>
            @endif

            @if($employee->company_name)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اسم الشركة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->company_name }}</dd>
            </div>
            @endif

            @if($employee->status)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الحالة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->status }}</dd>
            </div>
            @endif

            @if($employee->resignation_date)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الاستقالة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->resignation_date->format('Y-m-d') }}</dd>
            </div>
            @endif

            @if($employee->address)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العنوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->address }}</dd>
            </div>
            @endif

            @if($employee->notes)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->notes }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإضافة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $employee->created_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>
    </div>
</x-app-layout>

