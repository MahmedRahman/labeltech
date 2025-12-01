<x-app-layout>
    @php
        $title = 'إضافة سكينة جديدة';
    @endphp

    <style>
        .form-container {
            max-width: 1000px;
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
        
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: #f9fafb;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }
        
        .form-section h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 1.5rem 0;
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
        
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s;
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-textarea {
            resize: vertical;
            min-height: 80px;
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
            background-color: #2563eb;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
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
                <h2>إضافة سكينة جديدة</h2>
                <p>املأ البيانات التالية لإضافة سكينة جديدة</p>
            </div>

            <form action="{{ route('knives.store') }}" method="POST">
                @csrf

                <!-- معلومات أساسية -->
                <div class="form-section">
                    <h3>معلومات أساسية</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="knife_code" class="form-label required">كود السكينة</label>
                            <input type="text" 
                                   name="knife_code" 
                                   id="knife_code" 
                                   value="{{ old('knife_code') }}" 
                                   required
                                   class="form-input"
                                   placeholder="أدخل كود السكينة">
                            @error('knife_code')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="knife_name" class="form-label required">اسم السكينة</label>
                            <input type="text" 
                                   name="knife_name" 
                                   id="knife_name" 
                                   value="{{ old('knife_name') }}" 
                                   required
                                   class="form-input"
                                   placeholder="أدخل اسم السكينة">
                            @error('knife_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="knife_type" class="form-label">نوع السكينة</label>
                            <input type="text" 
                                   name="knife_type" 
                                   id="knife_type" 
                                   value="{{ old('knife_type') }}" 
                                   class="form-input"
                                   placeholder="أدخل نوع السكينة">
                            @error('knife_type')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="size" class="form-label">المقاس</label>
                            <input type="text" 
                                   name="size" 
                                   id="size" 
                                   value="{{ old('size') }}" 
                                   class="form-input"
                                   placeholder="أدخل المقاس">
                            @error('size')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- المواصفات الفنية -->
                <div class="form-section">
                    <h3>المواصفات الفنية</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="rows_count" class="form-label">عدد الصفوف</label>
                            <input type="number" 
                                   name="rows_count" 
                                   id="rows_count" 
                                   value="{{ old('rows_count') }}" 
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل عدد الصفوف">
                            @error('rows_count')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="eyes_count" class="form-label">عدد العيون</label>
                            <input type="number" 
                                   name="eyes_count" 
                                   id="eyes_count" 
                                   value="{{ old('eyes_count') }}" 
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل عدد العيون">
                            @error('eyes_count')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="flap_size" class="form-label">حجم الجيب</label>
                            <input type="text" 
                                   name="flap_size" 
                                   id="flap_size" 
                                   value="{{ old('flap_size') }}" 
                                   class="form-input"
                                   placeholder="أدخل حجم الجيب">
                            @error('flap_size')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="grain_direction" class="form-label">اتجاه البحر</label>
                            <input type="text" 
                                   name="grain_direction" 
                                   id="grain_direction" 
                                   value="{{ old('grain_direction') }}" 
                                   class="form-input"
                                   placeholder="أدخل اتجاه البحر">
                            @error('grain_direction')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="knife_thickness" class="form-label">سُمك السكينة</label>
                            <input type="number" 
                                   name="knife_thickness" 
                                   id="knife_thickness" 
                                   value="{{ old('knife_thickness') }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل سُمك السكينة">
                            @error('knife_thickness')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="crease_lines" class="form-label">خطوط التكسير</label>
                            <input type="number" 
                                   name="crease_lines" 
                                   id="crease_lines" 
                                   value="{{ old('crease_lines') }}" 
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل عدد خطوط التكسير">
                            @error('crease_lines')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="punch_holes" class="form-label">عدد الثقوب</label>
                            <input type="number" 
                                   name="punch_holes" 
                                   id="punch_holes" 
                                   value="{{ old('punch_holes') }}" 
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل عدد الثقوب">
                            @error('punch_holes')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="drill_size" class="form-label">مقاس البرّافات</label>
                            <input type="text" 
                                   name="drill_size" 
                                   id="drill_size" 
                                   value="{{ old('drill_size') }}" 
                                   class="form-input"
                                   placeholder="أدخل مقاس البرّافات">
                            @error('drill_size')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="material_type" class="form-label">نوع المعدن</label>
                        <input type="text" 
                               name="material_type" 
                               id="material_type" 
                               value="{{ old('material_type') }}" 
                               class="form-input"
                               placeholder="أدخل نوع المعدن">
                        @error('material_type')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- معلومات الإدارة -->
                <div class="form-section">
                    <h3>معلومات الإدارة</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="purchase_date" class="form-label">تاريخ الشراء</label>
                            <input type="date" 
                                   name="purchase_date" 
                                   id="purchase_date" 
                                   value="{{ old('purchase_date') }}" 
                                   class="form-input">
                            @error('purchase_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="knife_status" class="form-label required">حالة السكينة</label>
                            <select name="knife_status" 
                                    id="knife_status" 
                                    required
                                    class="form-select">
                                <option value="active" {{ old('knife_status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="inactive" {{ old('knife_status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                <option value="maintenance" {{ old('knife_status') == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                <option value="retired" {{ old('knife_status') == 'retired' ? 'selected' : '' }}>متقاعد</option>
                            </select>
                            @error('knife_status')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="usage_count" class="form-label">عدد الاستخدام</label>
                            <input type="number" 
                                   name="usage_count" 
                                   id="usage_count" 
                                   value="{{ old('usage_count', 0) }}" 
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل عدد الاستخدام">
                            @error('usage_count')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="storage_location" class="form-label">مكان التخزين</label>
                            <input type="text" 
                                   name="storage_location" 
                                   id="storage_location" 
                                   value="{{ old('storage_location') }}" 
                                   class="form-input"
                                   placeholder="أدخل مكان التخزين">
                            @error('storage_location')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="form-textarea"
                                  placeholder="أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('knives.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        حفظ السكينة
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

