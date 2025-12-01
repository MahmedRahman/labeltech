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
                    <div class="form-group">
                        <label for="knife_code" class="form-label required">الرقم الكود</label>
                        <input type="text" 
                               name="knife_code" 
                               id="knife_code" 
                               value="{{ old('knife_code') }}" 
                               required
                               class="form-input"
                               placeholder="أدخل الرقم الكود">
                        @error('knife_code')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="type" class="form-label">النوع</label>
                            <select name="type" 
                                    id="type" 
                                    class="form-select">
                                <option value="">اختر النوع</option>
                                <option value="مستطيل" {{ old('type') == 'مستطيل' ? 'selected' : '' }}>مستطيل</option>
                                <option value="دائرة" {{ old('type') == 'دائرة' ? 'selected' : '' }}>دائرة</option>
                                <option value="مربع" {{ old('type') == 'مربع' ? 'selected' : '' }}>مربع</option>
                                <option value="بيضاوي" {{ old('type') == 'بيضاوي' ? 'selected' : '' }}>بيضاوي</option>
                                <option value="شكل خاص" {{ old('type') == 'شكل خاص' ? 'selected' : '' }}>شكل خاص</option>
                            </select>
                            @error('type')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gear" class="form-label">تُرس</label>
                            <input type="text" 
                                   name="gear" 
                                   id="gear" 
                                   value="{{ old('gear') }}" 
                                   class="form-input"
                                   placeholder="أدخل تُرس">
                            @error('gear')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dragile_drive" class="form-label">دراغيل</label>
                        <input type="text" 
                               name="dragile_drive" 
                               id="dragile_drive" 
                               value="{{ old('dragile_drive') }}" 
                               class="form-input"
                               placeholder="أدخل دراغيل">
                        @error('dragile_drive')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- المواصفات -->
                <div class="form-section">
                    <h3>المواصفات</h3>
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
                            <label for="flap_size" class="form-label">الجيب</label>
                            <input type="text" 
                                   name="flap_size" 
                                   id="flap_size" 
                                   value="{{ old('flap_size') }}" 
                                   class="form-input"
                                   placeholder="أدخل الجيب">
                            @error('flap_size')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="length" class="form-label">الطول</label>
                            <input type="number" 
                                   name="length" 
                                   id="length" 
                                   value="{{ old('length') }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل الطول">
                            @error('length')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="width" class="form-label">العرض</label>
                        <input type="number" 
                               name="width" 
                               id="width" 
                               value="{{ old('width') }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="أدخل العرض">
                        @error('width')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- ملاحظات -->
                <div class="form-section">
                    <h3>ملاحظات</h3>
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
