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
                    <!-- Design Shape -->
                    <div class="form-group">
                        <label for="design_shape" class="form-label">الشكل</label>
                        <input type="text"
                               name="design_shape"
                               id="design_shape"
                               value="{{ old('design_shape', $workOrder->design_shape) }}"
                               class="form-input"
                               placeholder="أدخل الشكل">
                        @error('design_shape')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Design Films -->
                    <div class="form-group">
                        <label for="design_films" class="form-label">أفلام</label>
                        <input type="text"
                               name="design_films"
                               id="design_films"
                               value="{{ old('design_films', $workOrder->design_films) }}"
                               class="form-input"
                               placeholder="أدخل الأفلام">
                        @error('design_films')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Design Knives -->
                    <div class="form-group">
                        <label for="design_knives" class="form-label">سكاكين</label>
                        <input type="text"
                               name="design_knives"
                               id="design_knives"
                               value="{{ old('design_knives', $workOrder->design_knives) }}"
                               class="form-input"
                               placeholder="أدخل السكاكين">
                        @error('design_knives')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Design Drills -->
                    <div class="form-group">
                        <label for="design_drills" class="form-label">الدرافيل</label>
                        <input type="text"
                               name="design_drills"
                               id="design_drills"
                               value="{{ old('design_drills', $workOrder->design_drills) }}"
                               class="form-input"
                               placeholder="أدخل الدرافيل">
                        @error('design_drills')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Design Breaking Gear -->
                    <div class="form-group">
                        <label for="design_breaking_gear" class="form-label">ترس التكسير</label>
                        <input type="text"
                               name="design_breaking_gear"
                               id="design_breaking_gear"
                               value="{{ old('design_breaking_gear', $workOrder->design_breaking_gear) }}"
                               class="form-input"
                               placeholder="أدخل ترس التكسير">
                        @error('design_breaking_gear')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Design Gab -->
                    <div class="form-group">
                        <label for="design_gab" class="form-label">الجاب</label>
                        <input type="text"
                               name="design_gab"
                               id="design_gab"
                               value="{{ old('design_gab', $workOrder->design_gab) }}"
                               class="form-input"
                               placeholder="أدخل الجاب">
                        @error('design_gab')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Design Cliches -->
                    <div class="form-group">
                        <label for="design_cliches" class="form-label">الكلاشيهات المعده</label>
                        <input type="text"
                               name="design_cliches"
                               id="design_cliches"
                               value="{{ old('design_cliches', $workOrder->design_cliches) }}"
                               class="form-input"
                               placeholder="أدخل الكلاشيهات المعده">
                        @error('design_cliches')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Design File -->
                    <div class="form-group">
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


