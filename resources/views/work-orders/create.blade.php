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

                <!-- معلومات أساسية -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">معلومات أساسية</h3>
                    
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
                </div>

                <!-- معلومات المنتج -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">معلومات المنتج</h3>
                    
                    <!-- Material and Number of Colors -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="material" class="form-label required">الخامة</label>
                        <select name="material" 
                                id="material" 
                                required
                                class="form-select">
                            <option value="">اختر الخامة</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->name }}" {{ old('material') == $material->name ? 'selected' : '' }}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="number_of_colors" class="form-label required">عدد الألوان</label>
                        <select name="number_of_colors" 
                                id="number_of_colors" 
                                required
                                class="form-select">
                            <option value="0" {{ old('number_of_colors', 0) == 0 ? 'selected' : '' }}>0</option>
                            <option value="1" {{ old('number_of_colors', 0) == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('number_of_colors', 0) == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('number_of_colors', 0) == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('number_of_colors', 0) == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('number_of_colors', 0) == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ old('number_of_colors', 0) == 6 ? 'selected' : '' }}>6</option>
                        </select>
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

                    <!-- Additions -->
                    <div class="form-group">
                        <label for="additions" class="form-label">الإضافات المطلوبة</label>
                        <select name="additions" 
                                id="additions" 
                                class="form-select">
                            <option value="">اختر الإضافة</option>
                            <option value="لا يوجد" {{ old('additions') == 'لا يوجد' ? 'selected' : '' }}>لا يوجد</option>
                            <option value="يوفي" {{ old('additions') == 'يوفي' ? 'selected' : '' }}>يوفي</option>
                            <option value="سلوفان" {{ old('additions') == 'سلوفان' ? 'selected' : '' }}>سلوفان</option>
                            <option value="سلوفان مط" {{ old('additions') == 'سلوفان مط' ? 'selected' : '' }}>سلوفان مط</option>
                        </select>
                        @error('additions')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fingerprint -->
                    <div class="form-group">
                        <label class="form-label">البصمة</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('fingerprint', 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="fingerprint" 
                                       value="no" 
                                       {{ old('fingerprint', 'no') == 'no' ? 'checked' : '' }}
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('fingerprint') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="fingerprint" 
                                       value="yes" 
                                       {{ old('fingerprint') == 'yes' ? 'checked' : '' }}
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">موجود</span>
                            </label>
                        </div>
                        @error('fingerprint')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Winding Direction -->
                    <div class="form-group">
                        <label class="form-label">اتجاه اللف</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('winding_direction', 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="no" 
                                       {{ old('winding_direction', 'no') == 'no' ? 'checked' : '' }}
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('winding_direction') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="yes" 
                                       {{ old('winding_direction') == 'yes' ? 'checked' : '' }}
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">يوجد</span>
                            </label>
                        </div>
                        @error('winding_direction')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Final Product Shape & Production Method Data -->
                <div style="margin-top: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">شكل المنتج النهائي وبيانات طريقة التشغيل</h3>
                    
                    <!-- Final Product Shape -->
                    <div class="form-group">
                        <label class="form-label">شكل المنتج النهائي</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('final_product_shape') == 'بكر' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="بكر" 
                                       id="final_product_shape_roll"
                                       {{ old('final_product_shape') == 'بكر' ? 'checked' : '' }}
                                       onchange="toggleProductionFields()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">بكر</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('final_product_shape') == 'شيت' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="شيت" 
                                       id="final_product_shape_sheet"
                                       {{ old('final_product_shape') == 'شيت' ? 'checked' : '' }}
                                       onchange="toggleProductionFields()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">شيت</span>
                            </label>
                        </div>
                        @error('final_product_shape')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Production Method Data -->
                    <div style="margin-top: 1.5rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 1rem;">بيانات طريقة التشغيل</h4>
                        
                        <!-- Roll Fields (بكر) -->
                        <div id="roll-production-fields" style="display: {{ old('final_product_shape') == 'بكر' ? 'block' : 'none' }};">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="number_of_rolls" class="form-label">عدد التكت في البكره</label>
                                    <input type="number"
                                           name="number_of_rolls"
                                           id="number_of_rolls"
                                           value="{{ old('number_of_rolls') }}"
                                           min="1"
                                           class="form-input"
                                           placeholder="أدخل عدد التكت في البكره">
                                    @error('number_of_rolls')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="core_size" class="form-label">مقاس الكور</label>
                                    <select name="core_size" 
                                            id="core_size" 
                                            class="form-select">
                                        <option value="">اختر مقاس الكور</option>
                                        <option value="76" {{ old('core_size') == '76' ? 'selected' : '' }}>76</option>
                                        <option value="40" {{ old('core_size') == '40' ? 'selected' : '' }}>40</option>
                                        <option value="25" {{ old('core_size') == '25' ? 'selected' : '' }}>25</option>
                                    </select>
                                    @error('core_size')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sheet Fields (شيت) -->
                        <div id="sheet-production-fields" style="display: {{ old('final_product_shape') == 'شيت' ? 'block' : 'none' }};">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="pieces_per_sheet" class="form-label">عدد التكت في الشيت</label>
                                    <input type="number"
                                           name="pieces_per_sheet"
                                           id="pieces_per_sheet"
                                           value="{{ old('pieces_per_sheet') }}"
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
                                           value="{{ old('sheets_per_stack') }}"
                                           min="1"
                                           class="form-input"
                                           placeholder="أدخل عدد الشيت في الراكوة">
                                    @error('sheets_per_stack')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- معلومات إضافية -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">معلومات إضافية</h3>
                    
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

    <script>
        // Handle radio button styling for fingerprint, winding_direction and final_product_shape
        document.addEventListener('DOMContentLoaded', function() {
            // Handle fingerprint radio buttons
            const fingerprintRadios = document.querySelectorAll('input[name="fingerprint"]');
            fingerprintRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const labels = document.querySelectorAll('input[name="fingerprint"]').forEach(r => {
                        const label = r.closest('label');
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    });
                });
            });

            // Handle winding_direction radio buttons
            const windingDirectionRadios = document.querySelectorAll('input[name="winding_direction"]');
            windingDirectionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const labels = document.querySelectorAll('input[name="winding_direction"]').forEach(r => {
                        const label = r.closest('label');
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    });
                });
            });

            // Handle final_product_shape radio buttons
            const shapeRadios = document.querySelectorAll('input[name="final_product_shape"]');
            shapeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const labels = document.querySelectorAll('input[name="final_product_shape"]').forEach(r => {
                        const label = r.closest('label');
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    });
                    toggleProductionFields();
                });
            });

            // Initialize production fields on page load
            toggleProductionFields();
        });

        // Toggle production fields based on final_product_shape selection
        function toggleProductionFields() {
            const rollRadio = document.getElementById('final_product_shape_roll');
            const sheetRadio = document.getElementById('final_product_shape_sheet');
            const rollFields = document.getElementById('roll-production-fields');
            const sheetFields = document.getElementById('sheet-production-fields');

            if (rollRadio && rollRadio.checked) {
                if (rollFields) rollFields.style.display = 'block';
                if (sheetFields) sheetFields.style.display = 'none';
            } else if (sheetRadio && sheetRadio.checked) {
                if (rollFields) rollFields.style.display = 'none';
                if (sheetFields) sheetFields.style.display = 'block';
            } else {
                if (rollFields) rollFields.style.display = 'none';
                if (sheetFields) sheetFields.style.display = 'none';
            }
        }
    </script>
</x-app-layout>




