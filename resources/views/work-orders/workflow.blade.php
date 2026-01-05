<x-app-layout>
    @php
        $title = 'سير العمل';
    @endphp

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Select2 styling for filter dropdowns */
        #clientFilter + .select2-container,
        #orderNumberFilter + .select2-container {
            width: 100% !important;
            direction: rtl;
        }
        
        #clientFilter + .select2-container .select2-selection--single,
        #orderNumberFilter + .select2-container .select2-selection--single {
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
        
        #clientFilter + .select2-container .select2-selection--single:hover,
        #orderNumberFilter + .select2-container .select2-selection--single:hover {
            border-color: #9ca3af !important;
        }
        
        #clientFilter + .select2-container.select2-container--focus .select2-selection--single,
        #orderNumberFilter + .select2-container.select2-container--focus .select2-selection--single {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
            outline: none !important;
        }
        
        #clientFilter + .select2-container .select2-selection--single:hover,
        #orderNumberFilter + .select2-container .select2-selection--single:hover {
            border-color: #9ca3af !important;
        }
        
        #clientFilter + .select2-container .select2-selection--single .select2-selection__rendered,
        #orderNumberFilter + .select2-container .select2-selection--single .select2-selection__rendered {
            padding: 0.875rem 3rem 0.875rem 1rem !important;
            line-height: 1.5 !important;
            color: #111827 !important;
            direction: rtl !important;
            text-align: right !important;
            font-weight: 500 !important;
        }
        
        #clientFilter + .select2-container .select2-selection--single .select2-selection__placeholder,
        #orderNumberFilter + .select2-container .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
        }
        
        #clientFilter + .select2-container .select2-selection--single .select2-selection__arrow,
        #orderNumberFilter + .select2-container .select2-selection--single .select2-selection__arrow {
            height: 54px !important;
            right: auto !important;
            left: 12px !important;
            width: 20px !important;
        }
        
        #clientFilter + .select2-container .select2-selection--single .select2-selection__arrow b,
        #orderNumberFilter + .select2-container .select2-selection--single .select2-selection__arrow b {
            border-color: #6b7280 transparent transparent transparent !important;
            border-width: 5px 4px 0 4px !important;
            margin-top: -2.5px !important;
        }
        
        #clientFilter + .select2-container.select2-container--open .select2-selection--single .select2-selection__arrow b,
        #orderNumberFilter + .select2-container.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6b7280 transparent !important;
            border-width: 0 4px 5px 4px !important;
            margin-top: -2.5px !important;
        }
        
        .select2-dropdown {
            direction: rtl !important;
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
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
        }
        
        .select2-search--dropdown .select2-search__field:focus {
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) !important;
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
        }
        
        .select2-results__option--highlighted {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .status-card {
            background: white;
            border-radius: 0.75rem;
            border: 2px solid #e5e7eb;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .status-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status-card.active {
            border-color: #2563eb;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .status-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .status-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .status-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .data-table {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #f9fafb;
        }

        .data-table th {
            padding: 1rem;
            text-align: right;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        .data-table td {
            padding: 1rem;
            text-align: right;
            font-size: 0.875rem;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-table tbody tr {
            display: none;
        }

        .data-table tbody tr.show {
            display: table-row;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .btn-view {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-block;
            background-color: #2563eb;
            color: white;
        }

        .btn-view:hover {
            background-color: #1d4ed8;
        }

        .btn-edit {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-block;
            background-color: #10b981;
            color: white;
            margin-right: 0.5rem;
        }

        .btn-edit:hover {
            background-color: #059669;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .filter-section {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .filter-group {
            width: 100%;
        }

        .filter-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .filter-input,
        .filter-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .active-filter-info {
            background: #eff6ff;
            border: 1px solid #2563eb;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .active-filter-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #2563eb;
            margin: 0;
        }

        .clear-filter-btn {
            padding: 0.5rem 1rem;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
        }

        .clear-filter-btn:hover {
            background-color: #1d4ed8;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 0.75rem;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
        }

        .modal-close:hover {
            background-color: #f3f4f6;
            color: #111827;
        }

        .status-options {
            display: grid;
            gap: 0.75rem;
        }

        .status-option {
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .status-option:hover {
            border-color: #2563eb;
            background-color: #eff6ff;
        }

        .status-option input[type="radio"] {
            margin-left: 0.75rem;
        }

        .status-option-label {
            font-size: 1rem;
            font-weight: 500;
            color: #111827;
            flex: 1;
        }

        .modal-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            justify-content: flex-end;
        }

        .btn-cancel {
            padding: 0.75rem 1.5rem;
            background-color: #6b7280;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-cancel:hover {
            background-color: #4b5563;
        }

        .btn-save {
            padding: 0.75rem 1.5rem;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-save:hover {
            background-color: #1d4ed8;
        }

        .btn-change-status {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-block;
            background-color: #f59e0b;
            color: white;
            margin-right: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-change-status:hover {
            background-color: #d97706;
        }
    </style>

    <!-- Header -->
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">سير العمل</h2>
        <p style="font-size: 1rem; color: #6b7280; margin: 0;">عرض جميع مراحل أوامر الشغل في مكان واحد</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('work-orders.workflow') }}" class="filter-form" id="filterForm">
            <div class="filter-group">
                <label class="filter-label">العميل</label>
                <select name="client_id" class="filter-select" id="clientFilter">
                    <option value="">جميع العملاء</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $clientFilter == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">رقم عرض السعر</label>
                <select name="order_number" class="filter-select" id="orderNumberFilter">
                    <option value="">جميع أرقام عروض الأسعار</option>
                    @foreach($orderNumbers as $orderNumber)
                        <option value="{{ $orderNumber }}" {{ $orderNumberFilter == $orderNumber ? 'selected' : '' }}>
                            {{ $orderNumber }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <button type="submit" style="padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; font-size: 1rem;">
                    بحث
                </button>
                <a href="{{ route('work-orders.workflow') }}" style="padding: 0.75rem 1.5rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; display: inline-block; margin-right: 0.5rem; font-size: 1rem;">
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Status Cards -->
    <div class="cards-container">
        <div class="status-card" data-filter="price-quotes" onclick="filterByStatus('price-quotes')">
            <div class="status-card-header">
                <h3 class="status-card-title">عروض الأسعار</h3>
                <div class="status-card-icon" style="background-color: #fef3c7;">
                    <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #f59e0b;">{{ $priceQuotesCount }}</p>
        </div>

        <div class="status-card" data-filter="proofs" onclick="filterByStatus('proofs')">
            <div class="status-card-header">
                <h3 class="status-card-title">البروفا</h3>
                <div class="status-card-icon" style="background-color: #dbeafe;">
                    <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #2563eb;">{{ $proofsCount }}</p>
        </div>

        <div class="status-card" data-filter="sent-to-designer" onclick="filterByStatus('sent-to-designer')">
            <div class="status-card-header">
                <h3 class="status-card-title">المرسلة إلى المصمم</h3>
                <div class="status-card-icon" style="background-color: #e0e7ff;">
                    <svg style="width: 24px; height: 24px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #6366f1;">{{ $sentToDesignerCount }}</p>
        </div>

        <div class="status-card" data-filter="preparations" onclick="filterByStatus('preparations')">
            <div class="status-card-header">
                <h3 class="status-card-title">التجهيزات</h3>
                <div class="status-card-icon" style="background-color: #fef3c7;">
                    <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #f59e0b;">{{ $preparationsCount }}</p>
        </div>

        <div class="status-card" data-filter="production" onclick="filterByStatus('production')">
            <div class="status-card-header">
                <h3 class="status-card-title">التشغيل</h3>
                <div class="status-card-icon" style="background-color: #d1fae5;">
                    <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #10b981;">{{ $productionCount }}</p>
        </div>

        <div class="status-card" data-filter="archive" onclick="filterByStatus('archive')">
            <div class="status-card-header">
                <h3 class="status-card-title">الأرشيف</h3>
                <div class="status-card-icon" style="background-color: #fee2e2;">
                    <svg style="width: 24px; height: 24px; color: #dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #dc2626;">{{ $archiveCount }}</p>
        </div>

        <div class="status-card" data-filter="all" onclick="filterByStatus('all')">
            <div class="status-card-header">
                <h3 class="status-card-title">جميع أوامر الشغل</h3>
                <div class="status-card-icon" style="background-color: #f3f4f6;">
                    <svg style="width: 24px; height: 24px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
            </div>
            <p class="status-card-value" style="color: #6b7280;">{{ $allWorkOrdersCount }}</p>
        </div>
    </div>

    <!-- Active Filter Info -->
    <div id="activeFilterInfo" class="active-filter-info" style="display: none;">
        <h3 class="active-filter-title" id="activeFilterTitle"></h3>
        <button class="clear-filter-btn" onclick="clearFilter()">إلغاء الفلتر</button>
    </div>

    <!-- Data Table -->
    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>تاريخ الإنشاء</th>
                    <th>رقم عرض السعر</th>
                    <th>العميل</th>
                    <th>موظف المبيعات</th>
                    <th>الخامة</th>
                    <th>الكمية</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $allOrders = collect()
                        ->merge($priceQuotes->map(fn($o) => (object)['order' => $o, 'type' => 'price-quotes']))
                        ->merge($proofs->map(fn($o) => (object)['order' => $o, 'type' => 'proofs']))
                        ->merge($sentToDesigner->map(fn($o) => (object)['order' => $o, 'type' => 'sent-to-designer']))
                        ->merge($preparations->map(fn($o) => (object)['order' => $o, 'type' => 'preparations']))
                        ->merge($production->map(fn($o) => (object)['order' => $o, 'type' => 'production']))
                        ->merge($archive->map(fn($o) => (object)['order' => $o, 'type' => 'archive']));
                @endphp
                @foreach($allOrders as $item)
                    @php
                        $workOrder = $item->order;
                        $orderType = $item->type;
                        
                        $statusLabels = [
                            'draft' => 'مسودة',
                            'pending' => 'قيد الانتظار',
                            'client_approved' => 'موافق عليه من العميل',
                            'client_rejected' => 'مرفوض من العميل',
                            'client_no_response' => 'لم يرد العميل',
                            'work_order' => 'بروفا',
                            'in_progress' => 'قيد التجهيز',
                            'completed' => 'مكتمل',
                            'cancelled' => 'ملغي'
                        ];
                        $statusColors = [
                            'draft' => '#6b7280',
                            'pending' => '#f59e0b',
                            'client_approved' => '#10b981',
                            'client_rejected' => '#dc2626',
                            'client_no_response' => '#6b7280',
                            'work_order' => '#2563eb',
                            'in_progress' => '#f59e0b',
                            'completed' => '#10b981',
                            'cancelled' => '#dc2626'
                        ];
                        $status = $workOrder->status ?? 'draft';
                        $statusLabel = $statusLabels[$status] ?? $status;
                        $statusColor = $statusColors[$status] ?? '#6b7280';
                    @endphp
                    <tr data-order-type="{{ $orderType }}" data-status="{{ $status }}" data-client-id="{{ $workOrder->client_id ?? '' }}">
                        <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                        <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                        <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                        <td>{{ $workOrder->created_by ?? '-' }}</td>
                        <td>{{ $workOrder->material ?? '-' }}</td>
                        <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                        <td>
                            <span class="status-badge" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                @if($status === 'cancelled')
                                    <a href="{{ route('work-orders.archive.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                @elseif($status === 'work_order')
                                    <a href="{{ route('work-orders-list.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                @elseif($status === 'in_progress')
                                    <a href="{{ route('work-orders.preparations.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                @else
                                    <a href="{{ route('work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                @endif
                                <button type="button" class="btn-change-status" onclick="openStatusModal({{ $workOrder->id }}, '{{ $status }}', '{{ $workOrder->order_number ?? 'بدون رقم' }}')">
                                    تغيير الحالة
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($allOrders->isEmpty())
        <div class="empty-state">
            <p style="color: #6b7280;">لا توجد أوامر شغل</p>
        </div>
    @endif

    <script>
        let currentFilter = null;
        const filterTitles = {
            'price-quotes': 'عروض الأسعار',
            'proofs': 'البروفا',
            'sent-to-designer': 'المرسلة إلى المصمم',
            'preparations': 'التجهيزات',
            'production': 'التشغيل',
            'archive': 'الأرشيف',
            'all': 'جميع أوامر الشغل'
        };

        function filterByStatus(filterType) {
            // Remove active class from all cards
            document.querySelectorAll('.status-card').forEach(card => {
                card.classList.remove('active');
            });

            // Add active class to clicked card
            event.currentTarget.classList.add('active');

            // Show/hide rows based on filter
            const rows = document.querySelectorAll('tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const orderType = row.getAttribute('data-order-type');
                const status = row.getAttribute('data-status');

                if (filterType === 'all') {
                    row.classList.add('show');
                    visibleCount++;
                } else if (filterType === 'price-quotes') {
                    if (orderType === 'price-quotes') {
                        row.classList.add('show');
                        visibleCount++;
                    } else {
                        row.classList.remove('show');
                    }
                } else if (filterType === 'proofs') {
                    if (orderType === 'proofs') {
                        row.classList.add('show');
                        visibleCount++;
                    } else {
                        row.classList.remove('show');
                    }
                } else if (filterType === 'sent-to-designer') {
                    if (orderType === 'sent-to-designer') {
                        row.classList.add('show');
                        visibleCount++;
                    } else {
                        row.classList.remove('show');
                    }
                } else if (filterType === 'preparations') {
                    if (orderType === 'preparations') {
                        row.classList.add('show');
                        visibleCount++;
                    } else {
                        row.classList.remove('show');
                    }
                } else if (filterType === 'production') {
                    if (orderType === 'production') {
                        row.classList.add('show');
                        visibleCount++;
                    } else {
                        row.classList.remove('show');
                    }
                } else if (filterType === 'archive') {
                    if (orderType === 'archive') {
                        row.classList.add('show');
                        visibleCount++;
                    } else {
                        row.classList.remove('show');
                    }
                }
            });

            // Show active filter info
            currentFilter = filterType;
            if (filterType !== 'all') {
                document.getElementById('activeFilterInfo').style.display = 'flex';
                document.getElementById('activeFilterTitle').textContent = `عرض: ${filterTitles[filterType]} (${visibleCount})`;
            } else {
                document.getElementById('activeFilterInfo').style.display = 'none';
            }
        }

        function clearFilter() {
            // Remove active class from all cards
            document.querySelectorAll('.status-card').forEach(card => {
                card.classList.remove('active');
            });

            // Show all rows
            document.querySelectorAll('tbody tr').forEach(row => {
                row.classList.add('show');
            });

            // Hide active filter info
            document.getElementById('activeFilterInfo').style.display = 'none';
            currentFilter = null;
        }

        // Apply client and order number filters
        document.getElementById('clientFilter')?.addEventListener('change', function() {
            applyFilters();
        });

        document.getElementById('orderNumberFilter')?.addEventListener('change', function() {
            applyFilters();
        });

        function applyFilters() {
            const clientId = document.getElementById('clientFilter')?.value || '';
            const orderNumber = document.getElementById('orderNumberFilter')?.value.toLowerCase() || '';

            document.querySelectorAll('tbody tr').forEach(row => {
                const rowClientId = row.getAttribute('data-client-id') || '';
                const rowOrderNumber = (row.querySelector('td:nth-child(2) strong')?.textContent || '').toLowerCase();

                let matchesClient = !clientId || rowClientId === clientId;
                let matchesOrderNumber = !orderNumber || rowOrderNumber.includes(orderNumber);

                if (matchesClient && matchesOrderNumber) {
                    // Apply current status filter if exists
                    if (currentFilter) {
                        const orderType = row.getAttribute('data-order-type');
                        if (currentFilter === 'all' || orderType === currentFilter) {
                            row.classList.add('show');
                        } else {
                            row.classList.remove('show');
                        }
                    } else {
                        row.classList.add('show');
                    }
                } else {
                    row.classList.remove('show');
                }
            });
        }

        // Initialize: show all rows by default
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('tbody tr').forEach(row => {
                row.classList.add('show');
            });

            // Initialize Select2 on client filter
            $('#clientFilter').select2({
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
                    }
                },
                minimumResultsForSearch: 0
            });

            // Initialize Select2 on order number filter
            $('#orderNumberFilter').select2({
                dir: 'rtl',
                placeholder: 'ابحث عن رقم عرض السعر أو اختر من القائمة',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "لا توجد نتائج";
                    },
                    searching: function() {
                        return "جاري البحث...";
                    }
                },
                minimumResultsForSearch: 0
            });

            // Handle change events for Select2
            $('#clientFilter').on('select2:select select2:clear', function() {
                applyFilters();
            });

            $('#orderNumberFilter').on('select2:select select2:clear', function() {
                applyFilters();
            });
        });

        // Status Modal Functions
        let currentWorkOrderId = null;

        function openStatusModal(workOrderId, currentStatus, orderNumber) {
            currentWorkOrderId = workOrderId;
            document.getElementById('statusModalOrderNumber').textContent = orderNumber;
            
            // Set current status as checked
            document.querySelectorAll('input[name="new_status"]').forEach(radio => {
                radio.checked = radio.value === currentStatus;
            });
            
            document.getElementById('statusModal').classList.add('active');
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.remove('active');
            currentWorkOrderId = null;
        }

        function saveStatusChange() {
            const selectedStatus = document.querySelector('input[name="new_status"]:checked');
            if (!selectedStatus) {
                alert('يرجى اختيار حالة');
                return;
            }

            if (!currentWorkOrderId) {
                alert('خطأ: لم يتم تحديد أمر الشغل');
                return;
            }

            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/work-orders/${currentWorkOrderId}/update-status`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = selectedStatus.value;
            form.appendChild(statusInput);

            document.body.appendChild(form);
            form.submit();
        }

        // Close modal when clicking outside
        document.getElementById('statusModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });
    </script>

    <!-- Status Change Modal -->
    <div id="statusModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">تغيير حالة أمر الشغل</h3>
                <button type="button" class="modal-close" onclick="closeStatusModal()">×</button>
            </div>
            <div>
                <p style="margin-bottom: 1rem; color: #6b7280;">
                    رقم أمر الشغل: <strong id="statusModalOrderNumber"></strong>
                </p>
                <div class="status-options">
                    <label class="status-option">
                        <span class="status-option-label">مسودة</span>
                        <input type="radio" name="new_status" value="draft">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">قيد الانتظار</span>
                        <input type="radio" name="new_status" value="pending">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">موافق عليه من العميل</span>
                        <input type="radio" name="new_status" value="client_approved">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">مرفوض من العميل</span>
                        <input type="radio" name="new_status" value="client_rejected">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">لم يرد العميل</span>
                        <input type="radio" name="new_status" value="client_no_response">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">بروفا</span>
                        <input type="radio" name="new_status" value="work_order">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">قيد التجهيز</span>
                        <input type="radio" name="new_status" value="in_progress">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">مكتمل</span>
                        <input type="radio" name="new_status" value="completed">
                    </label>
                    <label class="status-option">
                        <span class="status-option-label">ملغي</span>
                        <input type="radio" name="new_status" value="cancelled">
                    </label>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeStatusModal()">إلغاء</button>
                    <button type="button" class="btn-save" onclick="saveStatusChange()">حفظ</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
