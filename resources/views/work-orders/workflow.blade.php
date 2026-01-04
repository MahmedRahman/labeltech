<x-app-layout>
    @php
        $title = 'سير العمل';
    @endphp

    <style>
        .tabs-container {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .tabs-header {
            display: flex;
            border-bottom: 2px solid #e5e7eb;
            overflow-x: auto;
        }

        .tab-button {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            color: #6b7280;
            transition: all 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-button:hover {
            color: #2563eb;
            background-color: #f9fafb;
        }

        .tab-button.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
            background-color: #eff6ff;
        }

        .tab-badge {
            background-color: #e5e7eb;
            color: #374151;
            padding: 0.125rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .tab-button.active .tab-badge {
            background-color: #2563eb;
            color: white;
        }

        .tab-content {
            display: none;
            padding: 1.5rem;
        }

        .tab-content.active {
            display: block;
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
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
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
    </style>

    <!-- Header -->
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">سير العمل</h2>
        <p style="font-size: 1rem; color: #6b7280; margin: 0;">عرض جميع مراحل أوامر الشغل في مكان واحد</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('work-orders.workflow') }}" class="filter-form">
            <div class="filter-group">
                <label class="filter-label">العميل</label>
                <select name="client_id" class="filter-select">
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
                <input type="text" name="order_number" class="filter-input" value="{{ $orderNumberFilter ?? '' }}" placeholder="ابحث برقم عرض السعر">
            </div>
            <div class="filter-group">
                <button type="submit" style="padding: 0.5rem 1.5rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                    بحث
                </button>
                <a href="{{ route('work-orders.workflow') }}" style="padding: 0.5rem 1.5rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; display: inline-block; margin-right: 0.5rem;">
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Tabs Container -->
    <div class="tabs-container">
        <div class="tabs-header">
            <button class="tab-button active" onclick="switchTab('price-quotes')">
                عروض الأسعار
                <span class="tab-badge">{{ $priceQuotesCount }}</span>
            </button>
            <button class="tab-button" onclick="switchTab('proofs')">
                البروفا
                <span class="tab-badge">{{ $proofsCount }}</span>
            </button>
            <button class="tab-button" onclick="switchTab('sent-to-designer')">
                المرسلة إلى المصمم
                <span class="tab-badge">{{ $sentToDesignerCount }}</span>
            </button>
            <button class="tab-button" onclick="switchTab('preparations')">
                التجهيزات
                <span class="tab-badge">{{ $preparationsCount }}</span>
            </button>
            <button class="tab-button" onclick="switchTab('production')">
                التشغيل
                <span class="tab-badge">{{ $productionCount }}</span>
            </button>
            <button class="tab-button" onclick="switchTab('archive')">
                الأرشيف
                <span class="tab-badge">{{ $archiveCount }}</span>
            </button>
            <button class="tab-button" onclick="switchTab('all')">
                جميع أوامر الشغل
                <span class="tab-badge">{{ $allWorkOrdersCount }}</span>
            </button>
        </div>

        <!-- Price Quotes Tab -->
        <div id="tab-price-quotes" class="tab-content active">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                عروض الأسعار ({{ $priceQuotesCount }})
            </h3>
            @if($priceQuotes->count() > 0)
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
                                <th>تم الإرسال</th>
                                <th>رد العميل</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($priceQuotes as $workOrder)
                                @php
                                    $statusLabels = [
                                        'draft' => 'مسودة',
                                        'pending' => 'قيد الانتظار',
                                        'client_approved' => 'موافق عليه من العميل',
                                        'client_rejected' => 'مرفوض من العميل',
                                        'client_no_response' => 'لم يرد العميل'
                                    ];
                                    $statusColors = [
                                        'draft' => '#6b7280',
                                        'pending' => '#f59e0b',
                                        'client_approved' => '#10b981',
                                        'client_rejected' => '#dc2626',
                                        'client_no_response' => '#6b7280'
                                    ];
                                    $status = $workOrder->status ?? 'draft';
                                    $statusLabel = $statusLabels[$status] ?? $status;
                                    $statusColor = $statusColors[$status] ?? '#6b7280';
                                @endphp
                                <tr>
                                    <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                                    <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->created_by ?? '-' }}</td>
                                    <td>{{ $workOrder->material ?? '-' }}</td>
                                    <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                    <td>
                                        @if(($workOrder->sent_to_client ?? 'no') === 'yes')
                                            <span class="status-badge" style="background-color: #10b98120; color: #10b981;">نعم</span>
                                        @else
                                            <span class="status-badge" style="background-color: #6b728020; color: #6b7280;">لا</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($workOrder->client_response)
                                            @php
                                                $responseColors = [
                                                    'موافق' => '#10b981',
                                                    'رفض' => '#dc2626',
                                                    'لم يرد' => '#6b7280'
                                                ];
                                                $responseColor = $responseColors[$workOrder->client_response] ?? '#6b7280';
                                            @endphp
                                            <span class="status-badge" style="background-color: {{ $responseColor }}20; color: {{ $responseColor }};">
                                                {{ $workOrder->client_response }}
                                            </span>
                                        @else
                                            <span class="status-badge" style="background-color: #6b728020; color: #6b7280;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="table-actions">
                                            <a href="{{ route('work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                            <a href="{{ route('work-orders.edit', $workOrder->id) }}" class="btn-edit">تعديل</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد عروض أسعار</p>
                </div>
            @endif
        </div>

        <!-- Proofs Tab -->
        <div id="tab-proofs" class="tab-content">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                البروفا ({{ $proofsCount }})
            </h3>
            @if($proofs->count() > 0)
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <th>رقم عرض السعر</th>
                                <th>العميل</th>
                                <th>الخامة</th>
                                <th>الكمية</th>
                                <th>موافقة العميل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proofs as $workOrder)
                                <tr>
                                    <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                                    <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->material ?? '-' }}</td>
                                    <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                    <td>
                                        @if($workOrder->client_design_approval)
                                            @php
                                                $colors = [
                                                    'موافق' => '#10b981',
                                                    'رفض' => '#dc2626',
                                                    'لم يرد' => '#6b7280'
                                                ];
                                                $color = $colors[$workOrder->client_design_approval] ?? '#6b7280';
                                            @endphp
                                            <span class="status-badge" style="background-color: {{ $color }}20; color: {{ $color }};">
                                                {{ $workOrder->client_design_approval }}
                                            </span>
                                        @else
                                            <span class="status-badge" style="background-color: #6b728020; color: #6b7280;">لم يرد</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('work-orders-list.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد بروفات</p>
                </div>
            @endif
        </div>

        <!-- Sent to Designer Tab -->
        <div id="tab-sent-to-designer" class="tab-content">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                أوامر الشغل المرسلة إلى المصمم ({{ $sentToDesignerCount }})
            </h3>
            @if($sentToDesigner->count() > 0)
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <th>رقم البروفا</th>
                                <th>العميل</th>
                                <th>الخامة</th>
                                <th>الكمية</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sentToDesigner as $workOrder)
                                <tr>
                                    <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                                    <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->material ?? '-' }}</td>
                                    <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                    <td>
                                        <a href="{{ route('work-orders.sent-to-designer.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد أوامر شغل مرسلة إلى المصمم</p>
                </div>
            @endif
        </div>

        <!-- Preparations Tab -->
        <div id="tab-preparations" class="tab-content">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                التجهيزات ({{ $preparationsCount }})
            </h3>
            @if($preparations->count() > 0)
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <th>رقم البروفا</th>
                                <th>العميل</th>
                                <th>الخامة</th>
                                <th>الكمية</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($preparations as $workOrder)
                                <tr>
                                    <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                                    <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->material ?? '-' }}</td>
                                    <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                    <td>
                                        <a href="{{ route('work-orders.preparations.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد تجهيزات</p>
                </div>
            @endif
        </div>

        <!-- Production Tab -->
        <div id="tab-production" class="tab-content">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                التشغيل ({{ $productionCount }})
            </h3>
            @if($production->count() > 0)
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <th>رقم البروفا</th>
                                <th>العميل</th>
                                <th>الخامة</th>
                                <th>الكمية</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($production as $workOrder)
                                <tr>
                                    <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                                    <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->material ?? '-' }}</td>
                                    <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                    <td>
                                        <a href="{{ route('work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد أوامر شغل في التشغيل</p>
                </div>
            @endif
        </div>

        <!-- Archive Tab -->
        <div id="tab-archive" class="tab-content">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                الأرشيف ({{ $archiveCount }})
            </h3>
            @if($archive->count() > 0)
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>تاريخ الإنشاء</th>
                                <th>رقم عرض السعر</th>
                                <th>العميل</th>
                                <th>الخامة</th>
                                <th>الكمية</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archive as $workOrder)
                                <tr>
                                    <td>{{ $workOrder->created_at ? $workOrder->created_at->format('Y-m-d') : '-' }}</td>
                                    <td><strong>{{ $workOrder->order_number ?? 'بدون رقم' }}</strong></td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->material ?? '-' }}</td>
                                    <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                    <td>
                                        <a href="{{ route('work-orders.archive.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد أوامر شغل في الأرشيف</p>
                </div>
            @endif
        </div>

        <!-- All Work Orders Tab -->
        <div id="tab-all" class="tab-content">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">
                جميع أوامر الشغل ({{ $allWorkOrdersCount }})
            </h3>
            @if($allWorkOrders->count() > 0)
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
                            @foreach($allWorkOrders as $workOrder)
                                @php
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
                                <tr>
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
                                            <a href="{{ route('work-orders.edit', $workOrder->id) }}" class="btn-edit">تعديل</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <p style="color: #6b7280;">لا توجد أوامر شغل</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });

            // Show selected tab content
            document.getElementById('tab-' + tabName).classList.add('active');

            // Add active class to clicked button
            event.currentTarget.classList.add('active');
        }
    </script>
</x-app-layout>

