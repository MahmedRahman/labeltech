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
                    
                    <!-- النوع -->
                    <div class="form-group">
                        <label for="type" class="form-label required">النوع</label>
                        <select name="type" 
                                id="type" 
                                class="form-select"
                                required>
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
                        
                        <!-- عرض الكود التلقائي -->
                        <div id="knife_code_display" style="margin-top: 0.75rem; padding: 0.75rem; background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.375rem; display: none;">
                            <div style="font-size: 0.75rem; font-weight: 500; color: #1e40af; margin-bottom: 0.25rem;">الرقم الكود التلقائي:</div>
                            <div style="font-size: 1rem; font-weight: 600; color: #1e3a8a; font-family: monospace;" id="knife_code_value">-</div>
                        </div>
                    </div>

                    <!-- الرقم الكود (مخفي في واجهة المستخدم) -->
                    <input type="hidden" name="knife_code" id="knife_code" value="{{ old('knife_code') }}">

                    <!-- العرض والطول وعدد العيون وعدد الصفوف -->
                    <div class="form-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="form-group">
                            <label for="width" class="form-label required">العرض</label>
                            <input type="number" 
                                   name="width" 
                                   id="width" 
                                   value="{{ old('width') }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   required
                                   placeholder="أدخل العرض">
                            @error('width')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="length" class="form-label required">الطول</label>
                            <input type="number" 
                                   name="length" 
                                   id="length" 
                                   value="{{ old('length') }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   required
                                   placeholder="أدخل الطول">
                            @error('length')
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
                                   step="1"
                                   class="form-input"
                                   placeholder="أدخل عدد العيون">
                            @error('eyes_count')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rows_count" class="form-label">عدد الصفوف</label>
                            <input type="number" 
                                   name="rows_count" 
                                   id="rows_count" 
                                   value="{{ old('rows_count') }}" 
                                   min="0"
                                   step="1"
                                   class="form-input"
                                   placeholder="أدخل عدد الصفوف">
                            @error('rows_count')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- درافيل وتُرس -->
                    <div class="form-grid" style="grid-template-columns: repeat(2, 1fr);">
                        <div class="form-group">
                            <label for="dragile_drive" class="form-label required">درافيل</label>
                            <input type="number" 
                                   name="dragile_drive" 
                                   id="dragile_drive" 
                                   value="{{ old('dragile_drive') }}" 
                                   class="form-input"
                                   step="0.01"
                                   min="0"
                                   max="999"
                                   required
                                   maxlength="3"
                                   placeholder="أدخل درافيل (حد أقصى 3 أرقام)">
                            @error('dragile_drive')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gear" class="form-label">تُرس</label>
                            <input type="number" 
                                   name="gear" 
                                   id="gear" 
                                   value="{{ old('gear') }}" 
                                   class="form-input"
                                   min="0"
                                   max="999"
                                   maxlength="3"
                                   placeholder="أدخل تُرس (حد أقصى 3 أرقام)">
                            @error('gear')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- الجاب (محسوب تلقائياً) -->
                    <div class="form-group">
                        <label for="flap_size" class="form-label">الجاب</label>
                        <input type="number" 
                               name="flap_size" 
                               id="flap_size" 
                               value="{{ old('flap_size') }}" 
                               class="form-input"
                               readonly
                               style="background-color: #f3f4f6; cursor: not-allowed;"
                               placeholder="سيتم الحساب تلقائياً"
                               step="0.001">
                        <small style="display: block; margin-top: 0.5rem; font-size: 0.75rem; color: #6b7280;">
                            يتم الحساب تلقائياً من درافيل والطول
                        </small>
                        @error('flap_size')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const knifeCodeInput = document.getElementById('knife_code');
            const dragileDriveInput = document.getElementById('dragile_drive');
            const lengthInput = document.getElementById('length');
            const flapSizeInput = document.getElementById('flap_size');
            const gearInput = document.getElementById('gear');

            // Limit dragile_drive and gear to max 3 digits
            function limitToThreeDigits(input) {
                input.addEventListener('input', function() {
                    let value = this.value;
                    // Remove any non-digit characters except decimal point
                    if (this.id === 'dragile_drive') {
                        // For dragile_drive, allow decimals
                        value = value.replace(/[^\d.]/g, '');
                        // Ensure only one decimal point
                        const parts = value.split('.');
                        if (parts.length > 2) {
                            value = parts[0] + '.' + parts.slice(1).join('');
                        }
                        // Limit integer part to 3 digits
                        if (parts[0] && parts[0].length > 3) {
                            value = parts[0].substring(0, 3) + (parts[1] ? '.' + parts[1] : '');
                        }
                    } else {
                        // For gear, only integers
                        value = value.replace(/\D/g, '');
                        if (value.length > 3) {
                            value = value.substring(0, 3);
                        }
                    }
                    // Ensure max value is 999
                    if (parseFloat(value) > 999) {
                        value = '999';
                    }
                    this.value = value;
                });
            }

            limitToThreeDigits(dragileDriveInput);
            limitToThreeDigits(gearInput);

            // Function to calculate الجاب (flap_size)
            function calculateFlapSize() {
                const dragileDrive = parseFloat(dragileDriveInput.value) || 0;
                const length = parseFloat(lengthInput.value) || 0;

                if (dragileDrive > 0 && length > 0) {
                    // Formula: (((3.175*A2/10)/INT(3.175*A2/(B2+0.2)/10))-B2)*10
                    // Where A2 = dragileDrive, B2 = length
                    const numerator = (3.175 * dragileDrive / 10);
                    const denominator = Math.floor(3.175 * dragileDrive / (length + 0.2) / 10);
                    
                    if (denominator !== 0) {
                        const result = ((numerator / denominator) - length) * 10;
                        flapSizeInput.value = result.toFixed(3);
                    } else {
                        flapSizeInput.value = '';
                    }
                } else {
                    flapSizeInput.value = '';
                }
            }

            // Add event listeners for automatic calculation
            dragileDriveInput.addEventListener('input', calculateFlapSize);
            dragileDriveInput.addEventListener('change', calculateFlapSize);
            lengthInput.addEventListener('input', calculateFlapSize);
            lengthInput.addEventListener('change', calculateFlapSize);

            // Calculate on page load if values exist
            if (dragileDriveInput.value && lengthInput.value) {
                calculateFlapSize();
            }

            typeSelect.addEventListener('change', function() {
                const type = this.value;
                const codeDisplay = document.getElementById('knife_code_display');
                const codeValue = document.getElementById('knife_code_value');
                
                if (type) {
                    // Fetch next knife code from server
                    fetch(`{{ route('knives.get-next-code') }}?type=${encodeURIComponent(type)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.knife_code) {
                                knifeCodeInput.value = data.knife_code;
                                codeValue.textContent = data.knife_code;
                                codeDisplay.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching knife code:', error);
                            codeDisplay.style.display = 'none';
                        });
                } else {
                    knifeCodeInput.value = '';
                    codeDisplay.style.display = 'none';
                }
            });

            // Trigger on page load if type is already selected
            if (typeSelect.value) {
                typeSelect.dispatchEvent(new Event('change'));
            } else if (knifeCodeInput.value) {
                // If knife code exists from old input, display it
                const codeDisplay = document.getElementById('knife_code_display');
                const codeValue = document.getElementById('knife_code_value');
                if (codeDisplay && codeValue) {
                    codeValue.textContent = knifeCodeInput.value;
                    codeDisplay.style.display = 'block';
                }
            }
        });
    </script>
</x-app-layout>
