<x-app-layout>
    @php
        $title = 'إضافة مصروف جديد';
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
                <h2>إضافة مصروف جديد</h2>
                <p>املأ البيانات التالية لإضافة مصروف جديد</p>
            </div>

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <!-- Expense Type -->
                    <div class="form-group">
                        <label for="expense_type_id" class="form-label required">نوع المصروف</label>
                        <select name="expense_type_id" id="expense_type_id" required class="form-select">
                            <option value="">اختر نوع المصروف</option>
                            @foreach($expenseTypes as $type)
                                @if($type->isParent())
                                    <optgroup label="{{ $type->name }}">
                                        @foreach($type->children as $child)
                                            <option value="{{ $child->id }}" {{ old('expense_type_id') == $child->id ? 'selected' : '' }}>
                                                {{ $child->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="{{ $type->id }}" {{ old('expense_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('expense_type_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="date" class="form-label required">التاريخ</label>
                        <input type="date" 
                               name="date" 
                               id="date" 
                               value="{{ old('date', date('Y-m-d')) }}" 
                               required
                               class="form-input">
                        @error('date')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label required">المبلغ (جنيه)</label>
                        <input type="number" 
                               name="amount" 
                               id="amount" 
                               value="{{ old('amount') }}" 
                               required
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00">
                        @error('amount')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supplier -->
                    <div class="form-group">
                        <label for="supplier_id" class="form-label">المورد</label>
                        <select name="supplier_id" id="supplier_id" class="form-select">
                            <option value="">اختر المورد (اختياري)</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }} @if($supplier->company) - {{ $supplier->company }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_method_id" class="form-label">طريقة السداد</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-select">
                            <option value="">اختر طريقة السداد (اختياري)</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea name="description" 
                              id="description" 
                              rows="3"
                              class="form-textarea"
                              placeholder="أدخل وصف المصروف (اختياري)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">ملاحظات</label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3"
                              class="form-textarea"
                              placeholder="أي ملاحظات إضافية (اختياري)">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        حفظ المصروف
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>









