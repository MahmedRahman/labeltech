<x-app-layout>
    @php
        $title = 'إضافة أمر شغل جديد';
    @endphp

    <style>
        .form-container {
            max-width: 900px;
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
        
        .form-input, .form-select {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s;
        }
        
        .form-input:focus, .form-select:focus {
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
                <h2>إضافة أمر شغل جديد</h2>
                <p>املأ البيانات التالية لإضافة أمر شغل جديد</p>
            </div>

            <form action="{{ route('work-orders.store') }}" method="POST">
                @csrf

                <!-- Client Selection -->
                <div class="form-group">
                    <label for="client_id" class="form-label required">العميل</label>
                    <select name="client_id" id="client_id" required class="form-select">
                        <option value="">اختر العميل</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} @if($client->company) - {{ $client->company }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order Number -->
                <div class="form-group">
                    <label for="order_number" class="form-label">رقم أمر الشغل</label>
                    <input type="text" 
                           name="order_number" 
                           id="order_number" 
                           value="{{ old('order_number') }}" 
                           class="form-input"
                           placeholder="سيتم توليده تلقائياً إذا تركت فارغاً">
                    @error('order_number')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Material and Number of Colors -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="material" class="form-label required">الخامة</label>
                        <input type="text" 
                               name="material" 
                               id="material" 
                               value="{{ old('material') }}" 
                               required
                               class="form-input"
                               placeholder="نوع الخامة">
                        @error('material')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="number_of_colors" class="form-label required">عدد الألوان</label>
                        <input type="number" 
                               name="number_of_colors" 
                               id="number_of_colors" 
                               value="{{ old('number_of_colors', 1) }}" 
                               required
                               min="1"
                               class="form-input"
                               placeholder="1">
                        @error('number_of_colors')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Quantity -->
                <div class="form-group">
                    <label for="quantity" class="form-label required">الكمية</label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity" 
                           value="{{ old('quantity') }}" 
                           required
                           min="1"
                           class="form-input"
                           placeholder="الكمية المطلوبة">
                    @error('quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Width and Length -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="width" class="form-label">العرض (سم)</label>
                        <input type="number" 
                               name="width" 
                               id="width" 
                               value="{{ old('width') }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00">
                        @error('width')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="length" class="form-label">الطول (سم)</label>
                        <input type="number" 
                               name="length" 
                               id="length" 
                               value="{{ old('length') }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00">
                        @error('length')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Final Product Shape -->
                <div class="form-group">
                    <label for="final_product_shape" class="form-label">شكل المنتج النهائي</label>
                    <textarea name="final_product_shape" 
                              id="final_product_shape" 
                              rows="3"
                              class="form-textarea"
                              placeholder="وصف شكل المنتج النهائي المطلوب">{{ old('final_product_shape') }}</textarea>
                    @error('final_product_shape')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additions -->
                <div class="form-group">
                    <label for="additions" class="form-label">الإضافات المطلوبة</label>
                    <textarea name="additions" 
                              id="additions" 
                              rows="3"
                              class="form-textarea"
                              placeholder="أي إضافات خاصة يطلبها العميل">{{ old('additions') }}</textarea>
                    @error('additions')
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
                              placeholder="أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status" class="form-label">الحالة</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                    @error('status')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('work-orders.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        حفظ أمر الشغل
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

