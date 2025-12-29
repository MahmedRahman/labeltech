<x-app-layout>
    @php
        $title = 'قائمة السكاكين';
        $isEmployee = auth('employee')->check();
        $employeeAccountType = $isEmployee ? auth('employee')->user()->account_type : null;
        $isDesignEmployee = $isEmployee && $employeeAccountType === 'تصميم';
    @endphp

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <style>
        /* Select2 RTL and styling */
        .select2-container {
            width: 100% !important;
            direction: rtl;
        }
        
        .select2-container--default .select2-selection--single {
            height: 50px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.875rem 1.125rem !important;
            font-size: 1.125rem !important;
            line-height: 1.5 !important;
            direction: rtl !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 50px !important;
            padding-right: 20px !important;
            padding-left: 40px !important;
            font-size: 1.125rem !important;
            text-align: right !important;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
            right: auto !important;
            left: 10px !important;
        }
        
        .select2-container--default .select2-results__option {
            padding: 0.75rem 1rem !important;
            font-size: 1.125rem !important;
            line-height: 1.5 !important;
            text-align: right !important;
        }
        
        .select2-container--default .select2-results__option--highlighted {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
        }
        
        .select2-dropdown {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            direction: rtl !important;
        }
        
        .select2-search--dropdown .select2-search__field {
            padding: 0.75rem !important;
            font-size: 1.125rem !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            direction: rtl !important;
            text-align: right !important;
        }
        
        /* SweetAlert2 RTL */
        .rtl-popup {
            direction: rtl;
            text-align: right;
        }
        
        .swal2-popup {
            font-family: 'Tajawal', 'Tahoma', 'Arial', sans-serif;
        }
        
        .swal2-title {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .swal2-html-container {
            font-size: 1.125rem;
        }
        
        .swal2-confirm, .swal2-cancel {
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }
        
        /* DataTables RTL */
        .dataTables_wrapper {
            direction: rtl;
        }
        
        .dataTables_filter {
            text-align: left;
            margin-bottom: 1rem;
        }
        
        .dataTables_filter input {
            margin-right: 0.5rem;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
        }
        
        .dataTables_length {
            text-align: right;
            margin-bottom: 1rem;
        }
        
        .dataTables_length select {
            margin: 0 0.5rem;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
        }
        
        .dataTables_info {
            text-align: right;
            padding-top: 1rem;
        }
        
        .dataTables_paginate {
            text-align: left;
            padding-top: 1rem;
        }
        
        .dataTables_paginate .paginate_button {
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            cursor: pointer;
        }
        
        .dataTables_paginate .paginate_button:hover {
            background-color: #f3f4f6;
        }
        
        .dataTables_paginate .paginate_button.current {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">قائمة السكاكين</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">إدارة جميع السكاكين في المطبعة</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <button type="button" onclick="printFilteredData()" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6366f1; color: white; text-decoration: none; border: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer;">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                طباعة
            </button>
            <a href="{{ route('knives.export', request()->query()) }}" id="exportLink" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                تصدير Excel
            </a>
            @if(!$isDesignEmployee)
                <button type="button" onclick="document.getElementById('importModal').style.display='block'" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #f59e0b; color: white; text-decoration: none; border: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer;">
                    <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    استيراد CSV
                </button>
                <a href="{{ route('knives.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                    <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    إضافة سكينة جديدة
                </a>
                @if($totalKnives > 0)
                <form action="{{ route('knives.delete-all') }}" method="POST" style="display: inline;" id="deleteAllForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDeleteAll(event)" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #dc2626; color: white; text-decoration: none; border: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        حذف الكل
                    </button>
                </form>
                @endif
            @endif
        </div>
    </div>

    <!-- Statistics Card -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 1rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem;">إجمالي السكاكين</div>
            <div style="font-size: 2rem; font-weight: 700; color: #111827;">{{ $totalKnives }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <form method="GET" action="{{ route('knives.index') }}" id="filterForm">
            <!-- Filter by Type - Cards -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.0625rem; font-weight: 600; color: #374151; margin-bottom: 1rem;">النوع</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <!-- All Types Card -->
                    <label class="type-card" style="
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 1.5rem 1rem;
                        border: 2px solid {{ !request('filter_type') ? '#2563eb' : '#e5e7eb' }};
                        border-radius: 0.75rem;
                        background-color: {{ !request('filter_type') ? '#eff6ff' : '#ffffff' }};
                        cursor: pointer;
                        transition: all 0.2s;
                        text-align: center;
                        min-height: 120px;
                        box-shadow: {{ !request('filter_type') ? '0 4px 6px rgba(0, 0, 0, 0.1)' : '0 1px 3px rgba(0, 0, 0, 0.05)' }};
                    " onmouseover="if(!this.querySelector('input[type=radio]').checked) { this.style.borderColor='#2563eb'; this.style.backgroundColor='#eff6ff'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'; }" onmouseout="if(!this.querySelector('input[type=radio]').checked) { this.style.borderColor='#e5e7eb'; this.style.backgroundColor='#ffffff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.05)'; }">
                        <input type="radio" name="filter_type" value="" {{ !request('filter_type') ? 'checked' : '' }} style="display: none;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">📋</div>
                        <div style="font-size: 1.125rem; font-weight: 600; color: #111827;">جميع الأنواع</div>
                    </label>
                    
                    @php
                        $typeIcons = [
                            'مستطيل' => '📐',
                            'دائرة' => '⭕',
                            'مربع' => '⬜',
                            'بيضاوي' => '🔵',
                            'شكل خاص' => '⭐',
                        ];
                        $typeColors = [
                            'مستطيل' => ['border' => '#3b82f6', 'bg' => '#dbeafe'],
                            'دائرة' => ['border' => '#10b981', 'bg' => '#d1fae5'],
                            'مربع' => ['border' => '#f59e0b', 'bg' => '#fef3c7'],
                            'بيضاوي' => ['border' => '#8b5cf6', 'bg' => '#ede9fe'],
                            'شكل خاص' => ['border' => '#ec4899', 'bg' => '#fce7f3'],
                        ];
                    @endphp
                    
                    @foreach($types as $type)
                        @php
                            $isSelected = request('filter_type') == $type;
                            $icon = $typeIcons[$type] ?? '📌';
                            $colors = $typeColors[$type] ?? ['border' => '#6b7280', 'bg' => '#f3f4f6'];
                        @endphp
                        <label class="type-card" style="
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            justify-content: center;
                            padding: 1.5rem 1rem;
                            border: 2px solid {{ $isSelected ? $colors['border'] : '#e5e7eb' }};
                            border-radius: 0.75rem;
                            background-color: {{ $isSelected ? $colors['bg'] : '#ffffff' }};
                            cursor: pointer;
                            transition: all 0.2s;
                            text-align: center;
                            min-height: 120px;
                            box-shadow: {{ $isSelected ? '0 4px 6px rgba(0, 0, 0, 0.1)' : '0 1px 3px rgba(0, 0, 0, 0.05)' }};
                        " onmouseover="if(!this.querySelector('input[type=radio]').checked) { this.style.borderColor='{{ $colors['border'] }}'; this.style.backgroundColor='{{ $colors['bg'] }}'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'; }" onmouseout="if(!this.querySelector('input[type=radio]').checked) { this.style.borderColor='#e5e7eb'; this.style.backgroundColor='#ffffff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.05)'; }">
                            <input type="radio" name="filter_type" value="{{ $type }}" {{ $isSelected ? 'checked' : '' }} style="display: none;">
                            <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">{{ $icon }}</div>
                            <div style="font-size: 1.125rem; font-weight: 600; color: #111827;">{{ $type }}</div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Filter by Length - Cards -->
            <div id="lengthRow" style="display: {{ (request('filter_type') && request('filter_type') != '') ? 'block' : 'none' }}; margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.0625rem; font-weight: 600; color: #374151; margin-bottom: 1rem;">الطول</label>
                <div id="lengthCardsContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem;">
                    <!-- Length cards will be generated dynamically via JavaScript -->
                </div>
                <!-- Hidden input to store selected length value -->
                <input type="hidden" name="filter_length" id="filter_length" value="{{ request('filter_length') }}">
            </div>

            <!-- Filter by Width - Cards -->
            <div id="widthRow" style="display: {{ (request('filter_type') && request('filter_length')) ? 'block' : 'none' }}; margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.0625rem; font-weight: 600; color: #374151; margin-bottom: 1rem;">العرض</label>
                <div id="widthCardsContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem;">
                    <!-- Width cards will be generated dynamically via JavaScript -->
                </div>
                <!-- Hidden input to store selected width value -->
                <input type="hidden" name="filter_width" id="filter_width" value="{{ request('filter_width') }}">
            </div>

            <!-- Filter by Dragile Drive - Cards -->
            <div id="dragileDriveRow" style="display: {{ (request('filter_type') && request('filter_length') && request('filter_width')) ? 'block' : 'none' }}; margin-bottom: 2rem;">
                <label style="display: block; font-size: 1.0625rem; font-weight: 600; color: #374151; margin-bottom: 1rem;">درافيل</label>
                <div id="dragileDriveCardsContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem;">
                    <!-- Dragile drive cards will be generated dynamically via JavaScript -->
                </div>
                <!-- Hidden input to store selected dragile drive value -->
                <input type="hidden" name="filter_dragile_drive" id="filter_dragile_drive" value="{{ request('filter_dragile_drive') }}">
            </div>

            <!-- Filter Actions -->
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" style="padding: 0.625rem 1.5rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.15s;">
                    تطبيق الفلترة
                </button>
                @if(request()->hasAny(['filter_type', 'filter_width', 'filter_length', 'filter_dragile_drive']))
                    <a href="{{ route('knives.index') }}" style="padding: 0.625rem 1.5rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-align: center; display: flex; align-items: center; justify-content: center;">
                        إلغاء الفلترة
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($knives->count() > 0)
                <table class="table" id="knivesTable">
                    <thead>
                        <tr>
                            <th>الرقم الكود</th>
                            <th>النوع</th>
                            <th>تُرس</th>
                            <th>دراغيل</th>
                            <th>عدد الصفوف</th>
                            <th>عدد العيون</th>
                            <th>الجيب</th>
                            <th>الطول</th>
                            <th>العرض</th>
                            <th>الملاحظات</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($knives as $knife)
                            <tr>
                                <td style="font-weight: 600; color: #2563eb;">{{ $knife->knife_code }}</td>
                                <td style="color: #6b7280;">{{ $knife->type ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->gear ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->dragile_drive ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->rows_count ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->eyes_count ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->flap_size ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->length ? number_format($knife->length, 2) : '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->width ? number_format($knife->width, 2) : '-' }}</td>
                                <td style="color: #6b7280; max-width: 200px;">{{ $knife->notes ? Str::limit($knife->notes, 50) : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('knives.show', $knife) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        @if(!$isDesignEmployee)
                                            <a href="{{ route('knives.edit', $knife) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                            <form action="{{ route('knives.destroy', $knife) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirmDelete(event, '{{ $knife->knife_code }}')">حذف</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد سكاكين</h3>
                    <p style="font-size: 1rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة سكينة جديدة</p>
                    @if(!$isDesignEmployee)
                        <a href="{{ route('knives.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            إضافة سكينة جديدة
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
        <div style="background-color: white; margin: 5% auto; padding: 2rem; border-radius: 0.5rem; width: 90%; max-width: 500px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0;">استيراد السكاكين من CSV</h3>
                <button onclick="document.getElementById('importModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">&times;</button>
            </div>
            
            <form action="{{ route('knives.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <label for="csv_file" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">اختر ملف CSV</label>
                    <input type="file" 
                           name="csv_file" 
                           id="csv_file" 
                           accept=".csv,.txt"
                           required
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    @error('csv_file')
                        <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
                    <p style="font-size: 0.875rem; color: #374151; margin: 0 0 0.5rem 0; font-weight: 500;">ملاحظات:</p>
                    <ul style="font-size: 1rem; color: #6b7280; margin: 0; padding-right: 1.25rem;">
                        <li>يجب أن يحتوي الملف على رأس الأعمدة في السطر الأول</li>
                        <li>الرقم الكود مطلوب لكل سكينة</li>
                        <li>إذا كان الرقم الكود موجوداً، سيتم تحديث البيانات</li>
                        <li>إذا كان الرقم الكود غير موجود، سيتم إنشاء سكينة جديدة</li>
                        <li><strong>الجاب سيتم حسابه تلقائياً من درافيل والطول - لا تضعه في الملف</strong></li>
                    </ul>
                </div>

                <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                    <button type="button" 
                            onclick="document.getElementById('importModal').style.display='none'" 
                            style="padding: 0.625rem 1.5rem; background-color: #6b7280; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">
                        إلغاء
                    </button>
                    <button type="submit" 
                            style="padding: 0.625rem 1.5rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">
                        استيراد
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('import_errors') && count(session('import_errors')) > 0)
        <div style="position: fixed; bottom: 20px; left: 20px; right: 20px; max-width: 500px; margin: 0 auto; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 0.5rem; padding: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); z-index: 1001;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                <h4 style="font-size: 0.875rem; font-weight: 600; color: #991b1b; margin: 0;">أخطاء في الاستيراد:</h4>
                <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: #991b1b; cursor: pointer; font-size: 1.25rem; padding: 0;">&times;</button>
            </div>
            <ul style="font-size: 0.875rem; color: #7f1d1d; margin: 0; padding-right: 1.25rem; max-height: 200px; overflow-y: auto;">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

    <script>
        // Show success/error messages from session using SweetAlert2
        @if(session('success'))
            Swal.fire({
                title: 'نجح!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'حسناً',
                customClass: {
                    popup: 'rtl-popup'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'خطأ!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#dc2626',
                customClass: {
                    popup: 'rtl-popup'
                }
            });
        @endif

        @if(session('import_errors') && count(session('import_errors')) > 0)
            const errors = @json(session('import_errors'));
            let errorsHtml = '<ul style="text-align: right; padding-right: 1.5rem; margin: 1rem 0;">';
            errors.forEach(error => {
                errorsHtml += `<li style="margin-bottom: 0.5rem;">${error}</li>`;
            });
            errorsHtml += '</ul>';
            
            Swal.fire({
                title: 'أخطاء في الاستيراد',
                html: errorsHtml,
                icon: 'error',
                confirmButtonText: 'حسناً',
                confirmButtonColor: '#dc2626',
                width: '600px',
                customClass: {
                    popup: 'rtl-popup',
                    htmlContainer: 'text-right'
                }
            });
        @endif

        $(document).ready(function() {
            // Initialize DataTables
            if ($('#knivesTable').length) {
                $('#knivesTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
                    },
                    order: [[0, 'asc']], // Sort by first column (الرقم الكود) ascending
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "الكل"]],
                    responsive: true,
                    dom: '<"top"lf>rt<"bottom"ip><"clear">',
                    columnDefs: [
                        { orderable: true, targets: '_all' },
                        { orderable: false, targets: -1 } // Disable sorting on last column (الإجراءات)
                    ]
                });
            }
            
            // Initialize Select2 (not needed anymore as all filters are cards)
            function initSelect2() {
                // No select elements need Select2 anymore
            }
            
            // Initialize Select2 on page load
            initSelect2();

            const filterTypeRadios = document.querySelectorAll('input[name="filter_type"]');
            const filterLength = document.getElementById('filter_length');
            const filterWidth = document.getElementById('filter_width');
            const filterDragileDrive = document.getElementById('filter_dragile_drive');
            const lengthRow = document.getElementById('lengthRow');
            const widthRow = document.getElementById('widthRow');
            const dragileDriveRow = document.getElementById('dragileDriveRow');
            const lengthCardsContainer = document.getElementById('lengthCardsContainer');
            const widthCardsContainer = document.getElementById('widthCardsContainer');
            const dragileDriveCardsContainer = document.getElementById('dragileDriveCardsContainer');
            
            // Store all filter data
            let allFilterData = {};
            
            // Load all filter data on page load
            function loadAllFilterData() {
                const routeUrl = '{{ route('knives.get-all-filter-data') }}';
                fetch(routeUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    allFilterData = data;
                    // Initialize filters after data is loaded
                    initializeFilters();
                })
                .catch(error => {
                    console.error('Error loading filter data:', error);
                });
            }
            
            // Function to create length cards
            function createLengthCards(lengths, selectedLength) {
                if (!lengthCardsContainer) return;
                
                lengthCardsContainer.innerHTML = '';
                
                if (!lengths || lengths.length === 0) {
                    lengthCardsContainer.innerHTML = '<p style="color: #6b7280; text-align: center; padding: 1rem;">لا توجد أطوال متاحة</p>';
                    return;
                }
                
                lengths.forEach(length => {
                    const lengthValue = length.value || length;
                    const lengthLabel = length.label || parseFloat(lengthValue).toFixed(2);
                    const isSelected = selectedLength === lengthValue;
                    
                    const card = document.createElement('label');
                    card.className = 'length-card';
                    card.style.cssText = `
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 1.25rem 1rem;
                        border: 2px solid ${isSelected ? '#2563eb' : '#e5e7eb'};
                        border-radius: 0.75rem;
                        background-color: ${isSelected ? '#eff6ff' : '#ffffff'};
                        cursor: pointer;
                        transition: all 0.2s;
                        text-align: center;
                        min-height: 100px;
                        box-shadow: ${isSelected ? '0 4px 6px rgba(0, 0, 0, 0.1)' : '0 1px 3px rgba(0, 0, 0, 0.05)'};
                    `;
                    
                    const radio = document.createElement('input');
                    radio.type = 'radio';
                    radio.name = 'filter_length_radio';
                    radio.value = lengthValue;
                    radio.checked = isSelected;
                    radio.style.display = 'none';
                    
                    card.onmouseover = function() {
                        const radio = this.querySelector('input[type="radio"]');
                        const currentlySelected = radio && radio.checked;
                        if (!currentlySelected) {
                            this.style.borderColor = '#2563eb';
                            this.style.backgroundColor = '#eff6ff';
                            this.style.transform = 'translateY(-2px)';
                            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                        }
                    };
                    
                    card.onmouseout = function() {
                        const radio = this.querySelector('input[type="radio"]');
                        const currentlySelected = radio && radio.checked;
                        if (!currentlySelected) {
                            this.style.borderColor = '#e5e7eb';
                            this.style.backgroundColor = '#ffffff';
                            this.style.transform = 'translateY(0)';
                            this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                        }
                    };
                    
                    card.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const radio = this.querySelector('input[type="radio"]');
                        if (radio) {
                            // Uncheck all other radios first
                            document.querySelectorAll('input[name="filter_length_radio"]').forEach(r => {
                                r.checked = false;
                            });
                            // Check the selected radio
                            radio.checked = true;
                            updateLengthCardsStyle();
                            const lengthValue = radio.value;
                            filterLength.value = lengthValue;
                            
                            // Reset width selection when length changes
                            filterWidth.value = '';
                            if (widthCardsContainer) {
                                widthCardsContainer.innerHTML = '';
                            }
                            document.querySelectorAll('input[name="filter_width_radio"]').forEach(r => {
                                r.checked = false;
                            });
                            // Hide dragile drive when length changes
                            dragileDriveRow.style.display = 'none';
                            filterDragileDrive.value = '';
                            if (dragileDriveCardsContainer) {
                                dragileDriveCardsContainer.innerHTML = '';
                            }
                            document.querySelectorAll('input[name="filter_dragile_drive_radio"]').forEach(r => {
                                r.checked = false;
                            });
                            
                            // Trigger change event manually
                            const changeEvent = new Event('change', { bubbles: true });
                            radio.dispatchEvent(changeEvent);
                            
                            // Update width cards based on selected length - show widths that match the selected length
                            const type = getSelectedType();
                            if (type && lengthValue) {
                                updateWidthCards(type, lengthValue, '');
                            }
                        }
                    };
                    
                    const icon = document.createElement('div');
                    icon.style.cssText = 'font-size: 2rem; margin-bottom: 0.5rem;';
                    icon.textContent = '📏';
                    
                    const label = document.createElement('div');
                    label.style.cssText = 'font-size: 1.125rem; font-weight: 600; color: #111827;';
                    label.textContent = lengthLabel;
                    
                    card.appendChild(radio);
                    card.appendChild(icon);
                    card.appendChild(label);
                    lengthCardsContainer.appendChild(card);
                });
            }
            
            // Function to update length cards style
            function updateLengthCardsStyle() {
                const selectedRadio = document.querySelector('input[name="filter_length_radio"]:checked');
                document.querySelectorAll('.length-card').forEach(card => {
                    const radio = card.querySelector('input[type="radio"]');
                    const isSelected = radio && radio.checked;
                    
                    if (isSelected) {
                        card.style.borderColor = '#2563eb';
                        card.style.backgroundColor = '#eff6ff';
                        card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                    } else {
                        card.style.borderColor = '#e5e7eb';
                        card.style.backgroundColor = '#ffffff';
                        card.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                    }
                });
            }
            
            // Update width cards based on selected type and length (client-side filtering)
            function updateWidthCards(type, length, selectedWidth) {
                if (!widthCardsContainer) return;
                
                widthCardsContainer.innerHTML = '';
                
                if (!type || !length || !allFilterData[type]) {
                    widthRow.style.display = 'none';
                    return;
                }
                
                // Get widths that match the selected length
                const typeData = allFilterData[type];
                const lengthWidthMap = typeData.lengthWidthMap || {};
                
                // Get widths available for the selected length
                const filteredWidths = lengthWidthMap[length] || [];
                
                if (filteredWidths.length === 0) {
                    widthCardsContainer.innerHTML = '<p style="color: #6b7280; text-align: center; padding: 1rem;">لا توجد أعراض متاحة لهذا الطول</p>';
                    widthRow.style.display = 'block';
                    return;
                }
                
                createWidthCards(filteredWidths, selectedWidth);
                widthRow.style.display = 'block';
            }
            
            // Function to create width cards
            function createWidthCards(widths, selectedWidth) {
                if (!widthCardsContainer) return;
                
                widthCardsContainer.innerHTML = '';
                
                if (!widths || widths.length === 0) {
                    widthCardsContainer.innerHTML = '<p style="color: #6b7280; text-align: center; padding: 1rem;">لا توجد أعراض متاحة</p>';
                    return;
                }
                
                widths.forEach(width => {
                    const widthValue = width.value || width;
                    const widthLabel = width.label || parseFloat(widthValue).toFixed(2);
                    const isSelected = selectedWidth === widthValue;
                    
                    const card = document.createElement('label');
                    card.className = 'width-card';
                    card.style.cssText = `
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 1.25rem 1rem;
                        border: 2px solid ${isSelected ? '#2563eb' : '#e5e7eb'};
                        border-radius: 0.75rem;
                        background-color: ${isSelected ? '#eff6ff' : '#ffffff'};
                        cursor: pointer;
                        transition: all 0.2s;
                        text-align: center;
                        min-height: 100px;
                        box-shadow: ${isSelected ? '0 4px 6px rgba(0, 0, 0, 0.1)' : '0 1px 3px rgba(0, 0, 0, 0.05)'};
                    `;
                    
                    const radio = document.createElement('input');
                    radio.type = 'radio';
                    radio.name = 'filter_width_radio';
                    radio.value = widthValue;
                    radio.checked = isSelected;
                    radio.style.display = 'none';
                    
                    card.onmouseover = function() {
                        const radio = this.querySelector('input[type="radio"]');
                        const currentlySelected = radio && radio.checked;
                        if (!currentlySelected) {
                            this.style.borderColor = '#2563eb';
                            this.style.backgroundColor = '#eff6ff';
                            this.style.transform = 'translateY(-2px)';
                            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                        }
                    };
                    
                    card.onmouseout = function() {
                        const radio = this.querySelector('input[type="radio"]');
                        const currentlySelected = radio && radio.checked;
                        if (!currentlySelected) {
                            this.style.borderColor = '#e5e7eb';
                            this.style.backgroundColor = '#ffffff';
                            this.style.transform = 'translateY(0)';
                            this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                        }
                    };
                    
                    card.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const radio = this.querySelector('input[type="radio"]');
                        if (radio) {
                            // Uncheck all other radios first
                            document.querySelectorAll('input[name="filter_width_radio"]').forEach(r => {
                                r.checked = false;
                            });
                            // Check the selected radio
                            radio.checked = true;
                            updateWidthCardsStyle();
                            const widthValue = radio.value;
                            filterWidth.value = widthValue;
                            
                            // Trigger change event manually
                            const changeEvent = new Event('change', { bubbles: true });
                            radio.dispatchEvent(changeEvent);
                            
                            // Load dragile drives from server
                            const type = getSelectedType();
                            const length = filterLength.value;
                            if (type && length && widthValue) {
                                loadDragileDrives(type, length, widthValue);
                            }
                        }
                    };
                    
                    const icon = document.createElement('div');
                    icon.style.cssText = 'font-size: 2rem; margin-bottom: 0.5rem;';
                    icon.textContent = '📐';
                    
                    const label = document.createElement('div');
                    label.style.cssText = 'font-size: 1.125rem; font-weight: 600; color: #111827;';
                    label.textContent = widthLabel;
                    
                    card.appendChild(radio);
                    card.appendChild(icon);
                    card.appendChild(label);
                    widthCardsContainer.appendChild(card);
                });
            }
            
            // Function to update width cards style
            function updateWidthCardsStyle() {
                const selectedRadio = document.querySelector('input[name="filter_width_radio"]:checked');
                document.querySelectorAll('.width-card').forEach(card => {
                    const radio = card.querySelector('input[type="radio"]');
                    const isSelected = radio && radio.checked;
                    
                    if (isSelected) {
                        card.style.borderColor = '#2563eb';
                        card.style.backgroundColor = '#eff6ff';
                        card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                    } else {
                        card.style.borderColor = '#e5e7eb';
                        card.style.backgroundColor = '#ffffff';
                        card.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                    }
                });
            }
            
            // Function to create dragile drive cards
            function createDragileDriveCards(dragileDrives, selectedDragileDrive) {
                if (!dragileDriveCardsContainer) return;
                
                dragileDriveCardsContainer.innerHTML = '';
                
                if (!dragileDrives || dragileDrives.length === 0) {
                    dragileDriveCardsContainer.innerHTML = '<p style="color: #6b7280; text-align: center; padding: 1rem;">لا توجد درافيل متاحة</p>';
                    return;
                }
                
                dragileDrives.forEach(dragileDrive => {
                    const driveValue = dragileDrive.value || dragileDrive;
                    const driveLabel = dragileDrive.label || driveValue;
                    const isSelected = selectedDragileDrive === driveValue;
                    
                    const card = document.createElement('label');
                    card.className = 'dragile-drive-card';
                    card.style.cssText = `
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        padding: 1.25rem 1rem;
                        border: 2px solid ${isSelected ? '#2563eb' : '#e5e7eb'};
                        border-radius: 0.75rem;
                        background-color: ${isSelected ? '#eff6ff' : '#ffffff'};
                        cursor: pointer;
                        transition: all 0.2s;
                        text-align: center;
                        min-height: 100px;
                        box-shadow: ${isSelected ? '0 4px 6px rgba(0, 0, 0, 0.1)' : '0 1px 3px rgba(0, 0, 0, 0.05)'};
                    `;
                    
                    const radio = document.createElement('input');
                    radio.type = 'radio';
                    radio.name = 'filter_dragile_drive_radio';
                    radio.value = driveValue;
                    radio.checked = isSelected;
                    radio.style.display = 'none';
                    
                    card.onmouseover = function() {
                        const radio = this.querySelector('input[type="radio"]');
                        const currentlySelected = radio && radio.checked;
                        if (!currentlySelected) {
                            this.style.borderColor = '#2563eb';
                            this.style.backgroundColor = '#eff6ff';
                            this.style.transform = 'translateY(-2px)';
                            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                        }
                    };
                    
                    card.onmouseout = function() {
                        const radio = this.querySelector('input[type="radio"]');
                        const currentlySelected = radio && radio.checked;
                        if (!currentlySelected) {
                            this.style.borderColor = '#e5e7eb';
                            this.style.backgroundColor = '#ffffff';
                            this.style.transform = 'translateY(0)';
                            this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                        }
                    };
                    
                    card.onclick = function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const radio = this.querySelector('input[type="radio"]');
                        if (radio) {
                            // Uncheck all other radios first
                            document.querySelectorAll('input[name="filter_dragile_drive_radio"]').forEach(r => {
                                r.checked = false;
                            });
                            // Check the selected radio
                            radio.checked = true;
                            updateDragileDriveCardsStyle();
                            const driveValue = radio.value;
                            filterDragileDrive.value = driveValue;
                            
                            // Submit form to search in database
                            const filterForm = document.getElementById('filterForm');
                            if (filterForm) {
                                filterForm.submit();
                            }
                        }
                    };
                    
                    const icon = document.createElement('div');
                    icon.style.cssText = 'font-size: 2rem; margin-bottom: 0.5rem;';
                    icon.textContent = '⚙️';
                    
                    const label = document.createElement('div');
                    label.style.cssText = 'font-size: 1.125rem; font-weight: 600; color: #111827;';
                    label.textContent = driveLabel;
                    
                    card.appendChild(radio);
                    card.appendChild(icon);
                    card.appendChild(label);
                    dragileDriveCardsContainer.appendChild(card);
                });
            }
            
            // Function to update dragile drive cards style
            function updateDragileDriveCardsStyle() {
                const selectedRadio = document.querySelector('input[name="filter_dragile_drive_radio"]:checked');
                document.querySelectorAll('.dragile-drive-card').forEach(card => {
                    const radio = card.querySelector('input[type="radio"]');
                    const isSelected = radio && radio.checked;
                    
                    if (isSelected) {
                        card.style.borderColor = '#2563eb';
                        card.style.backgroundColor = '#eff6ff';
                        card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                    } else {
                        card.style.borderColor = '#e5e7eb';
                        card.style.backgroundColor = '#ffffff';
                        card.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                    }
                });
            }

            // Function to get selected type
            function getSelectedType() {
                const selected = document.querySelector('input[name="filter_type"]:checked');
                return selected ? selected.value : '';
            }

            // Load dragile drives from server (only when width is selected)
            function loadDragileDrives(type, length, width) {
                if (!type || !length || !width) {
                    dragileDriveRow.style.display = 'none';
                    return;
                }
                
                const routeUrl = '{{ route('knives.get-filter-values') }}';
                const params = new URLSearchParams();
                params.append('type', type);
                params.append('length', length);
                params.append('width', width);
                
                fetch(`${routeUrl}?${params.toString()}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    // Get current dragile drive value
                    const currentDragileDrive = filterDragileDrive ? filterDragileDrive.value : '';
                    
                    // Create dragile drive cards
                    if (data.dragileDrives && data.dragileDrives.length > 0) {
                        createDragileDriveCards(data.dragileDrives, currentDragileDrive);
                    } else {
                        createDragileDriveCards([], '');
                    }
                    dragileDriveRow.style.display = 'block';
                    
                    return data;
                })
                .catch(error => {
                    console.error('Error loading dragile drives:', error);
                    throw error;
                });
            }
            
            // Initialize filters based on current selections
            function initializeFilters() {
                const currentType = getSelectedType();
                const currentLength = filterLength ? filterLength.value : '';
                const currentWidth = filterWidth ? filterWidth.value : '';
                const currentDragileDrive = filterDragileDrive ? filterDragileDrive.value : '';
                
                if (currentType && currentType !== '') {
                    lengthRow.style.display = 'block';
                    // Create length cards
                    if (allFilterData[currentType] && allFilterData[currentType].lengths) {
                        createLengthCards(allFilterData[currentType].lengths, currentLength);
                        // Select current length if exists
                        if (currentLength) {
                            setTimeout(() => {
                                const lengthRadio = document.querySelector(`input[name="filter_length_radio"][value="${currentLength}"]`);
                                if (lengthRadio) {
                                    lengthRadio.checked = true;
                                    updateLengthCardsStyle();
                                }
                            }, 100);
                        }
                    }
                    
                    if (currentLength) {
                        updateWidthCards(currentType, currentLength, currentWidth);
                        
                        if (currentWidth) {
                            loadDragileDrives(currentType, currentLength, currentWidth).then(() => {
                                // Select the current dragile drive after cards are created
                                if (currentDragileDrive) {
                                    setTimeout(() => {
                                        const driveRadio = document.querySelector(`input[name="filter_dragile_drive_radio"][value="${currentDragileDrive}"]`);
                                        if (driveRadio) {
                                            driveRadio.checked = true;
                                            updateDragileDriveCardsStyle();
                                        }
                                    }, 100);
                                }
                            });
                        }
                    }
                }
            }

            // Listen to type change (radio buttons)
            filterTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const type = this.value;
                    // Update card styles
                    document.querySelectorAll('.type-card').forEach(card => {
                        const cardRadio = card.querySelector('input[type="radio"]');
                        const isSelected = cardRadio.checked;
                        const cardType = cardRadio.value;
                        
                        if (cardType === '') {
                            // All types card
                            if (isSelected) {
                                card.style.borderColor = '#2563eb';
                                card.style.backgroundColor = '#eff6ff';
                            } else {
                                card.style.borderColor = '#e5e7eb';
                                card.style.backgroundColor = '#ffffff';
                            }
                        } else {
                            // Type cards
                            const typeColors = {
                                'مستطيل': { border: '#3b82f6', bg: '#dbeafe' },
                                'دائرة': { border: '#10b981', bg: '#d1fae5' },
                                'مربع': { border: '#f59e0b', bg: '#fef3c7' },
                                'بيضاوي': { border: '#8b5cf6', bg: '#ede9fe' },
                                'شكل خاص': { border: '#ec4899', bg: '#fce7f3' },
                            };
                            const colors = typeColors[cardType] || { border: '#6b7280', bg: '#f3f4f6' };
                            
                            if (isSelected) {
                                card.style.borderColor = colors.border;
                                card.style.backgroundColor = colors.bg;
                                card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
                            } else {
                                card.style.borderColor = '#e5e7eb';
                                card.style.backgroundColor = '#ffffff';
                                card.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                            }
                        }
                    });
                    
                    if (!type) {
                        // Hide all filter rows
                        lengthRow.style.display = 'none';
                        widthRow.style.display = 'none';
                        dragileDriveRow.style.display = 'none';
                        // Reset all filters
                        filterLength.value = '';
                        // Reset length cards
                        if (lengthCardsContainer) {
                            lengthCardsContainer.innerHTML = '';
                        }
                        // Uncheck all length radios
                        document.querySelectorAll('input[name="filter_length_radio"]').forEach(radio => {
                            radio.checked = false;
                        });
                        filterWidth.value = '';
                        if ($('#filter_width').hasClass('select2-hidden-accessible')) {
                            $('#filter_width').select2('destroy');
                        }
                        filterDragileDrive.value = '';
                        if ($('#filter_dragile_drive').hasClass('select2-hidden-accessible')) {
                            $('#filter_dragile_drive').select2('destroy');
                        }
                    } else {
                        // Show length cards and update them
                        lengthRow.style.display = 'block';
                        if (allFilterData[type] && allFilterData[type].lengths) {
                            createLengthCards(allFilterData[type].lengths, '');
                        }
                        // Reset width and dragile drive
                        filterWidth.value = '';
                        if (widthCardsContainer) {
                            widthCardsContainer.innerHTML = '';
                        }
                        document.querySelectorAll('input[name="filter_width_radio"]').forEach(radio => {
                            radio.checked = false;
                        });
                        widthRow.style.display = 'none';
                        filterDragileDrive.value = '';
                        if (dragileDriveCardsContainer) {
                            dragileDriveCardsContainer.innerHTML = '';
                        }
                        document.querySelectorAll('input[name="filter_dragile_drive_radio"]').forEach(radio => {
                            radio.checked = false;
                        });
                        dragileDriveRow.style.display = 'none';
                    }
                });
            });

            // Listen to length change (from cards)
            document.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'filter_length_radio') {
                    const type = getSelectedType();
                    const length = e.target.value;
                    filterLength.value = length;
                    updateLengthCardsStyle();
                    
                    if (!type || !length) {
                        widthRow.style.display = 'none';
                        dragileDriveRow.style.display = 'none';
                        filterWidth.value = '';
                        if (widthCardsContainer) {
                            widthCardsContainer.innerHTML = '';
                        }
                        document.querySelectorAll('input[name="filter_width_radio"]').forEach(radio => {
                            radio.checked = false;
                        });
                        filterDragileDrive.value = '';
                        if ($('#filter_dragile_drive').hasClass('select2-hidden-accessible')) {
                            $('#filter_dragile_drive').select2('destroy');
                        }
                        return;
                    }
                    
                    // Reset width selection when length changes
                    filterWidth.value = '';
                    if (widthCardsContainer) {
                        widthCardsContainer.innerHTML = '';
                    }
                    document.querySelectorAll('input[name="filter_width_radio"]').forEach(radio => {
                        radio.checked = false;
                    });
                    // Hide dragile drive when length changes
                    dragileDriveRow.style.display = 'none';
                    filterDragileDrive.value = '';
                    if ($('#filter_dragile_drive').hasClass('select2-hidden-accessible')) {
                        $('#filter_dragile_drive').select2('destroy');
                    }
                    
                    // Update width cards client-side (no reload) - show widths that match the selected length
                    updateWidthCards(type, length, '');
                }
            });

            // Listen to width change (from cards)
            document.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'filter_width_radio') {
                    const type = getSelectedType();
                    const length = filterLength.value;
                    const width = e.target.value;
                    filterWidth.value = width;
                    updateWidthCardsStyle();
                
                    if (!type || !length) {
                        dragileDriveRow.style.display = 'none';
                        filterDragileDrive.value = '';
                        if (dragileDriveCardsContainer) {
                            dragileDriveCardsContainer.innerHTML = '';
                        }
                        document.querySelectorAll('input[name="filter_dragile_drive_radio"]').forEach(radio => {
                            radio.checked = false;
                        });
                        return;
                    }
                    
                    if (!width) {
                        dragileDriveRow.style.display = 'none';
                        filterDragileDrive.value = '';
                        if (dragileDriveCardsContainer) {
                            dragileDriveCardsContainer.innerHTML = '';
                        }
                        document.querySelectorAll('input[name="filter_dragile_drive_radio"]').forEach(radio => {
                            radio.checked = false;
                        });
                    } else {
                        // Load dragile drives from server (only at this stage)
                        loadDragileDrives(type, length, width);
                    }
                }
            });
            
            // Dragile drive submit is handled in card onclick

            // Load all filter data on page load
            loadAllFilterData();
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('importModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Function to update export link with current filters
        function updateExportLink() {
            const params = new URLSearchParams();
            const filterTypeElement = document.getElementById('filter_type');
            const filterLengthElement = document.getElementById('filter_length');
            const filterWidthElement = document.getElementById('filter_width');
            const filterDragileDriveElement = document.getElementById('filter_dragile_drive');
            
            const filterType = filterTypeElement ? filterTypeElement.value : '';
            const filterLength = filterLengthElement ? filterLengthElement.value : '';
            const filterWidth = filterWidthElement ? filterWidthElement.value : '';
            const filterDragileDrive = filterDragileDriveElement ? filterDragileDriveElement.value : '';

            if (filterType) params.append('filter_type', filterType);
            if (filterLength) params.append('filter_length', filterLength);
            if (filterWidth) params.append('filter_width', filterWidth);
            if (filterDragileDrive) params.append('filter_dragile_drive', filterDragileDrive);

            const exportLink = document.getElementById('exportLink');
            const baseUrl = '{{ route('knives.export') }}';
            exportLink.href = params.toString() ? `${baseUrl}?${params.toString()}` : baseUrl;
        }

        // Update export link when filters change
        const filterTypeElement = document.getElementById('filter_type');
        const filterLengthElement = document.getElementById('filter_length');
        const filterWidthElement = document.getElementById('filter_width');
        const filterDragileDriveElement = document.getElementById('filter_dragile_drive');
        
        if (filterTypeElement) {
            filterTypeElement.addEventListener('change', updateExportLink);
        }
        if (filterLengthElement) {
            filterLengthElement.addEventListener('change', updateExportLink);
        }
        if (filterWidthElement) {
            filterWidthElement.addEventListener('change', updateExportLink);
        }
        if (filterDragileDriveElement) {
            filterDragileDriveElement.addEventListener('change', updateExportLink);
        }

        // Function to confirm delete all
        function confirmDeleteAll(event) {
            event.preventDefault();
            const totalKnives = {{ $totalKnives }};
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                html: `هل أنت متأكد من حذف جميع السكاكين (<strong>${totalKnives} سكينة</strong>)؟<br><br>هذا الإجراء لا يمكن التراجع عنه!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'نعم، احذف الكل',
                cancelButtonText: 'إلغاء',
                reverseButtons: true,
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteAllForm').submit();
                }
            });
            
            return false;
        }
        
        // Function to confirm delete single knife
        function confirmDelete(event, knifeCode) {
            event.preventDefault();
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                html: `هل أنت متأكد من حذف السكينة <strong>${knifeCode}</strong>؟`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                reverseButtons: true,
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest('form').submit();
                }
            });
            
            return false;
        }

        // Function to print filtered data
        function printFilteredData() {
            const table = $('#knivesTable');
            
            if (!table.length) {
                Swal.fire({
                    title: 'لا توجد بيانات',
                    text: 'لا توجد بيانات للطباعة',
                    icon: 'info',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        popup: 'rtl-popup'
                    }
                });
                return;
            }

            // Get DataTable instance
            const dataTable = table.DataTable();
            
            // Get visible rows (after search/filter)
            const visibleRows = dataTable.rows({search: 'applied'}).nodes();
            
            if (visibleRows.length === 0) {
                Swal.fire({
                    title: 'لا توجد بيانات',
                    text: 'لا توجد بيانات للطباعة',
                    icon: 'info',
                    confirmButtonText: 'حسناً',
                    customClass: {
                        popup: 'rtl-popup'
                    }
                });
                return;
            }

            // Clone the table
            const clonedTable = table[0].cloneNode(true);
            
            // Remove DataTables classes and attributes
            $(clonedTable).removeClass('dataTable').removeAttr('id').removeAttr('style');
            
            // Get all rows from cloned table
            const rows = clonedTable.querySelectorAll('tbody tr');
            
            // Remove rows that are not visible in DataTable
            Array.from(rows).forEach((row, index) => {
                if (!Array.from(visibleRows).includes(row)) {
                    row.remove();
                }
            });
            
            // Remove actions column from all rows
            const allRows = clonedTable.querySelectorAll('tr');
            allRows.forEach(row => {
                const cells = row.querySelectorAll('th, td');
                if (cells.length > 0) {
                    cells[cells.length - 1].remove();
                }
            });

            const printWindow = window.open('', '_blank');
            const printContent = `
                <!DOCTYPE html>
                <html dir="rtl" lang="ar">
                <head>
                    <meta charset="UTF-8">
                    <title>طباعة السكاكين</title>
                    <style>
                        @media print {
                            @page {
                                margin: 1cm;
                                size: A4 landscape;
                            }
                            body {
                                margin: 0;
                                padding: 0;
                            }
                        }
                        body {
                            font-family: 'Cairo', Arial, sans-serif;
                            direction: rtl;
                            padding: 20px;
                        }
                        h1 {
                            text-align: center;
                            margin-bottom: 20px;
                            font-size: 24px;
                            color: #111827;
                        }
                        .filters-info {
                            margin-bottom: 20px;
                            padding: 10px;
                            background-color: #f3f4f6;
                            border-radius: 5px;
                            font-size: 14px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            font-size: 11px;
                        }
                        th, td {
                            border: 1px solid #d1d5db;
                            padding: 6px;
                            text-align: right;
                        }
                        th {
                            background-color: #f9fafb;
                            font-weight: 600;
                            color: #111827;
                        }
                        tr:nth-child(even) {
                            background-color: #f9fafb;
                        }
                        .print-date {
                            text-align: left;
                            margin-top: 20px;
                            font-size: 12px;
                            color: #6b7280;
                        }
                    </style>
                </head>
                <body>
                    <h1>قائمة السكاكين</h1>
                    <div class="filters-info">
                        <strong>الفلاتر المطبقة:</strong>
                        ${(() => {
                            try {
                                const typeEl = document.getElementById('filter_type');
                                const lengthEl = document.getElementById('filter_length');
                                const widthEl = document.getElementById('filter_width');
                                const driveEl = document.getElementById('filter_dragile_drive');
                                
                                let filters = [];
                                if (typeEl) {
                                    const selectedType = document.querySelector('input[name="filter_type"]:checked');
                                    if (selectedType) {
                                        const typeCard = selectedType.closest('.type-card');
                                        if (typeCard) {
                                            const typeText = typeCard.querySelector('div:last-child')?.textContent || '';
                                            if (typeText) filters.push(`النوع: ${typeText}`);
                                        }
                                    }
                                }
                                if (lengthEl && lengthEl.value) {
                                    filters.push(`الطول: ${lengthEl.options[lengthEl.selectedIndex]?.text || lengthEl.value}`);
                                }
                                if (widthEl && widthEl.value) {
                                    filters.push(`العرض: ${widthEl.options[widthEl.selectedIndex]?.text || widthEl.value}`);
                                }
                                if (driveEl && driveEl.value) {
                                    filters.push(`درافيل: ${driveEl.options[driveEl.selectedIndex]?.text || driveEl.value}`);
                                }
                                return filters.length > 0 ? filters.join(' | ') : 'جميع السكاكين';
                            } catch (e) {
                                return 'جميع السكاكين';
                            }
                        })()}
                    </div>
                    ${clonedTable.outerHTML}
                    <div class="print-date">
                        تاريخ الطباعة: ${new Date().toLocaleString('ar-EG')}
                    </div>
                </body>
                </html>
            `;

            printWindow.document.write(printContent);
            printWindow.document.close();
            
            setTimeout(() => {
                printWindow.print();
            }, 250);
        }
    </script>
</x-app-layout>

