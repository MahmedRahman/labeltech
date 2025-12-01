<x-app-layout>
    @php
        $title = 'إضافة خامة جديدة';
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
    </style>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>إضافة خامة جديدة</h2>
                <p>املأ البيانات التالية لإضافة خامة جديدة إلى النظام</p>
            </div>

            <form action="{{ route('materials.store') }}" method="POST">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label required">اسم الخامة</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}" 
                           required
                           class="form-input"
                           placeholder="أدخل اسم الخامة">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="form-textarea"
                              placeholder="أدخل وصف الخامة (اختياري)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="form-group">
                    <label for="is_active" class="form-label">الحالة</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>غير نشط</option>
                    </select>
                    @error('is_active')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('materials.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        حفظ الخامة
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>


