<x-app-layout>
    @php
        $title = 'تعديل أمر الشغل';
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
                <h2>تعديل أمر الشغل</h2>
                <p>تعديل بيانات أمر الشغل رقم: {{ $workOrder->order_number }}</p>
            </div>

            <form action="{{ route('work-orders.update', $workOrder) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- معلومات أساسية -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">معلومات أساسية</h3>
                    
                    <!-- Client Selection -->
                    <div class="form-group">
                        <label for="client_id" class="form-label required">العميل</label>
                        <select name="client_id" id="client_id" required class="form-select">
                            <option value="">اختر العميل</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $workOrder->client_id) == $client->id ? 'selected' : '' }}>
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
                               value="{{ old('order_number', $workOrder->order_number) }}" 
                               class="form-input">
                        @error('order_number')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Name -->
                    <div class="form-group">
                        <label for="job_name" class="form-label">اسم الشغلانه</label>
                        <input type="text" 
                               name="job_name" 
                               id="job_name" 
                               value="{{ old('job_name', $workOrder->job_name) }}" 
                               class="form-input"
                               placeholder="أدخل اسم الشغلانه">
                        @error('job_name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status" class="form-label">الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ old('status', $workOrder->status) == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="in_progress" {{ old('status', $workOrder->status) == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                            <option value="completed" {{ old('status', $workOrder->status) == 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ old('status', $workOrder->status) == 'cancelled' ? 'selected' : '' }}>ملغي</option>
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
                                <option value="{{ $material->name }}" {{ old('material', $workOrder->material) == $material->name ? 'selected' : '' }}>
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
                            <option value="0" {{ old('number_of_colors', $workOrder->number_of_colors) == 0 ? 'selected' : '' }}>0</option>
                            <option value="1" {{ old('number_of_colors', $workOrder->number_of_colors) == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('number_of_colors', $workOrder->number_of_colors) == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('number_of_colors', $workOrder->number_of_colors) == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('number_of_colors', $workOrder->number_of_colors) == 4 ? 'selected' : '' }}>4</option>
                            <option value="5" {{ old('number_of_colors', $workOrder->number_of_colors) == 5 ? 'selected' : '' }}>5</option>
                            <option value="6" {{ old('number_of_colors', $workOrder->number_of_colors) == 6 ? 'selected' : '' }}>6</option>
                        </select>
                        @error('number_of_colors')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Rows Count -->
                <div class="form-group">
                    <label for="rows_count" class="form-label">عدد الصفوف</label>
                    <input type="number" 
                           name="rows_count" 
                           id="rows_count" 
                           value="{{ old('rows_count', $workOrder->rows_count) }}" 
                           min="1"
                           class="form-input"
                           placeholder="أدخل عدد الصفوف"
                           oninput="calculatePaperWidth()">
                    @error('rows_count')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="form-group">
                    <label for="quantity" class="form-label required">الكمية</label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity" 
                           value="{{ old('quantity', $workOrder->quantity) }}" 
                           required
                           min="1"
                           class="form-input">
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
                               value="{{ old('width', $workOrder->width) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               oninput="calculatePaperWidth()">
                        @error('width')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="length" class="form-label">الطول (سم)</label>
                        <input type="number" 
                               name="length" 
                               id="length" 
                               value="{{ old('length', $workOrder->length) }}" 
                               step="0.01"
                               min="0"
                               class="form-input">
                        @error('length')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Paper Width (calculated automatically) -->
                <div class="form-group">
                    <label for="paper_width" class="form-label">عرض الورق (سم)</label>
                    <input type="number" 
                           name="paper_width" 
                           id="paper_width" 
                           value="{{ old('paper_width', $workOrder->paper_width) }}" 
                           step="0.01"
                           min="0"
                           class="form-input"
                           readonly
                           style="background-color: #f3f4f6; cursor: not-allowed;"
                           placeholder="سيتم الحساب تلقائياً">
                    <small style="display: block; margin-top: 0.5rem; font-size: 0.75rem; color: #6b7280;">
                        يتم الحساب تلقائياً: (العرض × عدد الصفوف) + (عدد الصفوف - 1) + 0.3 + 1.2
                    </small>
                    @error('paper_width')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                    <!-- Additions -->
                    <div class="form-group">
                        <label class="form-label">الإضافات المطلوبة</label>
                        <div style="display: flex; gap: 1rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('additions', $workOrder->additions ?? 'لا يوجد') == 'لا يوجد' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="additions" 
                                       value="لا يوجد" 
                                       data-price="0"
                                       {{ old('additions', $workOrder->additions ?? 'لا يوجد') == 'لا يوجد' ? 'checked' : '' }}
                                       onchange="updateAdditionPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            @foreach($additions as $addition)
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('additions', $workOrder->additions ?? '') == $addition->name ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="additions" 
                                       value="{{ $addition->name }}" 
                                       data-price="{{ $addition->price }}"
                                       {{ old('additions', $workOrder->additions ?? '') == $addition->name ? 'checked' : '' }}
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
                    <div id="addition_price_group" class="form-group" style="display: {{ old('additions', $workOrder->additions ?? 'لا يوجد') != 'لا يوجد' ? 'block' : 'none' }};">
                        <label for="addition_price" class="form-label">سعر الإضافة</label>
                        <input type="number" 
                               name="addition_price" 
                               id="addition_price" 
                               value="{{ old('addition_price', $workOrder->addition_price) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               {{ old('additions', $workOrder->additions ?? 'لا يوجد') != 'لا يوجد' ? 'required' : '' }}>
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
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('fingerprint', $workOrder->fingerprint ?? 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="fingerprint" 
                                       value="no" 
                                       id="fingerprint_no"
                                       {{ old('fingerprint', $workOrder->fingerprint ?? 'no') == 'no' ? 'checked' : '' }}
                                       onchange="toggleFingerprintPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('fingerprint', $workOrder->fingerprint ?? 'no') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="fingerprint" 
                                       value="yes" 
                                       id="fingerprint_yes"
                                       {{ old('fingerprint', $workOrder->fingerprint ?? 'no') == 'yes' ? 'checked' : '' }}
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
                    <div id="fingerprint_price_group" class="form-group" style="display: {{ old('fingerprint', $workOrder->fingerprint ?? 'no') == 'yes' ? 'block' : 'none' }};">
                        <label for="fingerprint_price" class="form-label">سعر البصمة</label>
                        <input type="number" 
                               name="fingerprint_price" 
                               id="fingerprint_price" 
                               value="{{ old('fingerprint_price', $workOrder->fingerprint_price) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               {{ old('fingerprint', $workOrder->fingerprint ?? 'no') == 'yes' ? 'required' : '' }}>
                        @error('fingerprint_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Winding Direction -->
                    <div class="form-group">
                        <label class="form-label">اتجاه اللف</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ !in_array(old('winding_direction', $workOrder->winding_direction ?? 'no'), ['clockwise', 'counterclockwise']) ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="no" 
                                       id="winding_direction_no"
                                       {{ !in_array(old('winding_direction', $workOrder->winding_direction ?? 'no'), ['clockwise', 'counterclockwise']) ? 'checked' : '' }}
                                       onchange="toggleWindingDirectionOptions()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ in_array(old('winding_direction', $workOrder->winding_direction ?? 'no'), ['clockwise', 'counterclockwise']) ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="yes" 
                                       id="winding_direction_yes"
                                       {{ in_array(old('winding_direction', $workOrder->winding_direction ?? 'no'), ['clockwise', 'counterclockwise']) ? 'checked' : '' }}
                                       onchange="toggleWindingDirectionOptions()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">يوجد</span>
                            </label>
                        </div>
                        
                        <!-- Winding Direction Options (shown when "يوجد" is selected) -->
                        <div id="winding_direction_options" style="display: {{ in_array(old('winding_direction', $workOrder->winding_direction ?? 'no'), ['clockwise', 'counterclockwise']) ? 'flex' : 'none' }}; gap: 2rem; margin-top: 1rem; padding-right: 1.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('winding_direction', $workOrder->winding_direction ?? 'no') == 'clockwise' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="clockwise" 
                                       id="winding_direction_clockwise"
                                       {{ old('winding_direction', $workOrder->winding_direction ?? 'no') == 'clockwise' ? 'checked' : '' }}
                                       onchange="handleWindingDirectionChange()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">في اتجاه عقارب الساعة</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('winding_direction', $workOrder->winding_direction ?? 'no') == 'counterclockwise' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="winding_direction" 
                                       value="counterclockwise" 
                                       id="winding_direction_counterclockwise"
                                       {{ old('winding_direction', $workOrder->winding_direction ?? 'no') == 'counterclockwise' ? 'checked' : '' }}
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
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('knife_exists', $workOrder->knife_exists ?? 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="knife_exists" 
                                       value="no" 
                                       id="knife_exists_no"
                                       {{ old('knife_exists', $workOrder->knife_exists ?? 'no') == 'no' ? 'checked' : '' }}
                                       onchange="toggleKnifePrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('knife_exists', $workOrder->knife_exists ?? 'no') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="knife_exists" 
                                       value="yes" 
                                       id="knife_exists_yes"
                                       {{ old('knife_exists', $workOrder->knife_exists ?? 'no') == 'yes' ? 'checked' : '' }}
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
                    <div id="knife_price_group" class="form-group" style="display: {{ old('knife_exists', $workOrder->knife_exists ?? 'no') == 'yes' ? 'block' : 'none' }};">
                        <label for="knife_price" class="form-label">سعر السكينة</label>
                        <input type="number" 
                               name="knife_price" 
                               id="knife_price" 
                               value="{{ old('knife_price', $workOrder->knife_price) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               {{ old('knife_exists', $workOrder->knife_exists ?? 'no') == 'yes' ? 'required' : '' }}>
                        @error('knife_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- External Breaking -->
                    <div class="form-group">
                        <label class="form-label">التكسير الخارجي</label>
                        <div style="display: flex; gap: 2rem; margin-top: 0.5rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('external_breaking', $workOrder->external_breaking ?? 'no') == 'no' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="external_breaking" 
                                       value="no" 
                                       id="external_breaking_no"
                                       {{ old('external_breaking', $workOrder->external_breaking ?? 'no') == 'no' ? 'checked' : '' }}
                                       onchange="toggleExternalBreakingPrice()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">لا يوجد</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('external_breaking', $workOrder->external_breaking ?? 'no') == 'yes' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="external_breaking" 
                                       value="yes" 
                                       id="external_breaking_yes"
                                       {{ old('external_breaking', $workOrder->external_breaking ?? 'no') == 'yes' ? 'checked' : '' }}
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
                    <div id="external_breaking_price_group" class="form-group" style="display: {{ old('external_breaking', $workOrder->external_breaking ?? 'no') == 'yes' ? 'block' : 'none' }};">
                        <label for="external_breaking_price" class="form-label">سعر التكسير الخارجي</label>
                        <input type="number" 
                               name="external_breaking_price" 
                               id="external_breaking_price" 
                               value="{{ old('external_breaking_price', $workOrder->external_breaking_price) }}" 
                               step="0.01"
                               min="0"
                               class="form-input"
                               placeholder="0.00"
                               {{ old('external_breaking', $workOrder->external_breaking ?? 'no') == 'yes' ? 'required' : '' }}>
                        @error('external_breaking_price')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- التجهيزات -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">التجهيزات</h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="film_price" class="form-label">سعر الفيلم الواحد</label>
                            <input type="number" 
                                   name="film_price" 
                                   id="film_price" 
                                   value="{{ old('film_price', $workOrder->film_price) }}" 
                                   step="0.01"
                                   min="0"
                                   class="form-input"
                                   placeholder="0.00">
                            @error('film_price')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="film_count" class="form-label">العدد</label>
                            <input type="number" 
                                   name="film_count" 
                                   id="film_count" 
                                   value="{{ old('film_count', $workOrder->film_count) }}" 
                                   min="1"
                                   class="form-input"
                                   placeholder="أدخل العدد">
                            @error('film_count')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sales Percentage -->
                    <div class="form-group">
                        <label for="sales_percentage" class="form-label">نسبة المبيعات</label>
                        <input type="number" 
                               name="sales_percentage" 
                               id="sales_percentage" 
                               value="{{ old('sales_percentage', $workOrder->sales_percentage) }}" 
                               step="0.01"
                               min="0"
                               max="100"
                               class="form-input"
                               placeholder="0.00">
                        @error('sales_percentage')
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
                                   value="{{ old('material_price_per_meter', $workOrder->material_price_per_meter) }}" 
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
                                   value="{{ old('manufacturing_price_per_meter', $workOrder->manufacturing_price_per_meter) }}" 
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
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('final_product_shape', $workOrder->final_product_shape) == 'بكر' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="بكر" 
                                       id="final_product_shape_roll"
                                       {{ old('final_product_shape', $workOrder->final_product_shape) == 'بكر' ? 'checked' : '' }}
                                       onchange="toggleProductionFields()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #2563eb;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">بكر</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.75rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; {{ old('final_product_shape', $workOrder->final_product_shape) == 'شيت' ? 'border-color: #2563eb; background-color: #eff6ff;' : '' }}">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="شيت" 
                                       id="final_product_shape_sheet"
                                       {{ old('final_product_shape', $workOrder->final_product_shape) == 'شيت' ? 'checked' : '' }}
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
                        <div id="roll-production-fields" style="display: {{ old('final_product_shape', $workOrder->final_product_shape) == 'بكر' ? 'block' : 'none' }};">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="number_of_rolls" class="form-label">عدد التكت في البكره</label>
                                    <input type="number"
                                           name="number_of_rolls"
                                           id="number_of_rolls"
                                           value="{{ old('number_of_rolls', $workOrder->number_of_rolls) }}"
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
                                        <option value="76" {{ old('core_size', $workOrder->core_size) == '76' ? 'selected' : '' }}>76</option>
                                        <option value="40" {{ old('core_size', $workOrder->core_size) == '40' ? 'selected' : '' }}>40</option>
                                        <option value="25" {{ old('core_size', $workOrder->core_size) == '25' ? 'selected' : '' }}>25</option>
                                    </select>
                                    @error('core_size')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sheet Fields (شيت) -->
                        <div id="sheet-production-fields" style="display: {{ old('final_product_shape', $workOrder->final_product_shape) == 'شيت' ? 'block' : 'none' }};">
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
                                  class="form-textarea">{{ old('notes', $workOrder->notes) }}</textarea>
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
                        حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
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

            // Initialize price fields on page load
            toggleFingerprintPrice();
            toggleKnifePrice();
            toggleExternalBreakingPrice();

            // Initialize production fields on page load
            toggleProductionFields();
            
            // Initialize addition price on page load
            updateAdditionPrice();
            
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
                    priceInput.removeAttribute('required');
                }
            }
        }

        // Toggle fingerprint price field
        function toggleFingerprintPrice() {
            const fingerprintYes = document.getElementById('fingerprint_yes');
            const priceGroup = document.getElementById('fingerprint_price_group');
            const priceInput = document.getElementById('fingerprint_price');
            
            if (fingerprintYes && fingerprintYes.checked) {
                if (priceGroup) priceGroup.style.display = 'block';
                if (priceInput) priceInput.setAttribute('required', 'required');
            } else {
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
        }

        // Toggle knife price field
        function toggleKnifePrice() {
            const knifeYes = document.getElementById('knife_exists_yes');
            const priceGroup = document.getElementById('knife_price_group');
            const priceInput = document.getElementById('knife_price');
            
            if (knifeYes && knifeYes.checked) {
                if (priceGroup) priceGroup.style.display = 'block';
                if (priceInput) priceInput.setAttribute('required', 'required');
            } else {
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
        }

        // Toggle external breaking price field
        function toggleExternalBreakingPrice() {
            const externalBreakingYes = document.getElementById('external_breaking_yes');
            const priceGroup = document.getElementById('external_breaking_price_group');
            const priceInput = document.getElementById('external_breaking_price');
            
            if (externalBreakingYes && externalBreakingYes.checked) {
                if (priceGroup) priceGroup.style.display = 'block';
                if (priceInput) priceInput.setAttribute('required', 'required');
            } else {
                if (priceGroup) priceGroup.style.display = 'none';
                if (priceInput) {
                    priceInput.value = '';
                    priceInput.removeAttribute('required');
                }
            }
        }

        // Calculate paper width automatically
        function calculatePaperWidth() {
            const rowsCountInput = document.getElementById('rows_count');
            const widthInput = document.getElementById('width');
            const paperWidthInput = document.getElementById('paper_width');
            
            const rowsCount = parseFloat(rowsCountInput.value) || 0;
            const width = parseFloat(widthInput.value) || 0;
            
            // Formula: (العرض × عدد الصفوف) + (عدد الصفوف - 1) + 0.3 + 1.2
            if (rowsCount > 0 && width > 0) {
                const paperWidth = (width * rowsCount) + (rowsCount - 1) + 0.3 + 1.2;
                if (paperWidthInput) {
                    paperWidthInput.value = paperWidth.toFixed(2);
                }
            } else {
                if (paperWidthInput) {
                    paperWidthInput.value = '';
                }
            }
        }

        // Initialize paper width calculation on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculatePaperWidth();
        });

    </script>
</x-app-layout>




