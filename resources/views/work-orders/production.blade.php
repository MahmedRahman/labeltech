<x-app-layout>
    @php
        $title = 'إضافة بيانات التشغيل';
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
        
        .form-input, .form-select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #111827;
            background-color: #fff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-input:focus, .form-select:focus {
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

        .section-divider {
            margin: 2rem 0;
            border-top: 2px solid #e5e7eb;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 1.5rem;
        }

        .production-type-group {
            margin-bottom: 2rem;
        }

        .radio-group {
            display: flex;
            gap: 2rem;
            margin-top: 0.5rem;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .radio-option:hover {
            border-color: #9ca3af;
        }

        .radio-option.active {
            border-color: #2563eb;
            background-color: #eff6ff;
        }

        .radio-option input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2563eb;
        }

        .radio-option span {
            font-size: 0.875rem;
            font-weight: 500;
            color: #111827;
        }

        .conditional-fields {
            display: none;
        }

        .conditional-fields.show {
            display: block;
        }

        .info-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            font-size: 0.875rem;
            color: #1e40af;
            margin: 0;
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>إضافة بيانات التشغيل</h2>
                <p>أضف تفاصيل التشغيل الخاصة بأمر الشغل</p>
            </div>

            <!-- Work Order Info -->
            <div class="work-order-info">
                <h3>معلومات أمر الشغل</h3>
                <p><strong>رقم الأمر:</strong> {{ $workOrder->order_number ?? 'بدون رقم' }}</p>
                <p><strong>العميل:</strong> {{ $workOrder->client->name }}</p>
                <p><strong>الخامة:</strong> {{ $workOrder->material }}</p>
                <p><strong>الكمية:</strong> {{ number_format($workOrder->quantity) }}</p>
                <p><strong>شكل المنتج النهائي:</strong> {{ $workOrder->final_product_shape ?? 'غير محدد' }}</p>
            </div>

            <form action="{{ route('work-orders.production.store', $workOrder) }}" method="POST">
                @csrf

                <!-- بيانات الورق -->
                <div class="section-title">🔹 بيانات الورق</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="paper_width" class="form-label">عرض الورق</label>
                        <input type="number"
                               name="paper_width"
                               id="paper_width"
                               value="{{ old('paper_width', $workOrder->paper_width) }}"
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="أدخل عرض الورق">
                        @error('paper_width')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="paper_weight" class="form-label">الوزن (جرام/م²)</label>
                        <input type="number"
                               name="paper_weight"
                               id="paper_weight"
                               value="{{ old('paper_weight', $workOrder->paper_weight) }}"
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="أدخل الوزن">
                        @error('paper_weight')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="waste_percentage" class="form-label">نسبة الهالك (%)</label>
                    <input type="number"
                           name="waste_percentage"
                           id="waste_percentage"
                           value="{{ old('waste_percentage', $workOrder->waste_percentage) }}"
                           step="0.01"
                           min="0"
                           max="100"
                           class="form-input"
                           placeholder="أدخل نسبة الهالك">
                    @error('waste_percentage')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="section-divider"></div>

                <!-- نوع التشغيل -->
                <div class="section-title">🔹 اختيار نوع التشغيل</div>
                <div class="production-type-group">
                    <label class="form-label">نوع التشغيل</label>
                    <div class="radio-group">
                        <label class="radio-option {{ $workOrder->final_product_shape == 'بكر' ? 'active' : '' }}" id="roll-option">
                            <input type="radio" 
                                   value="بكر" 
                                   {{ $workOrder->final_product_shape == 'بكر' ? 'checked' : '' }}
                                   onchange="toggleProductionFields('roll')">
                            <span>بكر</span>
                        </label>
                        <label class="radio-option {{ $workOrder->final_product_shape == 'شيت' ? 'active' : '' }}" id="sheet-option">
                            <input type="radio" 
                                   value="شيت" 
                                   {{ $workOrder->final_product_shape == 'شيت' ? 'checked' : '' }}
                                   onchange="toggleProductionFields('sheet')">
                            <span>شيت</span>
                        </label>
                    </div>
                    <div class="info-box" style="margin-top: 1rem;">
                        <p>💡 يتم عرض نوع التشغيل من أمر الشغل (شكل المنتج النهائي)</p>
                    </div>
                </div>

                <!-- بيانات التشغيل - بكر -->
                <div class="conditional-fields {{ $workOrder->final_product_shape == 'بكر' ? 'show' : '' }}" id="roll-fields">
                    <div class="section-divider"></div>
                    <div class="section-title">🔹 بيانات التشغيل - بكر</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="number_of_rolls" class="form-label">عدد البكر</label>
                            <input type="number"
                                   name="number_of_rolls"
                                   id="number_of_rolls"
                                   value="{{ old('number_of_rolls', $workOrder->number_of_rolls) }}"
                                   min="1"
                                   class="form-input"
                                   placeholder="أدخل عدد البكر">
                            @error('number_of_rolls')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="core_size" class="form-label">مقاس الكور</label>
                            <input type="number"
                                   name="core_size"
                                   id="core_size"
                                   value="{{ old('core_size', $workOrder->core_size) }}"
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="أدخل مقاس الكور">
                            @error('core_size')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- بيانات التشغيل - شيت -->
                <div class="conditional-fields {{ $workOrder->final_product_shape == 'شيت' ? 'show' : '' }}" id="sheet-fields">
                    <div class="section-divider"></div>
                    <div class="section-title">🔹 بيانات التشغيل - شيت</div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pieces_per_sheet" class="form-label">عدد التكت في الشيت</label>
                            <input type="number"
                                   name="pieces_per_sheet"
                                   id="pieces_per_sheet"
                                   value="{{ old('pieces_per_sheet', $workOrder->pieces_per_sheet) }}"
                                   min="1"
                                   class="form-input"
                                   placeholder="أدخل عدد التكت في الشيت">
                            @error('pieces_per_sheet')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sheets_per_stack" class="form-label">عدد الشيت في الراكوة</label>
                            <input type="number"
                                   name="sheets_per_stack"
                                   id="sheets_per_stack"
                                   value="{{ old('sheets_per_stack', $workOrder->sheets_per_stack) }}"
                                   min="1"
                                   class="form-input"
                                   placeholder="أدخل عدد الشيت في الراكوة">
                            @error('sheets_per_stack')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pieces_per_stack" class="form-label">عدد التكت في الراكوة</label>
                        <input type="number"
                               name="pieces_per_stack"
                               id="pieces_per_stack"
                               value="{{ old('pieces_per_stack', $workOrder->pieces_per_stack) }}"
                               min="1"
                               class="form-input"
                               placeholder="أدخل عدد التكت في الراكوة">
                        @error('pieces_per_stack')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="section-divider"></div>

                <!-- بيانات إضافية عامة -->
                <div class="section-title">🔹 بيانات إضافية عامة</div>
                <div class="form-group">
                    <label class="form-label">عدد الأطقم (Quantity / عدد الطلبية)</label>
                    <div class="info-box">
                        <p><strong>{{ number_format($workOrder->quantity) }}</strong> - يتم عرضه من أمر الشغل</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('work-orders.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        حفظ بيانات التشغيل
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleProductionFields(type) {
            const rollFields = document.getElementById('roll-fields');
            const sheetFields = document.getElementById('sheet-fields');
            const rollOption = document.getElementById('roll-option');
            const sheetOption = document.getElementById('sheet-option');

            if (type === 'roll') {
                rollFields.classList.add('show');
                sheetFields.classList.remove('show');
                rollOption.classList.add('active');
                sheetOption.classList.remove('active');
            } else {
                sheetFields.classList.add('show');
                rollFields.classList.remove('show');
                sheetOption.classList.add('active');
                rollOption.classList.remove('active');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const productionType = '{{ $workOrder->final_product_shape }}';
            if (productionType === 'بكر') {
                toggleProductionFields('roll');
            } else if (productionType === 'شيت') {
                toggleProductionFields('sheet');
            }
        });
    </script>
</x-app-layout>

