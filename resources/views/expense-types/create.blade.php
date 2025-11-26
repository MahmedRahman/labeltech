<x-app-layout>
    @php
        $title = isset(request()->parent_id) ? 'إضافة نوع فرعي' : 'إضافة نوع مصروف';
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
        
        .form-select {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s;
            background-color: white;
        }
        
        .form-select:focus {
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
            background-color: #2563eb;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .parent-info {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .parent-info p {
            margin: 0;
            font-size: 0.875rem;
            color: #1e40af;
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>{{ isset(request()->parent_id) ? 'إضافة نوع فرعي' : 'إضافة نوع مصروف' }}</h2>
                <p>{{ isset(request()->parent_id) ? 'إضافة نوع فرعي تحت نوع مصروف موجود' : 'إضافة نوع مصروف رئيسي جديد' }}</p>
            </div>

            @if(isset(request()->parent_id))
                @php
                    $parentType = \App\Models\ExpenseType::find(request()->parent_id);
                @endphp
                @if($parentType)
                    <div class="parent-info">
                        <p><strong>النوع الرئيسي:</strong> {{ $parentType->name }}</p>
                    </div>
                @endif
            @endif

            <form action="{{ route('expense-types.store') }}" method="POST">
                @csrf

                @if(isset(request()->parent_id))
                    <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
                @endif

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label required">الاسم</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}" 
                           required
                           class="form-input"
                           placeholder="{{ isset(request()->parent_id) ? 'مثال: كهرباء، مياه' : 'مثال: مصروف تشغيل' }}">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Type (only if not creating a child) -->
                @if(!isset(request()->parent_id))
                <div class="form-group">
                    <label for="parent_id" class="form-label">النوع الرئيسي (اختياري)</label>
                    <select name="parent_id" id="parent_id" class="form-select">
                        <option value="">-- نوع رئيسي (إنشاء نوع جديد) --</option>
                        @foreach($parentTypes as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">اتركه فارغاً لإنشاء نوع رئيسي، أو اختر نوعاً موجوداً لإنشاء نوع فرعي</p>
                    @error('parent_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="form-textarea"
                              placeholder="وصف مختصر عن نوع المصروف">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('expense-types.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset(request()->parent_id) ? 'حفظ النوع الفرعي' : 'حفظ نوع المصروف' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

