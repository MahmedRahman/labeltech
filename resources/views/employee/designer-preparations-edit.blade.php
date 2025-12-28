<x-app-layout>
    @php
        $title = 'تعديل التجهيزات';
    @endphp

    <style>
        .card {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .radio-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #2563eb;
        }

        .radio-label {
            font-size: 1rem;
            color: #374151;
            cursor: pointer;
            user-select: none;
        }

        .radio-item:hover .radio-label {
            color: #2563eb;
        }

        .info-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: #f3f4f6;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        .calculate-btn {
            padding: 0.75rem 1rem;
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .calculate-btn:hover {
            background-color: #059669;
        }

        .formula-info {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background-color: #f9fafb;
            border-radius: 0.375rem;
            border-right: 3px solid #10b981;
        }
    </style>

    <script>
        function calculateGap() {
            // D = الدرايفيل (designer_drills) - يجب أن يكون رقم
            const drillsInput = document.getElementById('designer_drills');
            const drillsValueStr = drillsInput.value.trim();
            
            // استخراج الرقم من النص (في حالة وجود نص)
            const drillsMatch = drillsValueStr.match(/[\d.]+/);
            if (!drillsMatch) {
                alert('يرجى إدخال الدرايفيل بشكل صحيح (يجب أن يحتوي على رقم)');
                drillsInput.focus();
                return;
            }
            
            const drillsValue = parseFloat(drillsMatch[0]);
            
            // L = الطول (length)
            const lengthValue = parseFloat({{ $workOrder->length ?? 0 }});
            
            // التحقق من وجود القيم
            if (!drillsValue || isNaN(drillsValue) || drillsValue <= 0) {
                alert('يرجى إدخال الدرايفيل أولاً');
                drillsInput.focus();
                return;
            }
            
            if (!lengthValue || isNaN(lengthValue) || lengthValue <= 0) {
                alert('الطول غير محدد في الطلب');
                return;
            }
            
            // الصيغة: Gap = [ (3.175 × D / 10) ÷ INT( 3.175 × D ÷ ( (L + 0.2) × 10 ) ) − L ] × 10
            const D = drillsValue;
            const L = lengthValue;
            
            // حساب: (L + 0.2) × 10
            const denominator = (L + 0.2) * 10;
            
            // حساب: 3.175 × D ÷ ( (L + 0.2) × 10 )
            const divisionResult = (3.175 * D) / denominator;
            
            // INT(3.175 × D ÷ ( (L + 0.2) × 10 ))
            const intPart = Math.floor(divisionResult);
            
            if (intPart === 0) {
                alert('لا يمكن حساب الجاب: القيمة المحسوبة صفر');
                return;
            }
            
            // حساب: 3.175 × D / 10
            const numerator = (3.175 * D) / 10;
            
            // حساب: (3.175 × D / 10) ÷ INT(...)
            const division = numerator / intPart;
            
            // حساب: [ ... ] − L
            const subtraction = division - L;
            
            // حساب: [ ... ] × 10
            const gap = subtraction * 10;
            
            // تحديث قيمة الحقل
            const gapInput = document.getElementById('designer_gap');
            gapInput.value = gap.toFixed(2);
        }
        
        // حساب تلقائي عند تغيير الدرايفيل
        document.addEventListener('DOMContentLoaded', function() {
            const drillsInput = document.getElementById('designer_drills');
            if (drillsInput) {
                drillsInput.addEventListener('blur', function() {
                    const gapInput = document.getElementById('designer_gap');
                    if (!gapInput.value || gapInput.value === '') {
                        calculateGap();
                    }
                });
            }
        });
    </script>

    <!-- Header -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تعديل التجهيزات</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">رقم عرض السعر: {{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <a href="{{ route('employee.designer.preparations.show', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
            <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة
        </a>
    </div>

    <!-- معلومات أساسية -->
    <div class="card">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات أساسية</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 2rem;">
            <!-- Row 1 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">اسم الشغلانة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->job_name ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">أمر الشغل:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 600;">{{ $workOrder->order_number ?? 'بدون رقم' }}</span>
            </div>
            
            <!-- Row 2 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">التاريخ:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->created_at->format('d/m/Y') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">أسم العميل:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->client->name ?? 'غير محدد' }}</span>
            </div>
            
            <!-- Row 3 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">العرض:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->width ? number_format($workOrder->width, 1) : '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الطول:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->length ? number_format($workOrder->length, 1) : '-' }}</span>
            </div>
            
            <!-- Row 4 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">نوع الخامة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->material ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الاضافات:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->additions ?? 'لا يوجد' }}</span>
            </div>
            
            <!-- Row 5 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الكمية:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ number_format($workOrder->quantity) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">عدد الألوان:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->number_of_colors ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="card">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #8b5cf6;">
            <svg style="width: 24px; height: 24px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">تجهيزات المصمم</h3>
        </div>

        <form action="{{ route('employee.designer.preparations.update', $workOrder) }}" method="POST">
            @csrf

            <!-- Designer Number of Colors -->
            <div class="form-group">
                <label class="form-label">عدد الألوان (تجهيزات المصمم)</label>
                <span class="info-badge">عدد الألوان الأصلي: <strong>{{ $workOrder->number_of_colors ?? '-' }}</strong></span>
                <div class="radio-group">
                    @for($i = 1; $i <= 6; $i++)
                        <div class="radio-item">
                            <input 
                                type="radio" 
                                id="designer_number_of_colors_{{ $i }}" 
                                name="designer_number_of_colors" 
                                class="radio-input" 
                                value="{{ $i }}"
                                {{ old('designer_number_of_colors', $workOrder->designer_number_of_colors) == $i ? 'checked' : '' }}
                            >
                            <label for="designer_number_of_colors_{{ $i }}" class="radio-label">{{ $i }}</label>
                        </div>
                    @endfor
                </div>
                @error('designer_number_of_colors')
                    <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Designer Drills -->
            <div class="form-group">
                <label for="designer_drills" class="form-label">الدرايفيل (تجهيزات المصمم)</label>
                <input 
                    type="text" 
                    id="designer_drills" 
                    name="designer_drills" 
                    class="form-input" 
                    value="{{ old('designer_drills', $workOrder->designer_drills) }}"
                    placeholder="الدرايفيل الأصلي: {{ $workOrder->design_drills ?? '-' }}"
                >
                <span class="info-badge">الدرايفيل الأصلي: {{ $workOrder->design_drills ?? '-' }}</span>
                @error('designer_drills')
                    <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Designer Breaking Gear -->
            <div class="form-group">
                <label for="designer_breaking_gear" class="form-label">ترس التكسير (تجهيزات المصمم)</label>
                <input 
                    type="text" 
                    id="designer_breaking_gear" 
                    name="designer_breaking_gear" 
                    class="form-input" 
                    value="{{ old('designer_breaking_gear', $workOrder->designer_breaking_gear) }}"
                    placeholder="ترس التكسير الأصلي: {{ $workOrder->design_breaking_gear ?? '-' }}"
                >
                <span class="info-badge">ترس التكسير الأصلي: {{ $workOrder->design_breaking_gear ?? '-' }}</span>
                @error('designer_breaking_gear')
                    <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Designer Paper Width -->
            <div class="form-group">
                <label for="designer_paper_width" class="form-label">عرض الورق (سم) - تجهيزات المصمم</label>
                <input 
                    type="number" 
                    id="designer_paper_width" 
                    name="designer_paper_width" 
                    class="form-input" 
                    value="{{ old('designer_paper_width', $workOrder->designer_paper_width) }}"
                    min="0"
                    max="20"
                    step="0.01"
                    placeholder="عرض الورق الأصلي: {{ $workOrder->paper_width ? number_format($workOrder->paper_width, 2) : '-' }} سم"
                >
                <span class="info-badge">عرض الورق الأصلي: {{ $workOrder->paper_width ? number_format($workOrder->paper_width, 2) : '-' }} سم</span>
                @error('designer_paper_width')
                    <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Designer Gap (الجاب الدرافيل) -->
            <div class="form-group">
                <label for="designer_gap" class="form-label">الجاب الدرافيل (تجهيزات المصمم)</label>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <input 
                        type="number" 
                        id="designer_gap" 
                        name="designer_gap" 
                        class="form-input" 
                        value="{{ old('designer_gap', $workOrder->designer_gap) }}"
                        min="0"
                        step="0.01"
                        placeholder="سيتم الحساب تلقائياً"
                        style="flex: 1;"
                    >
                    <button 
                        type="button" 
                        id="calculateGapBtn" 
                        class="calculate-btn"
                        onclick="calculateGap()"
                    >
                        <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        حساب تلقائي
                    </button>
                </div>
                <div class="formula-info">
                    <strong>الصيغة:</strong> [ (3.175 × D / 10) ÷ INT( 3.175 × D ÷ ( (L + 0.2) × 10 ) ) − L ] × 10
                    <br>
                    <strong>حيث:</strong> D = الدرايفيل، L = الطول
                </div>
                @error('designer_gap')
                    <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('employee.designer.preparations.show', $workOrder) }}" class="btn btn-secondary">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
