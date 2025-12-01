<x-app-layout>
    @php
        $title = 'إضافة بيانات التصميم';
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
        
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #111827;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary {
            background-color: #2563eb;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        
        .btn-secondary {
            background-color: #6b7280;
            color: white;
            border: none;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .work-order-info {
            background-color: #f9fafb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 2rem;
            border: 1px solid #e5e7eb;
        }

        .work-order-info h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.5rem 0;
        }

        .work-order-info p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0.25rem 0;
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>إضافة بيانات التصميم</h2>
                <p>أضف تفاصيل التصميم الخاصة بأمر الشغل</p>
            </div>

            <!-- Work Order Info -->
            <div class="work-order-info">
                <h3>معلومات أمر الشغل</h3>
                <p><strong>رقم الأمر:</strong> {{ $workOrder->order_number ?? 'بدون رقم' }}</p>
                <p><strong>العميل:</strong> {{ $workOrder->client->name }}</p>
                <p><strong>الخامة:</strong> {{ $workOrder->material }}</p>
                <p><strong>الكمية:</strong> {{ number_format($workOrder->quantity) }}</p>
            </div>

            <form action="{{ route('work-orders.design.store', $workOrder) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <!-- Design Knife -->
                    <div class="form-group">
                        <label for="design_knife_id" class="form-label">السكاكين</label>
                        <select name="design_knife_id" 
                                id="design_knife_id" 
                                class="form-select">
                            <option value="">اختر السكينة</option>
                            @foreach($knives as $knife)
                                <option value="{{ $knife->id }}" {{ old('design_knife_id', $workOrder->design_knife_id) == $knife->id ? 'selected' : '' }}>
                                    {{ $knife->knife_code }} - {{ $knife->type ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('design_knife_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Design Rows Count -->
                    <div class="form-group">
                        <label for="design_rows_count" class="form-label">عدد الصفوف</label>
                        <input type="number"
                               name="design_rows_count"
                               id="design_rows_count"
                               value="{{ old('design_rows_count', $workOrder->design_rows_count) }}"
                               class="form-input"
                               min="1"
                               placeholder="أدخل عدد الصفوف">
                        @error('design_rows_count')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <!-- Design File -->
                    <label for="design_file" class="form-label">ملف التصميم</label>
                    <input type="file"
                           name="design_file"
                           id="design_file"
                           class="form-input"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.ai,.psd">
                    @if($workOrder->design_file)
                        <p style="font-size: 0.875rem; color: #059669; margin-top: 0.5rem;">
                            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ملف موجود: <a href="{{ asset('storage/designs/' . $workOrder->design_file) }}" target="_blank" style="color: #2563eb; text-decoration: underline;">عرض الملف</a>
                        </p>
                    @endif
                    @error('design_file')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('work-orders.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        حفظ بيانات التصميم
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>


