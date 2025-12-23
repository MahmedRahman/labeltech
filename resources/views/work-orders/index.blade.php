<x-app-layout>
    @php
        $isSalesEmployee = auth('employee')->check() && auth('employee')->user()->account_type === 'مبيعات';
        $title = $isSalesEmployee ? 'قائمة عروض الأسعار' : 'قائمة أوامر الشغل';
    @endphp

    <style>
        .kanban-board {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .kanban-row {
            background: white;
            border-radius: 0.5rem;
            padding: 0;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .kanban-row-header {
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            color: white !important;
            text-align: right;
            margin-bottom: 0;
            border-radius: 0.5rem 0.5rem 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .kanban-row-header span {
            color: white !important;
        }

        .kanban-row-header.طباعة {
            background: #2563eb;
        }

        .kanban-row-header.قص {
            background: #10b981;
        }

        .kanban-row-header.تقفيل {
            background: #8b5cf6;
        }

        .kanban-row-header[class*="بدون"] {
            background: #6b7280;
        }

        .kanban-row-content {
            padding: 1rem;
        }

        .kanban-cards {
            display: flex;
            flex-direction: row;
            gap: 1rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
        }

        .kanban-cards::-webkit-scrollbar {
            height: 8px;
        }

        .kanban-cards::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .kanban-cards::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .kanban-cards::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .kanban-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            cursor: move;
            transition: all 0.2s;
            border: 1px solid #e5e7eb;
            position: relative;
            min-width: 280px;
            flex-shrink: 0;
        }

        .kanban-card:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
            transform: translateY(-1px);
        }

        .kanban-card.dragging {
            opacity: 0.6;
            transform: scale(0.98);
            cursor: move;
        }

        .kanban-row.drag-over {
            background-color: #f9fafb;
            border-color: #2563eb;
        }

        .card-badge {
            position: absolute;
            top: -8px;
            right: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .card-badge.design {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            color: white;
        }

        .card-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-draft {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-in_progress {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Table Styles for Sales View */
        .data-table {
            width: 100%;
            background: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background-color: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        .data-table th {
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #111827;
        }

        .data-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .table-actions a {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .table-actions .btn-view {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .table-actions .btn-view:hover {
            background-color: #dbeafe;
        }

        .table-actions .btn-edit {
            background-color: #f0fdf4;
            color: #10b981;
        }

        .table-actions .btn-edit:hover {
            background-color: #dcfce7;
        }

        .table-actions .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .table-actions .btn-delete:hover {
            background-color: #fecaca;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .production-status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .production-status-badge.بدون-حالة {
            background-color: #f3f4f6;
            color: #6b7280;
        }

        .production-status-badge.طباعة {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .production-status-badge.قص {
            background-color: #d1fae5;
            color: #065f46;
        }

        .production-status-badge.تقفيل {
            background-color: #ede9fe;
            color: #5b21b6;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">
                {{ $isSalesEmployee ? 'قائمة عروض الأسعار' : 'قائمة أوامر الشغل' }}
            </h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">
                {{ $isSalesEmployee ? 'إدارة جميع عروض الأسعار من مكان واحد' : 'إدارة جميع أوامر الشغل من مكان واحد' }}
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('work-orders.list') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                أمر شغل
            </a>
            <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ $isSalesEmployee ? 'إضافة عرض سعر جديد' : 'إضافة أمر شغل جديد' }}
            </a>
        </div>
    </div>

    @if($workOrders->count() > 0)
        <!-- Sent Status Summary Cards -->
        <div style="margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <!-- Total Orders Card -->
                <div class="summary-card active" data-filter="all" onclick="filterWorkOrders('all')" style="background: white; border-radius: 0.5rem; border: 2px solid #2563eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.2s; cursor: pointer;">
                    <div style="background: #f8fafc; padding: 1rem; text-align: center;">
                        <div style="width: 45px; height: 45px; background: #e0e7ff; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin: 0 0 0.5rem 0;">إجمالي العروض</h4>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $workOrders->count() }}</p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">عرض سعر</p>
                    </div>
                </div>

                <!-- Sent to Client Card -->
                <div class="summary-card" data-filter="sent" onclick="filterWorkOrders('sent')" style="background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.2s; cursor: pointer;">
                    <div style="background: #f0fdf4; padding: 1rem; text-align: center;">
                        <div style="width: 45px; height: 45px; background: #dcfce7; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #22c55e;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin: 0 0 0.5rem 0;">تم الإرسال</h4>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $sentCount ?? 0 }}</p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">عرض سعر</p>
                    </div>
                </div>

                <!-- Not Sent to Client Card -->
                <div class="summary-card" data-filter="not-sent" onclick="filterWorkOrders('not-sent')" style="background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); overflow: hidden; transition: all 0.2s; cursor: pointer;">
                    <div style="background: #fffbeb; padding: 1rem; text-align: center;">
                        <div style="width: 45px; height: 45px; background: #fef3c7; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                            <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #64748b; margin: 0 0 0.5rem 0;">لم يتم الإرسال</h4>
                        <p style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0;">{{ $notSentCount ?? 0 }}</p>
                        <p style="font-size: 0.75rem; color: #94a3b8; margin: 0.25rem 0 0 0;">عرض سعر</p>
                    </div>
                </div>
            </div>
        </div>

        @if($isSalesEmployee)
            <!-- Table View for Sales Employees -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>تاريخ الإنشاء</th>
                            <th>رقم عرض السعر</th>
                            <th>العميل</th>
                            <th>الخامة</th>
                            <th>الكمية</th>
                            <th>المقاس</th>
                            <th>تم الإرسال للعميل</th>
                            <th>رد العميل على عرض السعر</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workOrders as $workOrder)
                            @if(isset($workOrder->id) && !is_null($workOrder->id))
                            @php
                                $statusColors = [
                                    'draft' => '#6b7280',
                                    'pending' => '#f59e0b',
                                    'in_progress' => '#2563eb',
                                    'completed' => '#10b981',
                                    'cancelled' => '#dc2626',
                                    'client_approved' => '#10b981',
                                    'client_rejected' => '#dc2626',
                                    'client_no_response' => '#6b7280',
                                    'work_order' => '#2563eb'
                                ];
                                $statusLabels = [
                                    'draft' => 'مسودة',
                                    'pending' => 'قيد الانتظار',
                                    'in_progress' => 'قيد التنفيذ',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي',
                                    'client_approved' => 'العميل موافق',
                                    'client_rejected' => 'العميل رفض',
                                    'client_no_response' => 'العميل لم يرد',
                                    'work_order' => 'أمر شغل'
                                ];
                                $color = $statusColors[$workOrder->status] ?? '#6b7280';
                                $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                                $productionStatus = $workOrder->production_status ?? 'بدون حالة';
                            @endphp
                            <tr data-sent-to-client="{{ ($workOrder->sent_to_client ?? 'no') == 'yes' ? 'sent' : 'not-sent' }}">
                                <td>
                                    @if($workOrder->created_at)
                                        {{ $workOrder->created_at->format('Y-m-d') }}
                                        <br>
                                        <small style="color: #9ca3af; font-size: 0.75rem;">{{ $workOrder->created_at->format('H:i') }}</small>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong style="color: #111827;">{{ $workOrder->order_number ?? 'بدون رقم' }}</strong>
                                </td>
                                <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                <td>{{ $workOrder->material ?? '-' }}</td>
                                <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                <td>
                                    @if($workOrder->width && $workOrder->length)
                                        {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }}
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $sentToClient = $workOrder->sent_to_client ?? 'no';
                                    @endphp
                                    @if($sentToClient == 'yes')
                                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #d1fae5; color: #065f46;">
                                            ✓ تم الإرسال
                                        </span>
                                    @else
                                        <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #fee2e2; color: #991b1b;">
                                            ✗ لم يتم الإرسال
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $clientResponseColors = [
                                            'موافق' => '#10b981',
                                            'رفض' => '#dc2626',
                                            'لم يرد' => '#6b7280'
                                        ];
                                        $clientResponseLabels = [
                                            'موافق' => 'موافق',
                                            'رفض' => 'رفض',
                                            'لم يرد' => 'لم يرد'
                                        ];
                                        $responseColor = $clientResponseColors[$workOrder->client_response] ?? '#9ca3af';
                                        $responseLabel = $clientResponseLabels[$workOrder->client_response] ?? '-';
                                    @endphp
                                    @if($workOrder->client_response)
                                        <span class="status-badge" style="background-color: {{ $responseColor }}20; color: {{ $responseColor }};">
                                            {{ $responseLabel }}
                                        </span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $workOrder->status }}" style="background-color: {{ $color }}20; color: {{ $color }};">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('work-orders.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                        <a href="{{ route('work-orders.edit', $workOrder->id) }}" class="btn-edit">تعديل</a>
                                        <form action="{{ route('work-orders.destroy', $workOrder->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" style="padding: 0.375rem 0.75rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.75rem; font-weight: 500; transition: all 0.2s; background-color: #fee2e2; color: #dc2626; border: none; cursor: pointer;">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Status-based Cards View -->
            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">عروض الأسعار حسب الحالة</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                    @php
                        $statusConfig = [
                            'draft' => ['label' => 'مسودة', 'color' => '#6b7280', 'bg' => '#f3f4f6', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            'pending' => ['label' => 'قيد الانتظار', 'color' => '#f59e0b', 'bg' => '#fef3c7', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'client_approved' => ['label' => 'العميل موافق', 'color' => '#10b981', 'bg' => '#d1fae5', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'client_rejected' => ['label' => 'العميل رفض', 'color' => '#dc2626', 'bg' => '#fee2e2', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'client_no_response' => ['label' => 'العميل لم يرد', 'color' => '#6b7280', 'bg' => '#f3f4f6', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'in_progress' => ['label' => 'قيد التنفيذ', 'color' => '#2563eb', 'bg' => '#dbeafe', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'completed' => ['label' => 'مكتمل', 'color' => '#10b981', 'bg' => '#d1fae5', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                            'cancelled' => ['label' => 'ملغي', 'color' => '#dc2626', 'bg' => '#fee2e2', 'icon' => 'M6 18L18 6M6 6l12 12'],
                        ];
                    @endphp
                    @foreach($statusConfig as $statusKey => $config)
                        @if(isset($statusGroups[$statusKey]) && $statusGroups[$statusKey]->count() > 0)
                        <div class="status-card" style="background: white; border-radius: 0.75rem; border: 2px solid {{ $config['color'] }}; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); overflow: hidden; transition: all 0.2s; display: flex; flex-direction: column;">
                            <div style="background: linear-gradient(135deg, {{ $config['color'] }} 0%, {{ $config['bg'] }} 100%); padding: 1.25rem; border-bottom: 2px solid {{ $config['color'] }};">
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                                        <div style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.3); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                            <svg style="width: 28px; height: 28px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"></path>
                                            </svg>
                                        </div>
                                        <h4 style="font-size: 1rem; font-weight: 700; color: white; margin: 0; text-align: center;">{{ $config['label'] }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 1rem; max-height: 500px; overflow-y: auto; flex: 1;">
                                @foreach($statusGroups[$statusKey] as $workOrder)
                                    <div data-sent-to-client="{{ ($workOrder->sent_to_client ?? 'no') == 'yes' ? 'sent' : 'not-sent' }}" style="background: #f9fafb; border-radius: 0.5rem; padding: 1rem; margin-bottom: 0.75rem; border: 1px solid #e5e7eb; transition: all 0.2s; cursor: pointer;" onclick="window.location.href='{{ route('work-orders.show', $workOrder->id) }}'">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                                            <div>
                                                <h5 style="font-size: 0.875rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</h5>
                                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">{{ $workOrder->client->name ?? 'غير محدد' }}</p>
                                            </div>
                                            @if(($workOrder->sent_to_client ?? 'no') == 'yes')
                                            <span style="display: inline-block; padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: #d1fae5; color: #065f46;">
                                                ✓ تم الإرسال
                                            </span>
                                            @endif
                                        </div>
                                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem; font-size: 0.75rem;">
                                            <div>
                                                <span style="color: #6b7280;">الخامة:</span>
                                                <span style="color: #111827; font-weight: 500;">{{ $workOrder->material ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span style="color: #6b7280;">الكمية:</span>
                                                <span style="color: #111827; font-weight: 500;">{{ number_format($workOrder->quantity ?? 0) }}</span>
                                            </div>
                                            @if($workOrder->created_at)
                                            <div style="grid-column: 1 / -1;">
                                                <span style="color: #6b7280;">التاريخ:</span>
                                                <span style="color: #111827; font-weight: 500;">{{ $workOrder->created_at->format('Y-m-d') }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div style="background: {{ $config['bg'] }}; padding: 0.75rem; border-top: 2px solid {{ $config['color'] }}; text-align: center;">
                                <p style="font-size: 0.875rem; font-weight: 600; color: {{ $config['color'] }}; margin: 0;">
                                    العدد: <span style="font-size: 1.125rem;">{{ $statusGroups[$statusKey]->count() }}</span>
                                </p>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Kanban Board View for Other Users -->
            <div class="kanban-board">
            @php
                $statuses = [
                    'بدون حالة' => $groupedOrders['بدون حالة'],
                    'طباعة' => $groupedOrders['طباعة'],
                    'قص' => $groupedOrders['قص'],
                    'تقفيل' => $groupedOrders['تقفيل'],
                ];
            @endphp

            @foreach($statuses as $status => $orders)
                <div class="kanban-row" data-status="{{ $status }}" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                    <div class="kanban-row-header {{ str_replace(' ', '-', $status) }}">
                        <span>{{ $status }}</span>
                        <span style="font-size: 0.875rem; opacity: 0.95; background-color: rgba(255, 255, 255, 0.2); padding: 0.25rem 0.75rem; border-radius: 9999px;">{{ $orders->count() }}</span>
                    </div>
                    <div class="kanban-row-content">
                        <div class="kanban-cards">
                        @foreach($orders as $workOrder)
                            @if(isset($workOrder->id) && !is_null($workOrder->id))
                            @php
                                $statusColors = [
                                    'draft' => '#6b7280',
                                    'pending' => '#f59e0b',
                                    'in_progress' => '#2563eb',
                                    'completed' => '#10b981',
                                    'cancelled' => '#dc2626',
                                    'client_approved' => '#10b981',
                                    'client_rejected' => '#dc2626',
                                    'client_no_response' => '#6b7280',
                                    'work_order' => '#2563eb'
                                ];
                                $statusLabels = [
                                    'draft' => 'مسودة',
                                    'pending' => 'قيد الانتظار',
                                    'in_progress' => 'قيد التنفيذ',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي',
                                    'client_approved' => 'العميل موافق',
                                    'client_rejected' => 'العميل رفض',
                                    'client_no_response' => 'العميل لم يرد',
                                    'work_order' => 'أمر شغل'
                                ];
                                $color = $statusColors[$workOrder->status] ?? '#6b7280';
                                $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                            @endphp
                            <div class="kanban-card" 
                                 draggable="true" 
                                 ondragstart="handleDragStart(event, {{ $workOrder->id }})"
                                 data-order-id="{{ $workOrder->id }}"
                                 data-sent-to-client="{{ ($workOrder->sent_to_client ?? 'no') == 'yes' ? 'sent' : 'not-sent' }}">
                                @if($workOrder->has_design ?? false)
                                <div class="card-badge design">
                                    <svg style="width: 12px; height: 12px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                    التصميم
                                </div>
                                @endif

                                <div style="margin-bottom: 0.75rem;">
                                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">
                                        {{ $workOrder->order_number ?? 'بدون رقم' }}
                                    </h3>
                                    <p style="font-size: 1rem; color: #6b7280; margin: 0 0 0.25rem 0;">
                                        <strong>العميل:</strong> {{ $workOrder->client->name ?? 'غير محدد' }}
                                    </p>
                                    @if($workOrder->created_by)
                                    <p style="font-size: 0.75rem; color: #9ca3af; margin: 0 0 0.5rem 0;">
                                        <strong>تم الإنشاء بواسطة:</strong> {{ $workOrder->created_by }}
                                    </p>
                                    @endif
                                    <span class="card-status status-{{ $workOrder->status }}">
                                        {{ $label }}
                                    </span>
                                </div>

                                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 0.75rem; font-size: 0.875rem;">
                                    <div>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الخامة</p>
                                        <p style="font-weight: 500; color: #111827; margin: 0;">{{ $workOrder->material ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الكمية</p>
                                        <p style="font-weight: 500; color: #111827; margin: 0;">{{ number_format($workOrder->quantity ?? 0) }}</p>
                                    </div>
                                    <div>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">عدد الألوان</p>
                                        <p style="font-weight: 500; color: #111827; margin: 0;">{{ $workOrder->number_of_colors ?? '-' }}</p>
                                    </div>
                                    @if($workOrder->width && $workOrder->length)
                                    <div>
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">المقاس</p>
                                        <p style="font-weight: 500; color: #111827; margin: 0;">
                                            {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Production Status Selector -->
                                <div style="margin-bottom: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb;">
                                    <label style="display: block; font-size: 0.75rem; color: #6b7280; margin-bottom: 0.5rem; font-weight: 500;">حالة الإنتاج</label>
                                    <select class="production-status-select" 
                                            data-order-id="{{ $workOrder->id }}"
                                            style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; background-color: white; cursor: pointer;">
                                        <option value="بدون حالة" {{ ($workOrder->production_status ?? null) == null || ($workOrder->production_status ?? '') == 'بدون حالة' ? 'selected' : '' }}>بدون حالة</option>
                                        <option value="طباعة" {{ ($workOrder->production_status ?? '') == 'طباعة' ? 'selected' : '' }}>طباعة</option>
                                        <option value="قص" {{ ($workOrder->production_status ?? '') == 'قص' ? 'selected' : '' }}>قص</option>
                                        <option value="تقفيل" {{ ($workOrder->production_status ?? '') == 'تقفيل' ? 'selected' : '' }}>تقفيل</option>
                                        <option value="أرشيف" {{ ($workOrder->production_status ?? '') == 'أرشيف' ? 'selected' : '' }}>أرشيف</option>
                                    </select>
                                </div>

                         

                                <div style="display: flex; gap: 0.5rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb;">
                                    <a href="{{ route('work-orders.show', $workOrder->id) }}" style="flex: 1; text-align: center; padding: 0.5rem; background-color: #eff6ff; color: #2563eb; text-decoration: none; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 500;">
                                        عرض
                                    </a>
                                    <a href="{{ route('work-orders.edit', $workOrder->id) }}" style="flex: 1; text-align: center; padding: 0.5rem; background-color: #f0fdf4; color: #10b981; text-decoration: none; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 500;">
                                        تعديل
                                    </a>
                                    <form action="{{ route('work-orders.destroy', $workOrder->id) }}" method="POST" style="flex: 1; display: inline;" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="width: 100%; padding: 0.5rem; background-color: #fee2e2; color: #dc2626; border: none; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 500; cursor: pointer;">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">
                {{ $isSalesEmployee ? 'لا توجد عروض أسعار' : 'لا توجد أوامر شغل' }}
            </h3>
            <p style="font-size: 1rem; color: #6b7280; margin-bottom: 2rem;">
                {{ $isSalesEmployee ? 'ابدأ بإضافة عرض سعر جديد' : 'ابدأ بإضافة أمر شغل جديد' }}
            </p>
            <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ $isSalesEmployee ? 'إضافة عرض سعر جديد' : 'إضافة أمر شغل جديد' }}
            </a>
        </div>
    @endif

    <script>
        @if(!$isSalesEmployee)
        let draggedOrderId = null;
        let draggedElement = null;

        function handleDragStart(event, orderId) {
            draggedOrderId = orderId;
            draggedElement = event.target;
            event.target.classList.add('dragging');
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/html', event.target.outerHTML);
        }

        function handleDragOver(event) {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';
            const column = event.currentTarget;
            column.classList.add('drag-over');
        }

        function handleDragLeave(event) {
            const column = event.currentTarget;
            column.classList.remove('drag-over');
        }

        function handleDrop(event) {
            event.preventDefault();
            const column = event.currentTarget;
            column.classList.remove('drag-over');
            
            if (!draggedOrderId) return;

            const newStatus = column.getAttribute('data-status');
            const oldStatus = draggedElement.closest('.kanban-row')?.getAttribute('data-status');

            if (newStatus === oldStatus) {
                draggedElement.classList.remove('dragging');
                return;
            }

            updateProductionStatus(draggedOrderId, newStatus === 'null' ? 'بدون حالة' : newStatus, draggedElement, column);
        }

        function updateProductionStatus(workOrderId, status, cardElement, targetColumn) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            const formData = new FormData();
            formData.append('production_status', status || 'بدون حالة');
            formData.append('_token', csrfToken);
            
            fetch(`/work-orders/${workOrderId}/production-status`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'حدث خطأ في الخادم');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const cardsContainer = targetColumn.querySelector('.kanban-cards');
                    cardElement.classList.remove('dragging');
                    cardsContainer.appendChild(cardElement);
                    
                    const header = targetColumn.querySelector('.kanban-row-header');
                    const countSpan = header.querySelector('span:last-child');
                    if (countSpan) {
                        const currentCount = parseInt(countSpan.textContent) || 0;
                        countSpan.textContent = currentCount + 1;
                    }

                    const oldRow = cardElement.closest('.kanban-row');
                    if (oldRow && oldRow !== targetColumn) {
                        const oldHeader = oldRow.querySelector('.kanban-row-header');
                        const oldCountSpan = oldHeader.querySelector('span:last-child');
                        if (oldCountSpan) {
                            const oldCount = parseInt(oldCountSpan.textContent) || 0;
                            if (oldCount > 0) {
                                oldCountSpan.textContent = oldCount - 1;
                            }
                        }
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    throw new Error(data.message || 'فشل تحديث الحالة');
                }
            })
            .catch(error => {
                console.error('Error updating production status:', error);
                Swal.fire({
                    title: 'خطأ!',
                    text: 'حدث خطأ أثناء تحديث حالة الإنتاج: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#dc2626',
                    customClass: {
                        popup: 'rtl-popup'
                    }
                });
                cardElement.classList.remove('dragging');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.kanban-card');
            cards.forEach(card => {
                const links = card.querySelectorAll('a, button');
                links.forEach(link => {
                    link.addEventListener('mousedown', function(e) {
                        e.stopPropagation();
                    });
                });
            });

            const statusSelects = document.querySelectorAll('.production-status-select');
            statusSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const workOrderId = this.getAttribute('data-order-id');
                    const newStatus = this.value || 'بدون حالة';
                    const cardElement = this.closest('.kanban-card');
                    const currentRow = cardElement.closest('.kanban-row');
                    
                    updateProductionStatusFromSelect(workOrderId, newStatus, cardElement, currentRow);
                });
            });
        });

        function updateProductionStatusFromSelect(workOrderId, status, cardElement, currentRow) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            
            const formData = new FormData();
            formData.append('production_status', status || 'بدون حالة');
            formData.append('_token', csrfToken);
            
            fetch(`/work-orders/${workOrderId}/production-status`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'حدث خطأ في الخادم');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const targetStatus = status || 'بدون حالة';
                    const targetRow = document.querySelector(`.kanban-row[data-status="${targetStatus}"]`);
                    
                    if (targetRow && targetRow !== currentRow) {
                        const cardsContainer = targetRow.querySelector('.kanban-cards');
                        if (cardsContainer) {
                            cardsContainer.appendChild(cardElement);
                            
                            const header = targetRow.querySelector('.kanban-row-header');
                            const countSpan = header.querySelector('span:last-child');
                            if (countSpan) {
                                const currentCount = parseInt(countSpan.textContent) || 0;
                                countSpan.textContent = currentCount + 1;
                            }

                            if (currentRow) {
                                const oldHeader = currentRow.querySelector('.kanban-row-header');
                                const oldCountSpan = oldHeader.querySelector('span:last-child');
                                if (oldCountSpan) {
                                    const oldCount = parseInt(oldCountSpan.textContent) || 0;
                                    if (oldCount > 0) {
                                        oldCountSpan.textContent = oldCount - 1;
                                    }
                                }
                            }
                        }
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    throw new Error(data.message || 'فشل تحديث الحالة');
                }
            })
            .catch(error => {
                console.error('Error updating production status:', error);
                Swal.fire({
                    title: 'خطأ!',
                    text: 'حدث خطأ أثناء تحديث حالة الإنتاج: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#dc2626',
                    customClass: {
                        popup: 'rtl-popup'
                    }
                });
                const select = cardElement.querySelector('.production-status-select');
                if (select) {
                    const originalStatus = currentRow?.getAttribute('data-status') || 'بدون حالة';
                    select.value = originalStatus === 'null' ? 'بدون حالة' : originalStatus;
                }
            });
        }
        @endif

        // Confirm delete function using SweetAlert
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'هل أنت متأكد من حذف هذا الأمر؟ لا يمكن التراجع عن هذه العملية.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            
            return false;
        }
        
        // Filter work orders by sent to client status
        function filterWorkOrders(filterType) {
            // Remove active class from all summary cards
            document.querySelectorAll('.summary-card').forEach(card => {
                card.classList.remove('active');
                card.style.border = '1px solid #e5e7eb';
            });
            
            // Add active class to clicked card
            const clickedCard = event.currentTarget;
            clickedCard.classList.add('active');
            clickedCard.style.border = '2px solid #2563eb';
            clickedCard.style.boxShadow = '0 4px 12px rgba(37, 99, 235, 0.2)';
            
            // Filter table rows (for sales employees table view)
            const tableRows = document.querySelectorAll('tbody tr[data-sent-to-client]');
            tableRows.forEach(row => {
                const sentStatus = row.getAttribute('data-sent-to-client');
                
                if (filterType === 'all') {
                    row.style.display = '';
                } else if (filterType === 'sent') {
                    row.style.display = sentStatus === 'sent' ? '' : 'none';
                } else if (filterType === 'not-sent') {
                    row.style.display = sentStatus === 'not-sent' ? '' : 'none';
                }
            });
            
            // Filter kanban cards
            const kanbanCards = document.querySelectorAll('.kanban-card[data-sent-to-client]');
            kanbanCards.forEach(card => {
                const sentStatus = card.getAttribute('data-sent-to-client');
                
                if (filterType === 'all') {
                    card.style.display = '';
                } else if (filterType === 'sent') {
                    card.style.display = sentStatus === 'sent' ? '' : 'none';
                } else if (filterType === 'not-sent') {
                    card.style.display = sentStatus === 'not-sent' ? '' : 'none';
                }
            });
            
            // Filter status-based cards
            const statusCards = document.querySelectorAll('[onclick*="work-orders.show"][data-sent-to-client]');
            statusCards.forEach(card => {
                const sentStatus = card.getAttribute('data-sent-to-client');
                
                if (filterType === 'all') {
                    card.style.display = '';
                } else if (filterType === 'sent') {
                    card.style.display = sentStatus === 'sent' ? '' : 'none';
                } else if (filterType === 'not-sent') {
                    card.style.display = sentStatus === 'not-sent' ? '' : 'none';
                }
            });
        }
        
    </script>


</x-app-layout>
