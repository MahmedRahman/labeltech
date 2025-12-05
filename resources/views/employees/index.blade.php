<x-app-layout>
    @php
        $title = 'قائمة الموظفين';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة الموظفين</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع موظفيك من مكان واحد</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('employees.export') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                تصدير CSV
            </a>
            <button type="button" onclick="document.getElementById('importModal').style.display='block'" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #f59e0b; color: white; text-decoration: none; border: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer;">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                استيراد CSV
            </button>
            <a href="{{ route('employees.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة موظف جديد
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <form method="GET" action="{{ route('employees.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <!-- Search by Name -->
            <div>
                <label for="search_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">البحث بالاسم</label>
                <input type="text" 
                       name="search_name" 
                       id="search_name" 
                       value="{{ request('search_name') }}"
                       placeholder="ابحث بالاسم..."
                       style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
            </div>

            <!-- Search by Code -->
            <div>
                <label for="search_code" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">البحث بالكود</label>
                <input type="text" 
                       name="search_code" 
                       id="search_code" 
                       value="{{ request('search_code') }}"
                       placeholder="ابحث بالكود..."
                       style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
            </div>

            <!-- Filter Actions -->
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" style="flex: 1; padding: 0.625rem 1rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.15s;">
                    <svg style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    بحث
                </button>
                @if(request()->hasAny(['search_name', 'search_code']))
                    <a href="{{ route('employees.index') }}" style="flex: 1; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-align: center; display: flex; align-items: center; justify-content: center;">
                        إلغاء
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($employees->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>المنصب</th>
                            <th>القسم</th>
                            <th>نوع الحساب</th>
                            <th>الراتب</th>
                            <th>تاريخ التوظيف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td style="font-weight: 500; color: #111827;">{{ $employee->name }}</td>
                                <td style="color: #6b7280;">{{ $employee->email ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $employee->phone ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $employee->position->name ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $employee->department->name ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $employee->account_type ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $employee->salary ? number_format($employee->salary, 2) . ' جنيه' : '-' }}</td>
                                <td style="color: #6b7280;">{{ $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('employees.show', $employee) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('employees.edit', $employee) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $employees->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا يوجد موظفين</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة موظف جديد</p>
                    <a href="{{ route('employees.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة موظف جديد
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); overflow: auto;">
        <div style="background-color: white; margin: 5% auto; padding: 2rem; border-radius: 0.5rem; max-width: 600px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0;">استيراد الموظفين من CSV</h3>
                <button type="button" onclick="document.getElementById('importModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">&times;</button>
            </div>
            
            <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label for="csv_file" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">اختر ملف CSV</label>
                    <input type="file" 
                           name="csv_file" 
                           id="csv_file" 
                           accept=".csv,.txt"
                           required
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    @error('csv_file')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
                    <p style="font-size: 0.875rem; color: #374151; margin: 0 0 0.5rem 0; font-weight: 500;">ملاحظات:</p>
                    <ul style="font-size: 0.875rem; color: #6b7280; margin: 0; padding-right: 1.25rem;">
                        <li>يجب أن يحتوي الملف على رأس الأعمدة في السطر الأول</li>
                        <li>الاسم مطلوب لكل موظف</li>
                        <li>إذا كان كود الموظف موجوداً، سيتم تحديث البيانات</li>
                        <li>إذا كان كود الموظف غير موجود، سيتم إنشاء موظف جديد</li>
                        <li>يمكنك تصدير ملف CSV أولاً لمعرفة التنسيق المطلوب</li>
                    </ul>
                </div>

                @if(session('import_errors') && count(session('import_errors')) > 0)
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
                        <p style="font-size: 0.875rem; color: #dc2626; margin: 0 0 0.5rem 0; font-weight: 500;">أخطاء الاستيراد:</p>
                        <ul style="font-size: 0.875rem; color: #991b1b; margin: 0; padding-right: 1.25rem;">
                            @foreach(session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                    <button type="button" onclick="document.getElementById('importModal').style.display='none'" style="padding: 0.625rem 1.5rem; background-color: #6b7280; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">
                        إلغاء
                    </button>
                    <button type="submit" style="padding: 0.625rem 1.5rem; background-color: #f59e0b; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">
                        استيراد
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('importModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</x-app-layout>

