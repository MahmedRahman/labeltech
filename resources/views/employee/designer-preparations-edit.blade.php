<x-app-layout>
    @php
        $title = 'تعديل التجهيزات';
    @endphp

    <style>
        .form-container {
            background: white;
            border-radius: 0.75rem;
            padding: 2rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
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
    </style>

    <!-- Header -->
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تعديل التجهيزات</h2>
        <p style="font-size: 1rem; color: #6b7280; margin: 0;">رقم عرض السعر: {{ $workOrder->order_number ?? 'بدون رقم' }}</p>
    </div>

    <!-- Form -->
    <div class="form-container">
        <form action="{{ route('employee.designer.preparations.update', $workOrder) }}" method="POST">
            @csrf

            <!-- Designer Number of Colors -->
            <div class="form-group">
                <label for="designer_number_of_colors" class="form-label">عدد الألوان (تجهيزات المصمم)</label>
                <input 
                    type="number" 
                    id="designer_number_of_colors" 
                    name="designer_number_of_colors" 
                    class="form-input" 
                    value="{{ old('designer_number_of_colors', $workOrder->designer_number_of_colors) }}"
                    min="1"
                    step="1"
                    placeholder="عدد الألوان الأصلي: {{ $workOrder->number_of_colors ?? '-' }}"
                >
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
                @error('designer_paper_width')
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

