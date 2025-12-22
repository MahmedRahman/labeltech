<x-app-layout>
    @php
        $title = 'تعديل فريق المبيعات';
    @endphp

    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            padding: 2rem;
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

        .form-input {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background-color: white;
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
            background-color: white;
            min-height: 100px;
            resize: vertical;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            background-color: #f9fafb;
            transition: all 0.2s;
        }

        .checkbox-item:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
        }

        .checkbox-item input[type="checkbox"] {
            margin-left: 0.5rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-item label {
            cursor: pointer;
            flex: 1;
            font-size: 0.875rem;
            color: #111827;
        }

        .btn-submit {
            padding: 0.625rem 1.5rem;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
        }

        .btn-cancel {
            padding: 0.625rem 1.5rem;
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            border-radius: 0.375rem;
            font-weight: 500;
            display: inline-block;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0;">تعديل فريق المبيعات</h2>
                <p style="font-size: 1rem; color: #6b7280; margin: 0;">قم بتعديل بيانات فريق المبيعات</p>
            </div>

            <form action="{{ route('sales-teams.update', $salesTeam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">اسم الفريق <span style="color: #dc2626;">*</span></label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $salesTeam->name) }}" 
                           class="form-input"
                           required>
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea name="description" 
                              id="description" 
                              class="form-textarea">{{ old('description', $salesTeam->description) }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">موظفو المبيعات</label>
                    @if($employees->count() > 0)
                        <div class="checkbox-group">
                            @php
                                $selectedEmployeeIds = old('employee_ids', $salesTeam->employees->pluck('id')->toArray());
                            @endphp
                            @foreach($employees as $employee)
                                <div class="checkbox-item">
                                    <input type="checkbox" 
                                           name="employee_ids[]" 
                                           id="employee_{{ $employee->id }}" 
                                           value="{{ $employee->id }}"
                                           {{ in_array($employee->id, $selectedEmployeeIds) ? 'checked' : '' }}>
                                    <label for="employee_{{ $employee->id }}">{{ $employee->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #6b7280; font-size: 0.875rem;">لا يوجد موظفي مبيعات متاحين</p>
                    @endif
                    @error('employee_ids')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn-submit">حفظ التغييرات</button>
                    <a href="{{ route('sales-teams.index') }}" class="btn-cancel">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

