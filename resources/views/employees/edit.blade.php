<x-app-layout>
    @php
        $title = 'تعديل بيانات الموظف';
    @endphp

    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-card {
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 2rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.5rem 0;
        }
        
        .form-header p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-label.required::after {
            content: " *";
            color: #dc2626;
        }
        
        .form-input {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-textarea {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            resize: vertical;
            min-height: 80px;
            transition: all 0.2s;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .error-message {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #dc2626;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Cairo', sans-serif;
        }
        
        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
        
        .btn-primary {
            background-color: #10b981;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #059669;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-section {
            margin-bottom: 2.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .form-section:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .section-header {
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #10b981;
        }
        
        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background-color: #10b981;
            border-radius: 2px;
        }
        
        .section-description {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0.5rem 0 0 0;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-card {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>تعديل بيانات الموظف</h2>
                <p>تحديث معلومات الموظف: {{ $employee->name }}</p>
            </div>

            <form action="{{ route('employees.update', $employee) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- البيانات الأساسية -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">البيانات الأساسية</h3>
                        <p class="section-description">المعلومات الشخصية الأساسية للموظف</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="form-label required">الاسم</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $employee->name) }}" 
                               required
                               class="form-input"
                               placeholder="أدخل اسم الموظف">
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="national_id" class="form-label">الرقم القومي</label>
                            <input type="text" 
                                   name="national_id" 
                                   id="national_id" 
                                   value="{{ old('national_id', $employee->national_id) }}"
                                   class="form-input"
                                   placeholder="أدخل الرقم القومي">
                            @error('national_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="employee_code" class="form-label">كود الموظف</label>
                            <input type="text" 
                                   name="employee_code" 
                                   id="employee_code" 
                                   value="{{ old('employee_code', $employee->employee_code) }}"
                                   class="form-input"
                                   placeholder="أدخل كود الموظف">
                            @error('employee_code')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="birth_date" class="form-label">تاريخ الميلاد</label>
                            <input type="date" 
                                   name="birth_date" 
                                   id="birth_date" 
                                   value="{{ old('birth_date', $employee->birth_date ? $employee->birth_date->format('Y-m-d') : '') }}"
                                   class="form-input">
                            @error('birth_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="years_of_experience" class="form-label">عدد سنوات الخبرة</label>
                            <input type="number" 
                                   name="years_of_experience" 
                                   id="years_of_experience" 
                                   value="{{ old('years_of_experience', $employee->years_of_experience) }}"
                                   min="0"
                                   class="form-input"
                                   placeholder="0">
                            @error('years_of_experience')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات الاتصال -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">بيانات الاتصال</h3>
                        <p class="section-description">معلومات التواصل مع الموظف</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $employee->email) }}"
                                   class="form-input"
                                   placeholder="example@email.com">
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">الهاتف</label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone', $employee->phone) }}"
                                   class="form-input"
                                   placeholder="01234567890">
                            @error('phone')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">العنوان</label>
                        <textarea name="address" 
                                  id="address" 
                                  rows="3"
                                  class="form-textarea"
                                  placeholder="أدخل عنوان الموظف">{{ old('address', $employee->address) }}</textarea>
                        @error('address')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- بيانات الحساب -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">بيانات الحساب</h3>
                        <p class="section-description">معلومات تسجيل الدخول والصلاحيات</p>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-input"
                               placeholder="اتركه فارغاً إذا لم ترد تغيير كلمة المرور (الحد الأدنى 6 أحرف)">
                        <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">اتركه فارغاً إذا لم ترد تغيير كلمة المرور</p>
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="account_type" class="form-label">نوع الحساب</label>
                        <select name="account_type" 
                                id="account_type" 
                                class="form-input">
                            <option value="">اختر نوع الحساب</option>
                            <option value="مبيعات" {{ old('account_type', $employee->account_type) == 'مبيعات' ? 'selected' : '' }}>مبيعات</option>
                            <option value="تصميم" {{ old('account_type', $employee->account_type) == 'تصميم' ? 'selected' : '' }}>تصميم</option>
                            <option value="تشغيل" {{ old('account_type', $employee->account_type) == 'تشغيل' ? 'selected' : '' }}>تشغيل</option>
                            <option value="حسابات" {{ old('account_type', $employee->account_type) == 'حسابات' ? 'selected' : '' }}>حسابات</option>
                            <option value="مدير" {{ old('account_type', $employee->account_type) == 'مدير' ? 'selected' : '' }}>مدير</option>
                        </select>
                        @error('account_type')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- البيانات الوظيفية -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">البيانات الوظيفية</h3>
                        <p class="section-description">معلومات الوظيفة والراتب</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="department_id" class="form-label">القسم</label>
                            <select name="department_id" 
                                    id="department_id" 
                                    class="form-input"
                                    onchange="updatePositions(this.value)">
                                <option value="">اختر القسم</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="position_id" class="form-label">المنصب</label>
                            <select name="position_id" 
                                    id="position_id" 
                                    class="form-input">
                                <option value="">اختر المنصب</option>
                                @foreach($positions as $position)
                                    <option value="{{ $position->id }}" 
                                            data-department="{{ $position->department_id }}"
                                            {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}
                                            style="display: {{ ($employee->department_id && $employee->department_id == $position->department_id) || (old('department_id', $employee->department_id) && old('department_id', $employee->department_id) == $position->department_id) ? 'block' : 'none' }};">
                                        {{ $position->name }} ({{ $position->department->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <script>
                        function updatePositions(departmentId) {
                            const positionSelect = document.getElementById('position_id');
                            const options = positionSelect.querySelectorAll('option');
                            
                            options.forEach(option => {
                                if (option.value === '') {
                                    option.style.display = 'block';
                                } else {
                                    const optionDepartment = option.getAttribute('data-department');
                                    if (departmentId && optionDepartment == departmentId) {
                                        option.style.display = 'block';
                                    } else {
                                        option.style.display = 'none';
                                    }
                                }
                            });
                            
                            // Reset position selection if department changed
                            if (positionSelect.value) {
                                const selectedOption = positionSelect.options[positionSelect.selectedIndex];
                                if (selectedOption.getAttribute('data-department') != departmentId) {
                                    positionSelect.value = '';
                                }
                            }
                        }

                        // Initialize on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            const departmentSelect = document.getElementById('department_id');
                            if (departmentSelect.value) {
                                updatePositions(departmentSelect.value);
                            }
                        });
                    </script>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="salary" class="form-label">الراتب</label>
                            <input type="number" 
                                   name="salary" 
                                   id="salary" 
                                   value="{{ old('salary', $employee->salary) }}"
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="0.00">
                            @error('salary')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hire_date" class="form-label">تاريخ التعيين</label>
                            <input type="date" 
                                   name="hire_date" 
                                   id="hire_date" 
                                   value="{{ old('hire_date', $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '') }}"
                                   class="form-input">
                            @error('hire_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات التأمين -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">بيانات التأمين</h3>
                        <p class="section-description">معلومات التأمين الاجتماعي</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="insurance_date" class="form-label">تاريخ التأمين</label>
                            <input type="date" 
                                   name="insurance_date" 
                                   id="insurance_date" 
                                   value="{{ old('insurance_date', $employee->insurance_date ? $employee->insurance_date->format('Y-m-d') : '') }}"
                                   class="form-input">
                            @error('insurance_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="insurance_number" class="form-label">الرقم التأميني</label>
                            <input type="text" 
                                   name="insurance_number" 
                                   id="insurance_number" 
                                   value="{{ old('insurance_number', $employee->insurance_number) }}"
                                   class="form-input"
                                   placeholder="أدخل الرقم التأميني">
                            @error('insurance_number')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات الشركة والحالة -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">بيانات الشركة والحالة</h3>
                        <p class="section-description">معلومات الشركة وحالة الموظف</p>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="company_name" class="form-label">اسم الشركة</label>
                            <select name="company_name" 
                                    id="company_name" 
                                    class="form-input">
                                <option value="">اختر اسم الشركة</option>
                                <option value="Main Company" {{ old('company_name', $employee->company_name) == 'Main Company' ? 'selected' : '' }}>Main Company</option>
                                <option value="2nd Company" {{ old('company_name', $employee->company_name) == '2nd Company' ? 'selected' : '' }}>2nd Company</option>
                            </select>
                            @error('company_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">الحالة</label>
                            <select name="status" 
                                    id="status" 
                                    class="form-input">
                                <option value="نشط" {{ old('status', $employee->status) == 'نشط' ? 'selected' : '' }}>نشط</option>
                                <option value="استقال" {{ old('status', $employee->status) == 'استقال' ? 'selected' : '' }}>استقال</option>
                                <option value="معطل" {{ old('status', $employee->status) == 'معطل' ? 'selected' : '' }}>معطل</option>
                            </select>
                            @error('status')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="resignation_date" class="form-label">تاريخ الاستقالة</label>
                        <input type="date" 
                               name="resignation_date" 
                               id="resignation_date" 
                               value="{{ old('resignation_date', $employee->resignation_date ? $employee->resignation_date->format('Y-m-d') : '') }}"
                               class="form-input">
                        @error('resignation_date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- بيانات إضافية -->
                <div class="form-section">
                    <div class="section-header">
                        <h3 class="section-title">بيانات إضافية</h3>
                        <p class="section-description">ملاحظات ومعلومات إضافية</p>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="form-textarea"
                                  placeholder="أي ملاحظات إضافية عن الموظف">{{ old('notes', $employee->notes) }}</textarea>
                        @error('notes')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        تحديث البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

