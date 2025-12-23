<x-app-layout>
    @php
        $title = 'إضافة أمر شغل جديد';
    @endphp

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        .page-wrapper {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }


        /* Select2 styling for client and material fields */
        #client_id + .select2-container,
        #material + .select2-container {
            width: 100% !important;
            direction: rtl;
            margin-bottom: 0.5rem;
        }
        
        #client_id + .select2-container .select2-selection--single,
        #material + .select2-container .select2-selection--single {
            height: 56px !important;
            border: 2px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0 !important;
            font-size: 1rem !important;
            line-height: 1.5 !important;
            direction: rtl !important;
            background-color: white !important;
            transition: all 0.2s ease !important;
        }
        
        #client_id + .select2-container .select2-selection--single:hover,
        #material + .select2-container .select2-selection--single:hover {
            border-color: #9ca3af !important;
        }
        
        #client_id + .select2-container.select2-container--focus .select2-selection--single,
        #material + .select2-container.select2-container--focus .select2-selection--single {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
            outline: none !important;
        }
        
        #client_id + .select2-container .select2-selection--single .select2-selection__rendered,
        #material + .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 56px !important;
            padding-right: 1rem !important;
            padding-left: 3rem !important;
            font-size: 1rem !important;
            font-weight: 500 !important;
            text-align: right !important;
            color: #111827 !important;
        }
        
        #client_id + .select2-container .select2-selection--single .select2-selection__placeholder,
        #material + .select2-container .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
            font-weight: 400 !important;
        }
        
        #client_id + .select2-container .select2-selection--single .select2-selection__arrow,
        #material + .select2-container .select2-selection--single .select2-selection__arrow {
            height: 54px !important;
            right: auto !important;
            left: 12px !important;
            width: 20px !important;
        }
        
        #client_id + .select2-container .select2-selection--single .select2-selection__arrow b,
        #material + .select2-container .select2-selection--single .select2-selection__arrow b {
            border-color: #6b7280 transparent transparent transparent !important;
            border-width: 6px 6px 0 6px !important;
            margin-top: -3px !important;
        }
        
        #client_id + .select2-container.select2-container--open .select2-selection--single .select2-selection__arrow b,
        #material + .select2-container.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6b7280 transparent !important;
            border-width: 0 6px 6px 6px !important;
            margin-top: -9px !important;
        }
        
        .select2-dropdown {
            direction: rtl !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            margin-top: 0.25rem !important;
        }
        
        .select2-search--dropdown {
            padding: 0.75rem !important;
            border-bottom: 1px solid #e5e7eb !important;
        }
        
        .select2-search--dropdown .select2-search__field {
            direction: rtl !important;
            padding: 0.625rem 0.875rem !important;
            font-size: 1rem !important;
            border: 2px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            width: 100% !important;
            outline: none !important;
            font-family: inherit !important;
        }
        
        .select2-search--dropdown .select2-search__field:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
        }
        
        .select2-search--dropdown .select2-search__field::placeholder {
            color: #9ca3af !important;
            font-size: 0.875rem !important;
        }
        
        .select2-results__options {
            max-height: 300px !important;
            overflow-y: auto !important;
        }
        
        .select2-results__option {
            padding: 0.875rem 1rem !important;
            font-size: 1rem !important;
            direction: rtl !important;
            text-align: right !important;
            transition: all 0.15s ease !important;
        }
        
        .select2-results__option--highlighted {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }
        
        .select2-results__option[aria-selected="true"] {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            font-weight: 600 !important;
        }
        
        .select2-results__option--highlighted[aria-selected="true"] {
            background-color: #2563eb !important;
            color: white !important;
        }
        
        .select2-results__message {
            padding: 0.875rem 1rem !important;
            font-size: 0.875rem !important;
            color: #6b7280 !important;
            text-align: right !important;
        }

        .form-container {
            flex: 1;
            min-width: 0;
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
        
        /* Client select field specific styling */
        .form-group:has(#client_id) .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
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
        
        @media (max-width: 1024px) {
            .page-wrapper {
                flex-direction: column;
            }
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

    <div class="page-wrapper">
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
                    
                    <!-- Order Number (hidden, auto-generated) -->
                    <input type="hidden" 
                           name="order_number" 
                           id="order_number" 
                           value="{{ old('order_number') }}">
                    @error('order_number')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                    <!-- Client Selection -->
                    <div class="form-group">
                        <label for="client_id" class="form-label required">العميل</label>
                        <select name="client_id" id="client_id" required class="form-select client-select">
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

                    <!-- Job Name -->
                    <div class="form-group">
                        <label for="job_name" class="form-label">اسم الشغلانه</label>
                        <input type="text" 
                               name="job_name" 
                               id="job_name" 
                               value="{{ old('job_name') }}" 
                               class="form-input"
                               placeholder="أدخل اسم الشغلانه">
                        @error('job_name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status (hidden) -->
                    <div class="form-group" style="display: none;">
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

                    <!-- Sent to Client (Hidden - default value is 'no') -->
                    <input type="hidden" name="sent_to_client" value="no">
                </div>

                <!-- معلومات المنتج -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">معلومات المنتج</h3>
                    
                    <!-- Number of Colors -->
                    <div class="form-group">
                        <label class="form-label required">عدد الألوان</label>
                        <div style="display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            @for($i = 0; $i <= 6; $i++)
                            <label class="number-of-colors-card" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; padding: 1rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; min-width: 60px; text-align: center;">
                                <input type="radio" 
                                       name="number_of_colors" 
                                       value="{{ $i }}" 
                                       id="number_of_colors_{{ $i }}"
                                       {{ old('number_of_colors', 4) == $i ? 'checked' : '' }}
                                       required
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 1rem; font-weight: 600; color: #111827;">{{ $i }}</span>
                            </label>
                            @endfor
                        </div>
                        @error('number_of_colors')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Material -->
                    <div class="form-group">
                        <label for="material" class="form-label required">الخامة</label>
                        <select name="material" 
                                id="material" 
                                required
                                class="form-select client-select">
                            <option value="">اختر الخامة</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->name }}" 
                                        data-price="{{ $material->price ?? '' }}" 
                                        {{ old('material') == $material->name ? 'selected' : '' }}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
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

                <!-- Rows Count -->
                <div class="form-group">
                    <label class="form-label">عدد الصفوف</label>
                    <div style="display: flex; gap: 0.75rem; margin-top: 0.5rem; flex-wrap: wrap;">
                        @for($i = 1; $i <= 15; $i++)
                        <label class="rows-count-card" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; padding: 0.875rem 1.25rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; min-width: 50px; text-align: center;">
                            <input type="radio" 
                                   name="rows_count" 
                                   value="{{ $i }}" 
                                   id="rows_count_{{ $i }}"
                                   {{ old('rows_count', 1) == $i ? 'checked' : '' }}
                                   style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                            <span style="font-size: 0.9375rem; font-weight: 600; color: #111827;">{{ $i }}</span>
                        </label>
                        @endfor
                    </div>
                    @error('rows_count')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Paper Width (calculated automatically, hidden) -->
                <input type="hidden" 
                       name="paper_width" 
                       id="paper_width" 
                       value="{{ old('paper_width') }}">
                @error('paper_width')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <!-- Gap Count, Waste Per Roll and Increase -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="gap_count" class="form-label">عدد الجاب</label>
                        <input type="number" 
                               name="gap_count" 
                               id="gap_count" 
                               value="{{ old('gap_count', 0.4) }}" 
                               min="0"
                               step="0.01"
                               class="form-input"
                               placeholder="أدخل عدد الجاب"
                               oninput="calculateLinearMeter()">
                        @error('gap_count')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="waste_per_roll" class="form-label">عدد الهالك للبكره</label>
                        <input type="number" 
                               name="waste_per_roll" 
                               id="waste_per_roll" 
                               value="{{ old('waste_per_roll', 20) }}" 
                               min="0"
                               step="1"
                               class="form-input"
                               placeholder="أدخل عدد الهالك للبكره">
                        @error('waste_per_roll')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Increase field (hidden) -->
                    <input type="hidden" 
                           name="increase" 
                           id="increase" 
                           value="{{ old('increase', 0) }}">
                    @error('increase')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Linear Meter (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="linear_meter" 
                       id="linear_meter" 
                       value="{{ old('linear_meter') }}">
                @error('linear_meter')
                    <p class="error-message">{{ $message }}</p>
                @enderror

                <!-- Rolls Count (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="rolls_count" 
                       id="rolls_count" 
                       value="{{ old('rolls_count') }}">

                <!-- Waste (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="waste" 
                       id="waste" 
                       value="{{ old('waste') }}">

                <!-- Waste Percentage (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="waste_percentage" 
                       id="waste_percentage" 
                       value="{{ old('waste_percentage') }}">

                <!-- Linear Meter with Waste (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="linear_meter_with_waste" 
                       id="linear_meter_with_waste" 
                       value="{{ old('linear_meter_with_waste') }}">

                <!-- Square Meter (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="square_meter" 
                       id="square_meter" 
                       value="{{ old('square_meter') }}">

                <!-- Total Prices Sum (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="total_prices_sum" 
                       id="total_prices_sum" 
                       value="{{ old('total_prices_sum') }}">

                <!-- Total Amount (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="total_amount" 
                       id="total_amount" 
                       value="{{ old('total_amount') }}">

                <!-- Total Order (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="total_order" 
                       id="total_order" 
                       value="{{ old('total_order') }}">

                <!-- Price Per Thousand (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="price_per_thousand" 
                       id="price_per_thousand" 
                       value="{{ old('price_per_thousand') }}">

                <!-- Total Preparations (calculated automatically, hidden, shown in sidebar) -->
                <input type="hidden" 
                       name="total_preparations" 
                       id="total_preparations" 
                       value="{{ old('total_preparations') }}">

                <!-- التجهيزات والإضافات -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">التجهيزات والإضافات</h3>
                    
                    <!-- العدد -->
                    <div class="form-group">
                        <label class="form-label">العدد</label>
                        <div style="display: flex; gap: 0.75rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            @for($i = 1; $i <= 6; $i++)
                            <label style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; padding: 0.875rem 1.25rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; min-width: 50px; text-align: center; {{ old('film_count') == $i ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="film_count" 
                                       value="{{ $i }}" 
                                       id="film_count_{{ $i }}"
                                       {{ old('film_count') == $i ? 'checked' : '' }}
                                       onchange="updateFilmCountStyle()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.9375rem; font-weight: 600; color: #111827;">{{ $i }}</span>
                            </label>
                            @endfor
                        </div>
                        @error('film_count')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- سعر الفيلم الواحد -->
                    <div class="form-group">
                        <label for="film_price" class="form-label">سعر الفيلم الواحد</label>
                        <input type="number" 
                               name="film_price" 
                               id="film_price" 
                               value="{{ old('film_price', 850) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00">
                        @error('film_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sales Percentage -->
                    <div class="form-group">
                        <label for="sales_percentage" class="form-label">نسبة المبيعات</label>
                        <input type="number" 
                               name="sales_percentage" 
                               id="sales_percentage" 
                               value="{{ old('sales_percentage', 10) }}" 
                               step="0.01"
                               min="0"
                               max="100"
                               class="form-input"
                               placeholder="0.00">
                        @error('sales_percentage')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additions -->
                    <div class="form-group">
                        <label class="form-label">الإضافات المطلوبة</label>
                        <div style="display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('additions', 'لا يوجد') == 'لا يوجد' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="additions" 
                                       value="لا يوجد" 
                                       data-price="0"
                                       {{ old('additions', 'لا يوجد') == 'لا يوجد' ? 'checked' : '' }}
                                       onchange="updateAdditionPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            @foreach($additions as $addition)
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('additions') == $addition->name ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="additions" 
                                       value="{{ $addition->name }}" 
                                       data-price="{{ $addition->price }}"
                                       {{ old('additions') == $addition->name ? 'checked' : '' }}
                                       onchange="updateAdditionPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">{{ $addition->name }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('additions')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Addition Price (shown when addition is selected) -->
                    <div id="addition_price_group" class="form-group" style="display: {{ old('additions', 'لا يوجد') != 'لا يوجد' ? 'block' : 'none' }};">
                        <label for="addition_price" class="form-label">سعر الإضافة</label>
                        <input type="number" 
                               name="addition_price" 
                               id="addition_price" 
                               value="{{ old('addition_price') }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               required>
                        <input type="hidden" id="addition_min_price" value="0">
                        <p id="addition_price_hint" style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem; margin-bottom: 0;">
                            السعر الأدنى: <span id="addition_min_price_display">0.00</span> ج.م
                        </p>
                        @error('addition_price')
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
                                       id="fingerprint_no"
                                       {{ old('fingerprint', 'no') == 'no' ? 'checked' : '' }}
                                       onchange="toggleFingerprintPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('fingerprint') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="fingerprint" 
                                       value="yes" 
                                       id="fingerprint_yes"
                                       {{ old('fingerprint') == 'yes' ? 'checked' : '' }}
                                       onchange="toggleFingerprintPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">موجود</span>
                            </label>
                        </div>
                        @error('fingerprint')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fingerprint Price (shown when fingerprint is yes) -->
                    <div id="fingerprint_price_group" class="form-group" style="display: {{ old('fingerprint') == 'yes' ? 'block' : 'none' }};">
                        <label for="fingerprint_price" class="form-label">سعر البصمة</label>
                        <input type="number" 
                               name="fingerprint_price" 
                               id="fingerprint_price" 
                               value="{{ old('fingerprint_price', 16) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               {{ old('fingerprint') == 'yes' ? 'required' : '' }}>
                        @error('fingerprint_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Winding Direction -->
                    <div class="form-group">
                        <label class="form-label">اتجاه اللف</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ !in_array(old('winding_direction'), ['clockwise', 'counterclockwise']) ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="no" 
                                       id="winding_direction_no"
                                       {{ !in_array(old('winding_direction'), ['clockwise', 'counterclockwise']) ? 'checked' : '' }}
                                       onchange="toggleWindingDirectionOptions()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ in_array(old('winding_direction'), ['clockwise', 'counterclockwise']) ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="yes" 
                                       id="winding_direction_yes"
                                       {{ in_array(old('winding_direction'), ['clockwise', 'counterclockwise']) ? 'checked' : '' }}
                                       onchange="toggleWindingDirectionOptions()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">يوجد</span>
                            </label>
                        </div>
                        
                        <!-- Winding Direction Options (shown when "يوجد" is selected) -->
                        <div id="winding_direction_options" style="display: {{ in_array(old('winding_direction'), ['clockwise', 'counterclockwise']) ? 'flex' : 'none' }}; gap: 2rem; margin-top: 1rem; padding-right: 1.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('winding_direction') == 'clockwise' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="clockwise" 
                                       id="winding_direction_clockwise"
                                       {{ old('winding_direction') == 'clockwise' ? 'checked' : '' }}
                                       onchange="handleWindingDirectionChange()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">في اتجاه عقارب الساعة</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('winding_direction') == 'counterclockwise' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="counterclockwise" 
                                       id="winding_direction_counterclockwise"
                                       {{ old('winding_direction') == 'counterclockwise' ? 'checked' : '' }}
                                       onchange="handleWindingDirectionChange()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">عكس عقارب الساعة</span>
                            </label>
                        </div>
                        @error('winding_direction')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Knife Exists -->
                    <div class="form-group">
                        <label class="form-label">السكينة</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('knife_exists', 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="knife_exists" 
                                       value="no" 
                                       id="knife_exists_no"
                                       {{ old('knife_exists', 'no') == 'no' ? 'checked' : '' }}
                                       onchange="toggleKnifePrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('knife_exists') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="knife_exists" 
                                       value="yes" 
                                       id="knife_exists_yes"
                                       {{ old('knife_exists') == 'yes' ? 'checked' : '' }}
                                       onchange="toggleKnifePrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">يوجد</span>
                            </label>
                        </div>
                        @error('knife_exists')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Knife Price (shown when knife_exists is yes) -->
                    <div id="knife_price_group" class="form-group" style="display: {{ old('knife_exists') == 'yes' ? 'block' : 'none' }};">
                        <label for="knife_price" class="form-label">سعر السكينة</label>
                        <input type="number" 
                               name="knife_price" 
                               id="knife_price" 
                               value="{{ old('knife_price', 600) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               {{ old('knife_exists') == 'yes' ? 'required' : '' }}>
                        @error('knife_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- External Breaking -->
                    <div class="form-group">
                        <label class="form-label">التكسير الخارجي</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('external_breaking', 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="external_breaking" 
                                       value="no" 
                                       id="external_breaking_no"
                                       {{ old('external_breaking', 'no') == 'no' ? 'checked' : '' }}
                                       onchange="toggleExternalBreakingPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('external_breaking') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="external_breaking" 
                                       value="yes" 
                                       id="external_breaking_yes"
                                       {{ old('external_breaking') == 'yes' ? 'checked' : '' }}
                                       onchange="toggleExternalBreakingPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">يوجد</span>
                            </label>
                        </div>
                        @error('external_breaking')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- External Breaking Price (shown when external_breaking is yes) -->
                    <div id="external_breaking_price_group" class="form-group" style="display: {{ old('external_breaking') == 'yes' ? 'block' : 'none' }};">
                        <label for="external_breaking_price" class="form-label">سعر التكسير الخارجي</label>
                        <input type="number" 
                               name="external_breaking_price" 
                               id="external_breaking_price" 
                               value="{{ old('external_breaking_price', $externalBreakingPrice ?? 4) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               data-default-price="{{ $externalBreakingPrice ?? 4 }}"
                               {{ old('external_breaking') == 'yes' ? 'required' : '' }}>
                        @error('external_breaking_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Material and Manufacturing Prices -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="material_price_per_meter" class="form-label">سعر المتر الخامة</label>
                            <input type="number" 
                                   name="material_price_per_meter" 
                                   id="material_price_per_meter" 
                                   value="{{ old('material_price_per_meter') }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="0.00">
                            @error('material_price_per_meter')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="manufacturing_price_per_meter" class="form-label">سعر متر التصنيع</label>
                            <input type="number" 
                                   name="manufacturing_price_per_meter" 
                                   id="manufacturing_price_per_meter" 
                                   value="{{ old('manufacturing_price_per_meter', 10) }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="0.00">
                            @error('manufacturing_price_per_meter')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Final Product Shape & Production Method Data -->
                <div style="margin-top: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">شكل المنتج النهائي وبيانات طريقة التشغيل</h3>
                    
                    <!-- Final Product Shape -->
                    <div class="form-group">
                        <label class="form-label">شكل المنتج النهائي</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('final_product_shape', 'بكر') == 'بكر' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="بكر" 
                                       id="final_product_shape_roll"
                                       {{ old('final_product_shape', 'بكر') == 'بكر' ? 'checked' : '' }}
                                       onchange="toggleProductionFields()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">بكر</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('final_product_shape', 'بكر') == 'شيت' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="شيت" 
                                       id="final_product_shape_sheet"
                                       {{ old('final_product_shape', 'بكر') == 'شيت' ? 'checked' : '' }}
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
                        <div id="roll-production-fields" style="display: {{ old('final_product_shape', 'بكر') == 'بكر' ? 'block' : 'none' }};">
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
                                    <label class="form-label">مقاس الكور</label>
                                    <div style="display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                                        @php
                                            $coreSizes = [76, 40, 25];
                                            $selectedCoreSize = old('core_size');
                                        @endphp
                                        @foreach($coreSizes as $size)
                                            <label class="number-of-colors-card" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; padding: 1rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; min-width: 60px; text-align: center;">
                                                <input type="radio" 
                                                       name="core_size" 
                                                       value="{{ $size }}" 
                                                       id="core_size_{{ $size }}"
                                                       {{ $selectedCoreSize == $size ? 'checked' : '' }}
                                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                                <span style="font-size: 1rem; font-weight: 600; color: #111827;">{{ $size }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('core_size')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sheet Fields (شيت) -->
                        <div id="sheet-production-fields" style="display: {{ old('final_product_shape', 'بكر') == 'شيت' ? 'block' : 'none' }};">
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
    </div>

    <script>
        // Waste percentages data from database
        const wastePercentages = {
            @foreach($wastes as $waste)
            {{ $waste->number_of_colors }}: {{ $waste->waste_percentage }},
            @endforeach
        };

        // Handle radio button styling for additions, fingerprint, winding_direction and final_product_shape
        document.addEventListener('DOMContentLoaded', function() {
            // Handle additions radio buttons
            const additionsRadios = document.querySelectorAll('input[name="additions"]');
            additionsRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateAdditionsStyle();
                    updateAdditionPrice();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateAdditionsStyle();
                            updateAdditionPrice();
                        }
                    });
                }
            });
            
            // Function to update additions styling
            function updateAdditionsStyle() {
                document.querySelectorAll('input[name="additions"]').forEach(r => {
                    const label = r.closest('label');
                    if (label) {
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    }
                });
            }
            
            // Initialize additions styling
            updateAdditionsStyle();
            
            // Initialize addition price on page load
            updateAdditionPrice();

            // Handle fingerprint radio buttons
            const fingerprintRadios = document.querySelectorAll('input[name="fingerprint"]');
            fingerprintRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateFingerprintStyle();
                    toggleFingerprintPrice();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateFingerprintStyle();
                            toggleFingerprintPrice();
                        }
                    });
                }
            });
            
            // Function to update fingerprint styling
            function updateFingerprintStyle() {
                document.querySelectorAll('input[name="fingerprint"]').forEach(r => {
                    const label = r.closest('label');
                    if (label) {
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    }
                });
            }
            
            // Initialize fingerprint styling
            updateFingerprintStyle();

            // Handle winding_direction radio buttons (handled by updateWindingDirectionStyle function below)

            // Handle final_product_shape radio buttons
            const shapeRadios = document.querySelectorAll('input[name="final_product_shape"]');
            shapeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateFinalProductShapeStyle();
                    toggleProductionFields();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateFinalProductShapeStyle();
                            toggleProductionFields();
                        }
                    });
                }
            });
            
            // Function to update final_product_shape styling
            function updateFinalProductShapeStyle() {
                document.querySelectorAll('input[name="final_product_shape"]').forEach(r => {
                    const label = r.closest('label');
                    if (label) {
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    }
                });
            }
            
            // Initialize final_product_shape styling
            updateFinalProductShapeStyle();

            // Handle knife_exists radio buttons
            const knifeExistsRadios = document.querySelectorAll('input[name="knife_exists"]');
            knifeExistsRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateKnifeExistsStyle();
                    toggleKnifePrice();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateKnifeExistsStyle();
                            toggleKnifePrice();
                        }
                    });
                }
            });
            
            // Function to update knife_exists styling
            function updateKnifeExistsStyle() {
                document.querySelectorAll('input[name="knife_exists"]').forEach(r => {
                    const label = r.closest('label');
                    if (label) {
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    }
                });
            }
            
            // Initialize knife_exists styling
            updateKnifeExistsStyle();

            // Handle external_breaking radio buttons
            const externalBreakingRadios = document.querySelectorAll('input[name="external_breaking"]');
            externalBreakingRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateExternalBreakingStyle();
                    toggleExternalBreakingPrice();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateExternalBreakingStyle();
                            toggleExternalBreakingPrice();
                        }
                    });
                }
            });
            
            // Function to update external_breaking styling
            function updateExternalBreakingStyle() {
                document.querySelectorAll('input[name="external_breaking"]').forEach(r => {
                    const label = r.closest('label');
                    if (label) {
                        if (r.checked) {
                            label.style.borderColor = '#2563eb';
                            label.style.backgroundColor = '#eff6ff';
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                        }
                    }
                });
            }
            
            // Initialize external_breaking styling
            updateExternalBreakingStyle();
            
            // Initialize external breaking price on page load
            toggleExternalBreakingPrice();

            // Handle winding_direction radio buttons
            const windingDirectionRadios = document.querySelectorAll('input[name="winding_direction"]');
            windingDirectionRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateWindingDirectionStyle();
                    toggleWindingDirectionOptions();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateWindingDirectionStyle();
                            toggleWindingDirectionOptions();
                        }
                    });
                }
            });

            // Initialize on page load
            toggleWindingDirectionOptions();
            updateWindingDirectionStyle();

            // Initialize production fields on page load
            toggleProductionFields();
            
            // Handle number_of_colors radio buttons
            const numberOfColorsRadios = document.querySelectorAll('input[name="number_of_colors"]');
            numberOfColorsRadios.forEach(radio => {
                // Handle change event
                radio.addEventListener('change', function() {
                    // Use setTimeout to ensure the checked state is updated
                    setTimeout(() => {
                        updateNumberOfColorsStyle();
                        updateWastePercentage();
                    }, 0);
                });
                
                // Handle click event to ensure immediate update
                radio.addEventListener('click', function(e) {
                    // Use setTimeout to ensure the checked state is updated
                    setTimeout(() => {
                        updateNumberOfColorsStyle();
                        updateWastePercentage();
                    }, 0);
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // If clicking on label (not the radio itself), manually check the radio
                        if (e.target === label || e.target.tagName === 'SPAN') {
                            e.preventDefault();
                            e.stopPropagation();
                            // Uncheck all other radios first
                            numberOfColorsRadios.forEach(r => {
                                if (r !== radio) {
                                    r.checked = false;
                                }
                            });
                            radio.checked = true;
                            // Update style immediately
                            updateNumberOfColorsStyle();
                            updateWastePercentage();
                            // Trigger change event manually
                            const changeEvent = new Event('change', { bubbles: true });
                            radio.dispatchEvent(changeEvent);
                        }
                    });
                }
            });
            
            // Initialize number_of_colors styling
            updateNumberOfColorsStyle();
            
            // Initialize waste percentage on page load
            updateWastePercentage();
            
            // Initialize linear meter with waste on page load
            calculateLinearMeterWithWaste();
            
            // Initialize square meter on page load
            calculateSquareMeter();
            
            // Handle rows_count radio buttons
            const rowsCountRadios = document.querySelectorAll('input[name="rows_count"]');
            rowsCountRadios.forEach(radio => {
                // Function to handle calculations
                const handleRowsCountChange = function() {
                    updateRowsCountStyle();
                    // Calculate immediately without setTimeout for better responsiveness
                    calculatePaperWidth();
                    calculateLinearMeter();
                };
                
                // Handle change event
                radio.addEventListener('change', function() {
                    handleRowsCountChange();
                });
                
                // Handle click event to ensure immediate update
                radio.addEventListener('click', function(e) {
                    // Small delay to ensure checked state is updated
                    setTimeout(() => {
                        handleRowsCountChange();
                    }, 10);
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // If clicking on label (not the radio itself), manually check the radio
                        if (e.target === label || e.target.tagName === 'SPAN') {
                            e.preventDefault();
                            e.stopPropagation();
                            // Uncheck all other radios first
                            rowsCountRadios.forEach(r => {
                                if (r !== radio) {
                                    r.checked = false;
                                }
                            });
                            radio.checked = true;
                            // Update immediately
                            handleRowsCountChange();
                            // Trigger change event manually
                            const changeEvent = new Event('change', { bubbles: true });
                            radio.dispatchEvent(changeEvent);
                        }
                    });
                }
            });
            
            // Initialize rows_count styling
            updateRowsCountStyle();
            
            // Calculate on page load if rows_count is already selected
            calculatePaperWidth();
            calculateLinearMeter();
            
            // Handle film_count radio buttons
            const filmCountRadios = document.querySelectorAll('input[name="film_count"]');
            filmCountRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateFilmCountStyle();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            radio.checked = true;
                            updateFilmCountStyle();
                        }
                    });
                }
            });
            
            // Initialize film_count styling
            updateFilmCountStyle();
            
            // Handle core_size radio buttons
            const coreSizeRadios = document.querySelectorAll('input[name="core_size"]');
            coreSizeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    updateCoreSizeStyle();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // If clicking on label (not the radio itself), manually check the radio
                        if (e.target === label || e.target.tagName === 'SPAN') {
                            e.preventDefault();
                            e.stopPropagation();
                            // Uncheck all other radios first
                            coreSizeRadios.forEach(r => {
                                if (r !== radio) {
                                    r.checked = false;
                                }
                            });
                            radio.checked = true;
                            // Update style immediately
                            updateCoreSizeStyle();
                            // Trigger change event manually
                            const changeEvent = new Event('change', { bubbles: true });
                            radio.dispatchEvent(changeEvent);
                        }
                    });
                }
            });
            
            // Initialize core_size styling
            updateCoreSizeStyle();
            
            // Handle select dropdowns styling and feedback
            const selects = document.querySelectorAll('.form-select');
            selects.forEach(select => {
                // Add visual feedback when select changes
                select.addEventListener('change', function() {
                    // Highlight the select briefly
                    const originalBorder = this.style.borderColor;
                    const originalBg = this.style.backgroundColor;
                    
                    this.style.borderColor = '#10b981';
                    this.style.backgroundColor = '#f0fdf4';
                    
                    // Reset after a short delay
                    setTimeout(() => {
                        this.style.borderColor = originalBorder || '';
                        this.style.backgroundColor = originalBg || '';
                    }, 500);
                });
                
                // Add focus styling
                select.addEventListener('focus', function() {
                    this.style.borderColor = '#2563eb';
                    this.style.boxShadow = '0 0 0 3px rgba(37, 99, 235, 0.1)';
                });
                
                select.addEventListener('blur', function() {
                    if (!this.value) {
                        this.style.borderColor = '';
                    }
                    this.style.boxShadow = '';
                });
            });
        });

        // Update number of colors style
        function updateNumberOfColorsStyle() {
            const radios = document.querySelectorAll('input[name="number_of_colors"]');
            radios.forEach(r => {
                const label = r.closest('label');
                if (label) {
                    // Remove all inline styles first to ensure clean state
                    if (r.checked) {
                        label.style.borderColor = '#2563eb';
                        label.style.backgroundColor = '#eff6ff';
                        label.style.borderWidth = '2px';
                    } else {
                        label.style.borderColor = '#d1d5db';
                        label.style.backgroundColor = 'transparent';
                        label.style.borderWidth = '2px';
                    }
                }
            });
        }

        // Update waste percentage based on number of colors
        function updateWastePercentage() {
            const numberOfColorsRadio = document.querySelector('input[name="number_of_colors"]:checked');
            const wastePercentageInput = document.getElementById('waste_percentage');
            
            if (!wastePercentageInput) return;
            
            if (numberOfColorsRadio) {
                const numberOfColors = parseInt(numberOfColorsRadio.value) || 0;
                const wastePercentage = wastePercentages[numberOfColors];
                
                if (wastePercentage !== undefined) {
                    wastePercentageInput.value = parseFloat(wastePercentage).toFixed(2);
                } else {
                    wastePercentageInput.value = '';
                }
            } else {
                wastePercentageInput.value = '';
            }
            
            // Update linear meter with waste after waste percentage is updated
            calculateLinearMeterWithWaste();
            
        }

        // Update rows count style
        function updateRowsCountStyle() {
            const radios = document.querySelectorAll('input[name="rows_count"]');
            radios.forEach(r => {
                const label = r.closest('label');
                if (label) {
                    // Remove all inline styles first to ensure clean state
                    if (r.checked) {
                        label.style.borderColor = '#2563eb';
                        label.style.backgroundColor = '#eff6ff';
                        label.style.borderWidth = '2px';
                    } else {
                        label.style.borderColor = '#d1d5db';
                        label.style.backgroundColor = 'transparent';
                        label.style.borderWidth = '2px';
                    }
                }
            });
        }

        // Update film count style
        function updateFilmCountStyle() {
            document.querySelectorAll('input[name="film_count"]').forEach(r => {
                const label = r.closest('label');
                if (label) {
                    if (r.checked) {
                        label.style.borderColor = '#2563eb';
                        label.style.backgroundColor = '#eff6ff';
                    } else {
                        label.style.borderColor = '#d1d5db';
                        label.style.backgroundColor = 'transparent';
                    }
                }
            });
        }

        // Update core size style
        function updateCoreSizeStyle() {
            const radios = document.querySelectorAll('input[name="core_size"]');
            radios.forEach(r => {
                const label = r.closest('label');
                if (label) {
                    // Remove all inline styles first to ensure clean state
                    if (r.checked) {
                        label.style.borderColor = '#2563eb';
                        label.style.backgroundColor = '#eff6ff';
                        label.style.borderWidth = '2px';
                    } else {
                        label.style.borderColor = '#d1d5db';
                        label.style.backgroundColor = 'transparent';
                        label.style.borderWidth = '2px';
                    }
                }
            });
        }

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

        // Toggle winding direction options based on selection
        function toggleWindingDirectionOptions() {
            const noRadio = document.getElementById('winding_direction_no');
            const yesRadio = document.getElementById('winding_direction_yes');
            const optionsDiv = document.getElementById('winding_direction_options');
            const clockwiseRadio = document.getElementById('winding_direction_clockwise');
            const counterclockwiseRadio = document.getElementById('winding_direction_counterclockwise');

            if (yesRadio && yesRadio.checked) {
                if (optionsDiv) optionsDiv.style.display = 'flex';
                // If no detailed option is selected, select clockwise by default
                if (clockwiseRadio && counterclockwiseRadio && !clockwiseRadio.checked && !counterclockwiseRadio.checked) {
                    clockwiseRadio.checked = true;
                    handleWindingDirectionChange();
                }
            } else if (noRadio && noRadio.checked) {
                if (optionsDiv) optionsDiv.style.display = 'none';
                // Uncheck the detailed options if "no" is selected
                if (clockwiseRadio) clockwiseRadio.checked = false;
                if (counterclockwiseRadio) counterclockwiseRadio.checked = false;
                updateWindingDirectionStyle();
            }
        }

        // Handle winding direction change (when detailed option is selected)
        function handleWindingDirectionChange() {
            const clockwiseRadio = document.getElementById('winding_direction_clockwise');
            const counterclockwiseRadio = document.getElementById('winding_direction_counterclockwise');
            const yesRadio = document.getElementById('winding_direction_yes');
            
            // Uncheck "yes" radio when a detailed option is selected
            if (yesRadio && (clockwiseRadio?.checked || counterclockwiseRadio?.checked)) {
                yesRadio.checked = false;
            }
            
            updateWindingDirectionStyle();
        }

        // Update winding direction style
        function updateWindingDirectionStyle() {
            const allRadios = document.querySelectorAll('input[name="winding_direction"]');
            allRadios.forEach(radio => {
                const label = radio.closest('label');
                if (label) {
                    if (radio.checked) {
                        label.style.borderColor = '#2563eb';
                        label.style.backgroundColor = '#eff6ff';
                    } else {
                        label.style.borderColor = '#d1d5db';
                        label.style.backgroundColor = 'transparent';
                    }
                }
            });
        }

        // Update addition price field based on selected addition
        function updateAdditionPrice() {
            const selectedAddition = document.querySelector('input[name="additions"]:checked');
            const priceGroup = document.getElementById('addition_price_group');
            const priceInput = document.getElementById('addition_price');
            const minPriceInput = document.getElementById('addition_min_price');
            const minPriceDisplay = document.getElementById('addition_min_price_display');
            
            if (selectedAddition && selectedAddition.value !== 'لا يوجد') {
                const defaultPrice = parseFloat(selectedAddition.getAttribute('data-price')) || 0;
                
                // Show price field
                if (priceGroup) priceGroup.style.display = 'block';
                
                // Set minimum price
                if (minPriceInput) minPriceInput.value = defaultPrice;
                if (minPriceDisplay) minPriceDisplay.textContent = defaultPrice.toFixed(2);
                
                // Set default price if not already set or if current value is less than minimum
                if (priceInput) {
                    const currentValue = parseFloat(priceInput.value) || 0;
                    if (currentValue < defaultPrice || !priceInput.value) {
                        priceInput.value = defaultPrice.toFixed(2);
                    }
                    priceInput.setAttribute('min', defaultPrice);
                    priceInput.setAttribute('required', 'required');
                }
            } else {
                // Hide price field if "لا يوجد" is selected
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
            
            // Recalculate total amount
            calculateTotalAmount();
        }

        // Toggle fingerprint price field
        function toggleFingerprintPrice() {
            const fingerprintYes = document.getElementById('fingerprint_yes');
            const priceGroup = document.getElementById('fingerprint_price_group');
            const priceInput = document.getElementById('fingerprint_price');
            
            if (fingerprintYes && fingerprintYes.checked) {
                if (priceGroup) priceGroup.style.display = 'block';
                if (priceInput) {
                    priceInput.setAttribute('required', 'required');
                    // Set default value to 16 if field is empty
                    if (!priceInput.value || priceInput.value === '') {
                        priceInput.value = '16.00';
                    }
                }
            } else {
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
            
            // Recalculate total amount
            calculateTotalAmount();
        }

        // Toggle knife price field
        function toggleKnifePrice() {
            const knifeYes = document.getElementById('knife_exists_yes');
            const priceGroup = document.getElementById('knife_price_group');
            const priceInput = document.getElementById('knife_price');
            
            if (knifeYes && knifeYes.checked) {
                if (priceGroup) priceGroup.style.display = 'block';
                if (priceInput) {
                    priceInput.setAttribute('required', 'required');
                    // Set default value to 600 if field is empty
                    if (!priceInput.value || priceInput.value === '') {
                        priceInput.value = '600.00';
                    }
                }
            } else {
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
            
            // Recalculate total preparations
            calculateTotalPreparations();
        }

        // Toggle external breaking price field
        function toggleExternalBreakingPrice() {
            const externalBreakingYes = document.getElementById('external_breaking_yes');
            const priceGroup = document.getElementById('external_breaking_price_group');
            const priceInput = document.getElementById('external_breaking_price');
            
            if (externalBreakingYes && externalBreakingYes.checked) {
                if (priceGroup) priceGroup.style.display = 'block';
                if (priceInput) {
                    priceInput.setAttribute('required', 'required');
                    // Set default value from database if field is empty
                    if (!priceInput.value || priceInput.value === '') {
                        const defaultPrice = priceInput.getAttribute('data-default-price') || '4';
                        priceInput.value = parseFloat(defaultPrice).toFixed(2);
                    }
                }
            } else {
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
            
            // Recalculate total amount
            calculateTotalAmount();
        }

        // Calculate paper width automatically
        function calculatePaperWidth() {
            const rowsCountRadio = document.querySelector('input[name="rows_count"]:checked');
            const widthInput = document.getElementById('width');
            const paperWidthInput = document.getElementById('paper_width');
            
            if (!paperWidthInput) return;
            
            const rowsCount = rowsCountRadio ? parseFloat(rowsCountRadio.value) || 0 : 0;
            const width = parseFloat(widthInput?.value) || 0;
            
            // Formula: (العرض × عدد الصفوف) + ((عدد الصفوف - 1) × 0.3) + 1.2
            if (rowsCount > 0 && width > 0) {
                const paperWidth = (width * rowsCount) + (((rowsCount - 1) * 0.3) + 1.2);
                paperWidthInput.value = paperWidth.toFixed(2);
            } else {
                // Clear if either value is missing
                paperWidthInput.value = '';
            }
            
            // Also calculate linear meter
            calculateLinearMeter();
            
            // Update square meter after paper width is calculated
            calculateSquareMeter();
        }

        // Calculate linear meter automatically
        function calculateLinearMeter() {
            const quantityInput = document.getElementById('quantity');
            const lengthInput = document.getElementById('length');
            const gapCountInput = document.getElementById('gap_count');
            const rowsCountRadio = document.querySelector('input[name="rows_count"]:checked');
            const linearMeterInput = document.getElementById('linear_meter');
            
            const quantity = parseFloat(quantityInput?.value) || 0;
            const length = parseFloat(lengthInput?.value) || 0;
            const gapCount = parseFloat(gapCountInput?.value) || 0;
            const rowsCount = rowsCountRadio ? parseFloat(rowsCountRadio.value) || 0 : 0;
            
            // Formula: (الكمية × 1000 × (الطول + الجاب)) ÷ (100 × عدد_الصفوف)
            if (rowsCount > 0) {
                if (quantity > 0 && length > 0) {
                    const linearMeter = (quantity * 1000 * (length + gapCount)) / (100 * rowsCount);
                    if (linearMeterInput) {
                        linearMeterInput.value = linearMeter.toFixed(2);
                    }
                    // Calculate rolls count after linear meter is calculated
                    calculateRollsCount(linearMeter);
                } else {
                    // If required fields are not set, clear the linear meter
                    if (linearMeterInput) {
                        linearMeterInput.value = '';
                    }
                    calculateRollsCount(0);
                }
            } else {
                if (linearMeterInput) {
                    linearMeterInput.value = '';
                }
                calculateRollsCount(0);
            }
            
            // Update linear meter with waste after linear meter is calculated
            calculateLinearMeterWithWaste();
            
        }

        // Calculate rolls count automatically
        function calculateRollsCount(linearMeter) {
            const rollsCountInput = document.getElementById('rolls_count');
            if (!rollsCountInput) return;
            
            if (linearMeter > 0) {
                // Formula: (المتر الطولي ÷ 1000) ثم التقريب إلى الرقم الأعلى
                const rollsCount = Math.ceil(linearMeter / 1000);
                rollsCountInput.value = rollsCount;
                // Calculate waste after rolls count is calculated
                calculateWaste(rollsCount);
            } else {
                rollsCountInput.value = '';
                calculateWaste(0);
            }
            
        }

        // Calculate waste automatically
        function calculateWaste(rollsCount) {
            const wasteInput = document.getElementById('waste');
            const wastePerRollInput = document.getElementById('waste_per_roll');
            if (!wasteInput) return;
            
            const wastePerRoll = parseFloat(wastePerRollInput?.value) || 0;
            
            if (rollsCount > 0 && wastePerRoll > 0) {
                // Formula: عدد البكر × عدد الهالك للبكره
                const waste = rollsCount * wastePerRoll;
                wasteInput.value = waste;
            } else {
                wasteInput.value = '';
            }
            
            // Update linear meter with waste after waste is calculated
            calculateLinearMeterWithWaste();
            
        }

        // Calculate linear meter with waste automatically
        function calculateLinearMeterWithWaste() {
            const linearMeterInput = document.getElementById('linear_meter');
            const wasteInput = document.getElementById('waste');
            const wastePercentageInput = document.getElementById('waste_percentage');
            const linearMeterWithWasteInput = document.getElementById('linear_meter_with_waste');
            
            if (!linearMeterWithWasteInput) return;
            
            const linearMeter = parseFloat(linearMeterInput?.value) || 0;
            const waste = parseFloat(wasteInput?.value) || 0;
            const wastePercentage = parseFloat(wastePercentageInput?.value) || 0;
            
            if (linearMeter > 0) {
                // Formula: المتر الطولي + الهالك + نسبة الهالك
                const linearMeterWithWaste = linearMeter + waste + wastePercentage;
                linearMeterWithWasteInput.value = parseFloat(linearMeterWithWaste.toFixed(2));
            } else {
                linearMeterWithWasteInput.value = '';
            }
            
            // Update square meter after linear meter with waste is calculated
            calculateSquareMeter();
            
        }

        // Calculate square meter automatically
        function calculateSquareMeter() {
            const linearMeterWithWasteInput = document.getElementById('linear_meter_with_waste');
            const paperWidthInput = document.getElementById('paper_width');
            const squareMeterInput = document.getElementById('square_meter');
            
            if (!squareMeterInput) return;
            
            const linearMeterWithWaste = parseFloat(linearMeterWithWasteInput?.value) || 0;
            const paperWidth = parseFloat(paperWidthInput?.value) || 0;
            
            if (linearMeterWithWaste > 0 && paperWidth > 0) {
                // Formula: (المتر الطولي مضاف اليه الهالك × عرض الورق) ÷ 100
                const squareMeter = (linearMeterWithWaste * paperWidth) / 100;
                squareMeterInput.value = parseFloat(squareMeter.toFixed(2));
            } else {
                squareMeterInput.value = '';
            }
            
            // Recalculate total amount when square meter changes
            calculateTotalAmount();
            
        }

        // Calculate total amount automatically
        function calculateTotalAmount() {
            const totalPricesSumInput = document.getElementById('total_prices_sum');
            const totalAmountInput = document.getElementById('total_amount');
            
            // Get all price values
            const materialPricePerMeter = parseFloat(document.getElementById('material_price_per_meter')?.value) || 0;
            const manufacturingPricePerMeter = parseFloat(document.getElementById('manufacturing_price_per_meter')?.value) || 0;
            
            // Check if addition exists and get price
            const additionsRadio = document.querySelector('input[name="additions"]:checked');
            const additionExists = additionsRadio && additionsRadio.value !== 'لا يوجد';
            const additionPrice = additionExists ? (parseFloat(document.getElementById('addition_price')?.value) || 0) : 0;
            
            // Check if fingerprint exists and get price
            const fingerprintYes = document.getElementById('fingerprint_yes');
            const fingerprintPrice = (fingerprintYes && fingerprintYes.checked) ? (parseFloat(document.getElementById('fingerprint_price')?.value) || 0) : 0;
            
            // Check if external breaking exists and get price
            const externalBreakingYes = document.getElementById('external_breaking_yes');
            const externalBreakingPrice = (externalBreakingYes && externalBreakingYes.checked) ? (parseFloat(document.getElementById('external_breaking_price')?.value) || 0) : 0;
            
            // Calculate sum of all prices
            const sumOfPrices = materialPricePerMeter + manufacturingPricePerMeter + additionPrice + fingerprintPrice + externalBreakingPrice;
            
            // Update total prices sum field
            if (totalPricesSumInput) {
                if (sumOfPrices > 0) {
                    totalPricesSumInput.value = parseFloat(sumOfPrices.toFixed(2));
                } else {
                    totalPricesSumInput.value = '';
                }
            }
            
            // Get square meter
            const squareMeter = parseFloat(document.getElementById('square_meter')?.value) || 0;
            
            // Multiply by square meter and update total amount field
            if (totalAmountInput) {
                if (sumOfPrices > 0 && squareMeter > 0) {
                    const totalAmount = sumOfPrices * squareMeter;
                    totalAmountInput.value = parseFloat(totalAmount.toFixed(2));
                } else {
                    totalAmountInput.value = '';
                }
            }
            
            // Recalculate total order when total amount changes
            calculateTotalOrder();
            
        }

        // Calculate total preparations automatically
        function calculateTotalPreparations() {
            const totalPreparationsInput = document.getElementById('total_preparations');
            if (!totalPreparationsInput) return;
            
            // Get film price
            const filmPrice = parseFloat(document.getElementById('film_price')?.value) || 0;
            
            // Get film count (from radio buttons)
            const filmCountRadio = document.querySelector('input[name="film_count"]:checked');
            const filmCount = filmCountRadio ? parseFloat(filmCountRadio.value) || 0 : 0;
            
            // Get knife price (only if knife exists)
            const knifeYes = document.getElementById('knife_exists_yes');
            const knifePrice = (knifeYes && knifeYes.checked) ? (parseFloat(document.getElementById('knife_price')?.value) || 0) : 0;
            
            // Calculate: (سعر الفيلم الواحد × العدد) + سعر السكينة
            const totalPreparations = (filmPrice * filmCount) + knifePrice;
            
            if (totalPreparations > 0) {
                totalPreparationsInput.value = parseFloat(totalPreparations.toFixed(2));
            } else {
                totalPreparationsInput.value = '';
            }
            
            // Recalculate total order when preparations change
            calculateTotalOrder();
            
        }

        // Calculate total order automatically
        function calculateTotalOrder() {
            const totalOrderInput = document.getElementById('total_order');
            if (!totalOrderInput) return;
            
            // Get total amount
            const totalAmount = parseFloat(document.getElementById('total_amount')?.value) || 0;
            
            // Get total preparations
            const totalPreparations = parseFloat(document.getElementById('total_preparations')?.value) || 0;
            
            // Calculate: إجمالي المبلغ + إجمالي التجهيزات
            const totalOrder = totalAmount + totalPreparations;
            
            if (totalOrder > 0) {
                totalOrderInput.value = parseFloat(totalOrder.toFixed(2));
            } else {
                totalOrderInput.value = '';
            }
            
            // Recalculate price per thousand when total order changes
            calculatePricePerThousand();
            
        }

        // Calculate price per thousand automatically
        function calculatePricePerThousand() {
            const pricePerThousandInput = document.getElementById('price_per_thousand');
            if (!pricePerThousandInput) return;
            
            // Get total order
            const totalOrder = parseFloat(document.getElementById('total_order')?.value) || 0;
            
            // Get quantity
            const quantity = parseFloat(document.getElementById('quantity')?.value) || 0;
            
            // Calculate: إجمالي الطلب ÷ الكمية
            if (totalOrder > 0 && quantity > 0) {
                const pricePerThousand = totalOrder / quantity;
                pricePerThousandInput.value = parseFloat(pricePerThousand.toFixed(2));
            } else {
                pricePerThousandInput.value = '';
            }
            
            // Update sidebar calculations
            updateSidebarCalculations();
        }


        // Update material price per meter based on selected material
        function updateMaterialPrice() {
            const materialSelect = document.getElementById('material');
            const materialPriceInput = document.getElementById('material_price_per_meter');
            
            if (materialSelect && materialPriceInput) {
                // Get selected value (works with both native select and Select2)
                const selectedValue = materialSelect.value;
                
                // Find the option with matching value
                const selectedOption = materialSelect.querySelector(`option[value="${selectedValue}"]`);
                const price = selectedOption ? selectedOption.getAttribute('data-price') : null;
                
                if (price && price !== '' && price !== 'null') {
                    // Check if user manually changed the price
                    const isManuallyChanged = materialPriceInput.getAttribute('data-manually-changed') === 'true';
                    
                    // Only update if the field is empty or if user hasn't manually changed it
                    if (!materialPriceInput.value || materialPriceInput.value === '' || !isManuallyChanged) {
                        const priceValue = parseFloat(price).toFixed(2);
                        materialPriceInput.value = priceValue;
                        // Reset the manually changed flag when material changes
                        materialPriceInput.removeAttribute('data-manually-changed');
                    }
                } else if (!price || price === '' || price === 'null') {
                    // Clear the field if no material is selected or material has no price
                    if (materialPriceInput.getAttribute('data-manually-changed') !== 'true') {
                        materialPriceInput.value = '';
                    }
                }
                
                // Recalculate total amount
                calculateTotalAmount();
            }
        }
        
        // Initialize calculations on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculatePaperWidth();
            
            // Track manual changes to material price field
            const materialPriceInput = document.getElementById('material_price_per_meter');
            if (materialPriceInput) {
                // Mark as manually changed when user types
                materialPriceInput.addEventListener('input', function() {
                    this.setAttribute('data-manually-changed', 'true');
                    calculateTotalAmount();
                });
                materialPriceInput.addEventListener('change', function() {
                    calculateTotalAmount();
                });
            }
            
            // Initialize material price on page load if material is already selected
            updateMaterialPrice();
            
            // Add event listeners for total amount calculation
            // Manufacturing price per meter
            const manufacturingPriceInput = document.getElementById('manufacturing_price_per_meter');
            if (manufacturingPriceInput) {
                manufacturingPriceInput.addEventListener('input', calculateTotalAmount);
                manufacturingPriceInput.addEventListener('change', calculateTotalAmount);
            }
            
            // Addition price
            const additionPriceInput = document.getElementById('addition_price');
            if (additionPriceInput) {
                additionPriceInput.addEventListener('input', calculateTotalAmount);
                additionPriceInput.addEventListener('change', calculateTotalAmount);
            }
            
            // Fingerprint price
            const fingerprintPriceInput = document.getElementById('fingerprint_price');
            if (fingerprintPriceInput) {
                fingerprintPriceInput.addEventListener('input', calculateTotalAmount);
                fingerprintPriceInput.addEventListener('change', calculateTotalAmount);
            }
            
            // External breaking price
            const externalBreakingPriceInput = document.getElementById('external_breaking_price');
            if (externalBreakingPriceInput) {
                externalBreakingPriceInput.addEventListener('input', calculateTotalAmount);
                externalBreakingPriceInput.addEventListener('change', calculateTotalAmount);
            }
            
            // Square meter (already calculated, but we need to recalculate total when it changes)
            const squareMeterInput = document.getElementById('square_meter');
            if (squareMeterInput) {
                squareMeterInput.addEventListener('input', calculateTotalAmount);
                squareMeterInput.addEventListener('change', calculateTotalAmount);
            }
            
            // Additions radio buttons
            const additionsRadios = document.querySelectorAll('input[name="additions"]');
            additionsRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    setTimeout(calculateTotalAmount, 100); // Small delay to ensure UI updates
                });
            });
            
            // Fingerprint radio buttons
            const fingerprintRadios = document.querySelectorAll('input[name="fingerprint"]');
            fingerprintRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    setTimeout(calculateTotalAmount, 100); // Small delay to ensure UI updates
                });
            });
            
            // External breaking radio buttons
            const externalBreakingRadios = document.querySelectorAll('input[name="external_breaking"]');
            externalBreakingRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    setTimeout(calculateTotalAmount, 100); // Small delay to ensure UI updates
                });
            });
            
            // Film price
            const filmPriceInput = document.getElementById('film_price');
            if (filmPriceInput) {
                filmPriceInput.addEventListener('input', calculateTotalPreparations);
                filmPriceInput.addEventListener('change', calculateTotalPreparations);
            }
            
            // Film count radio buttons
            const filmCountRadios = document.querySelectorAll('input[name="film_count"]');
            filmCountRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    calculateTotalPreparations();
                });
            });
            
            // Knife price
            const knifePriceInput = document.getElementById('knife_price');
            if (knifePriceInput) {
                knifePriceInput.addEventListener('input', calculateTotalPreparations);
                knifePriceInput.addEventListener('change', calculateTotalPreparations);
            }
            
            // Knife exists radio buttons
            const knifeExistsRadios = document.querySelectorAll('input[name="knife_exists"]');
            knifeExistsRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    setTimeout(calculateTotalPreparations, 100); // Small delay to ensure UI updates
                });
            });
            
            // Total amount and total preparations (for total order calculation)
            const totalAmountInput = document.getElementById('total_amount');
            if (totalAmountInput) {
                totalAmountInput.addEventListener('input', calculateTotalOrder);
                totalAmountInput.addEventListener('change', calculateTotalOrder);
            }
            
            const totalPreparationsInput = document.getElementById('total_preparations');
            if (totalPreparationsInput) {
                totalPreparationsInput.addEventListener('input', calculateTotalOrder);
                totalPreparationsInput.addEventListener('change', calculateTotalOrder);
            }
            
            // Total order (for price per thousand calculation)
            const totalOrderInput = document.getElementById('total_order');
            if (totalOrderInput) {
                totalOrderInput.addEventListener('input', calculatePricePerThousand);
                totalOrderInput.addEventListener('change', calculatePricePerThousand);
            }
            
            // Initialize total amount calculation on page load
            calculateTotalAmount();
            
            // Initialize total preparations calculation on page load
            calculateTotalPreparations();
            
            // Initialize total order calculation on page load
            calculateTotalOrder();
            
            // Initialize price per thousand calculation on page load
            calculatePricePerThousand();
            
            // Add event listeners to update sidebar on input changes
            // Note: rows_count is now radio buttons, handled separately above
            const inputsToWatch = ['width', 'length', 'quantity'];
            inputsToWatch.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', function() {
                        calculatePaperWidth();
                    });
                    input.addEventListener('change', function() {
                        calculatePaperWidth();
                    });
                }
            });
            
            // Add event listeners for linear meter calculation
            // Note: rows_count is radio buttons, handled separately above
            const linearMeterInputs = ['quantity', 'gap_count', 'length'];
            linearMeterInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', function() {
                        calculateLinearMeter();
                    });
                    input.addEventListener('change', function() {
                        calculateLinearMeter();
                    });
                }
            });
            
            // Add event listener for waste_per_roll to calculate waste
            const wastePerRollInput = document.getElementById('waste_per_roll');
            if (wastePerRollInput) {
                wastePerRollInput.addEventListener('input', function() {
                    const rollsCount = parseFloat(document.getElementById('rolls_count')?.value) || 0;
                    calculateWaste(rollsCount);
                });
                wastePerRollInput.addEventListener('change', function() {
                    const rollsCount = parseFloat(document.getElementById('rolls_count')?.value) || 0;
                    calculateWaste(rollsCount);
                });
            }
            
        });

    </script>

    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 on client field
            $('#client_id').select2({
                dir: 'rtl',
                placeholder: 'ابحث عن العميل أو اختر من القائمة',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    },
                    searching: function() {
                        return "جاري البحث...";
                    },
                    inputTooShort: function() {
                        return "أدخل حرف واحد على الأقل للبحث";
                    }
                },
                minimumResultsForSearch: 0,
                dropdownAutoWidth: false
            });
            
            // Initialize Select2 on material field
            $('#material').select2({
                dir: 'rtl',
                placeholder: 'ابحث عن الخامة أو اختر من القائمة',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    },
                    searching: function() {
                        return "جاري البحث...";
                    },
                    inputTooShort: function() {
                        return "أدخل حرف واحد على الأقل للبحث";
                    }
                },
                minimumResultsForSearch: 0,
                dropdownAutoWidth: false
            });
            
            // Fix Select2 container styling and add placeholder on open for client
            $('#client_id').on('select2:open', function() {
                $('.select2-search__field').attr('placeholder', 'اكتب للبحث...');
                $('.select2-search__field').focus();
            });
            
            // Fix Select2 container styling and add placeholder on open for material
            $('#material').on('select2:open', function() {
                $('.select2-search__field').attr('placeholder', 'اكتب للبحث...');
                $('.select2-search__field').focus();
            });
            
            // Ensure proper RTL direction for client
            $('#client_id').on('select2:select select2:clear', function() {
                $(this).trigger('change');
            });
            
            // Handle material selection change to update price
            $('#material').on('select2:select', function() {
                updateMaterialPrice();
                $(this).trigger('change');
            });
            
            $('#material').on('select2:clear', function() {
                updateMaterialPrice();
                $(this).trigger('change');
            });
        });
    </script>
</x-app-layout>




