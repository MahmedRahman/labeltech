<x-app-layout>
    @php
        $title = 'قائمة السكاكين';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة السكاكين</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع السكاكين في المطبعة</p>
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
        </div>
    </div>

    <!-- Statistics Card -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">إجمالي السكاكين</div>
            <div style="font-size: 2rem; font-weight: 700; color: #111827;">{{ $totalKnives }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <form method="GET" action="{{ route('knives.index') }}">
            <!-- Filter by Type - Full Width Row -->
            <div style="margin-bottom: 1.5rem;">
                <label for="filter_type" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">النوع</label>
                <select name="filter_type" 
                        id="filter_type" 
                        style="width: 100%; max-width: 300px; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                    <option value="">جميع الأنواع</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('filter_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by Length and Width - Same Row -->
            <div id="lengthWidthRow" style="display: {{ request('filter_type') ? 'grid' : 'none' }}; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Filter by Length -->
                <div>
                    <label for="filter_length" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">الطول</label>
                    <select name="filter_length" 
                            id="filter_length" 
                            style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                        <option value="">جميع الأطوال</option>
                        @foreach($lengths as $length)
                            <option value="{{ $length }}" {{ request('filter_length') == $length ? 'selected' : '' }}>{{ number_format($length, 2) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Width -->
                <div>
                    <label for="filter_width" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">العرض</label>
                    <select name="filter_width" 
                            id="filter_width" 
                            style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                        <option value="">جميع الأعراض</option>
                        @foreach($widths as $width)
                            <option value="{{ $width }}" {{ request('filter_width') == $width ? 'selected' : '' }}>{{ number_format($width, 2) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Filter by Dragile Drive - Full Width Row -->
            <div id="dragileDriveRow" style="display: {{ request('filter_type') ? 'block' : 'none' }}; margin-bottom: 1.5rem;">
                <label for="filter_dragile_drive" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">درافيل</label>
                <select name="filter_dragile_drive" 
                        id="filter_dragile_drive" 
                        style="width: 100%; max-width: 300px; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                    <option value="">جميع درافيل</option>
                    @foreach($dragileDrives as $dragileDrive)
                        <option value="{{ $dragileDrive }}" {{ request('filter_dragile_drive') == $dragileDrive ? 'selected' : '' }}>{{ $dragileDrive }}</option>
                    @endforeach
                </select>
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
                <table class="table">
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
                                        <a href="{{ route('knives.edit', $knife) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('knives.destroy', $knife) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذه السكينة؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $knives->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد سكاكين</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة سكينة جديدة</p>
                    <a href="{{ route('knives.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة سكينة جديدة
                    </a>
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
                    <ul style="font-size: 0.875rem; color: #6b7280; margin: 0; padding-right: 1.25rem;">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterType = document.getElementById('filter_type');
            const filterLength = document.getElementById('filter_length');
            const filterWidth = document.getElementById('filter_width');
            const filterDragileDrive = document.getElementById('filter_dragile_drive');
            const lengthWidthRow = document.getElementById('lengthWidthRow');
            const dragileDriveRow = document.getElementById('dragileDriveRow');

            // Function to update filter options based on selected type
            function updateFilterOptions(type) {
                if (!type || type === '') {
                    // Hide filter rows and clear options
                    lengthWidthRow.style.display = 'none';
                    dragileDriveRow.style.display = 'none';
                    filterLength.innerHTML = '<option value="">جميع الأطوال</option>';
                    filterWidth.innerHTML = '<option value="">جميع الأعراض</option>';
                    filterDragileDrive.innerHTML = '<option value="">جميع درافيل</option>';
                    return;
                }

                // Show filter rows
                lengthWidthRow.style.display = 'grid';
                dragileDriveRow.style.display = 'block';

                // Fetch filter values from server
                fetch(`{{ route('knives.get-filter-values') }}?type=${encodeURIComponent(type)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update Length options
                        filterLength.innerHTML = '<option value="">جميع الأطوال</option>';
                        data.lengths.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.value;
                            option.textContent = item.label;
                            // Preserve selected value if it exists
                            if (option.value === '{{ request('filter_length') }}') {
                                option.selected = true;
                            }
                            filterLength.appendChild(option);
                        });

                        // Update Width options
                        filterWidth.innerHTML = '<option value="">جميع الأعراض</option>';
                        data.widths.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.value;
                            option.textContent = item.label;
                            // Preserve selected value if it exists
                            if (option.value === '{{ request('filter_width') }}') {
                                option.selected = true;
                            }
                            filterWidth.appendChild(option);
                        });

                        // Update Dragile Drive options
                        filterDragileDrive.innerHTML = '<option value="">جميع درافيل</option>';
                        data.dragileDrives.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.value;
                            option.textContent = item.label;
                            // Preserve selected value if it exists
                            if (option.value === '{{ request('filter_dragile_drive') }}') {
                                option.selected = true;
                            }
                            filterDragileDrive.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching filter values:', error);
                    });
            }

            // Listen to type change
            filterType.addEventListener('change', function() {
                updateFilterOptions(this.value);
            });

            // Initialize on page load if type is already selected
            if (filterType.value) {
                updateFilterOptions(filterType.value);
            }
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
            const filterType = document.getElementById('filter_type').value;
            const filterLength = document.getElementById('filter_length').value;
            const filterWidth = document.getElementById('filter_width').value;
            const filterDragileDrive = document.getElementById('filter_dragile_drive').value;

            if (filterType) params.append('filter_type', filterType);
            if (filterLength) params.append('filter_length', filterLength);
            if (filterWidth) params.append('filter_width', filterWidth);
            if (filterDragileDrive) params.append('filter_dragile_drive', filterDragileDrive);

            const exportLink = document.getElementById('exportLink');
            const baseUrl = '{{ route('knives.export') }}';
            exportLink.href = params.toString() ? `${baseUrl}?${params.toString()}` : baseUrl;
        }

        // Update export link when filters change
        document.getElementById('filter_type').addEventListener('change', updateExportLink);
        document.getElementById('filter_length').addEventListener('change', updateExportLink);
        document.getElementById('filter_width').addEventListener('change', updateExportLink);
        document.getElementById('filter_dragile_drive').addEventListener('change', updateExportLink);

        // Function to print filtered data
        function printFilteredData() {
            const table = document.querySelector('.table');
            
            if (!table) {
                alert('لا توجد بيانات للطباعة');
                return;
            }

            // Clone the table and remove actions column
            const clonedTable = table.cloneNode(true);
            const rows = clonedTable.querySelectorAll('tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('th, td');
                // Remove last cell (actions column)
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
                        ${document.getElementById('filter_type').value ? `النوع: ${document.getElementById('filter_type').options[document.getElementById('filter_type').selectedIndex].text}` : ''}
                        ${document.getElementById('filter_length').value ? ` | الطول: ${document.getElementById('filter_length').options[document.getElementById('filter_length').selectedIndex].text}` : ''}
                        ${document.getElementById('filter_width').value ? ` | العرض: ${document.getElementById('filter_width').options[document.getElementById('filter_width').selectedIndex].text}` : ''}
                        ${document.getElementById('filter_dragile_drive').value ? ` | درافيل: ${document.getElementById('filter_dragile_drive').options[document.getElementById('filter_dragile_drive').selectedIndex].text}` : ''}
                        ${!document.getElementById('filter_type').value && !document.getElementById('filter_length').value && !document.getElementById('filter_width').value && !document.getElementById('filter_dragile_drive').value ? 'جميع السكاكين' : ''}
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

