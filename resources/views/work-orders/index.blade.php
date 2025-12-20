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
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">
                {{ $isSalesEmployee ? 'قائمة عروض الأسعار' : 'قائمة أوامر الشغل' }}
            </h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">
                {{ $isSalesEmployee ? 'إدارة جميع عروض الأسعار من مكان واحد' : 'إدارة جميع أوامر الشغل من مكان واحد' }}
            </p>
        </div>
        <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            {{ $isSalesEmployee ? 'إضافة عرض سعر جديد' : 'إضافة أمر شغل جديد' }}
        </a>
    </div>

    @if($workOrders->count() > 0)
        @if($isSalesEmployee)
            <!-- Table View for Sales Employees -->
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>رقم عرض السعر</th>
                            <th>اسم العمل</th>
                            <th>العميل</th>
                            <th>الخامة</th>
                            <th>الكمية</th>
                            <th>عدد الألوان</th>
                            <th>الأبعاد</th>
                            <th>حالة الإنتاج</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workOrders as $workOrder)
                            @if(isset($workOrder->id) && !is_null($workOrder->id))
                            @php
                                $statusColors = [
                                    'pending' => '#f59e0b',
                                    'in_progress' => '#2563eb',
                                    'completed' => '#10b981',
                                    'cancelled' => '#dc2626'
                                ];
                                $statusLabels = [
                                    'pending' => 'قيد الانتظار',
                                    'in_progress' => 'قيد التنفيذ',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي'
                                ];
                                $color = $statusColors[$workOrder->status] ?? '#6b7280';
                                $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                                $productionStatus = $workOrder->production_status ?? 'بدون حالة';
                            @endphp
                            <tr>
                                <td>
                                    <strong style="color: #111827;">{{ $workOrder->order_number ?? 'بدون رقم' }}</strong>
                                </td>
                                <td>
                                    @if($workOrder->job_name)
                                        <span style="color: #2563eb; font-weight: 500;">{{ $workOrder->job_name }}</span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                <td>{{ $workOrder->material ?? '-' }}</td>
                                <td>{{ number_format($workOrder->quantity ?? 0) }}</td>
                                <td>{{ $workOrder->number_of_colors ?? '-' }}</td>
                                <td>
                                    @if($workOrder->width && $workOrder->length)
                                        {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }}
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="production-status-badge {{ str_replace(' ', '-', $productionStatus) }}">
                                        {{ $productionStatus }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $workOrder->status }}" style="background-color: {{ $color }}20; color: {{ $color }};">
                                        {{ $label }}
                                    </span>
                                </td>
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
                                    'pending' => '#f59e0b',
                                    'in_progress' => '#2563eb',
                                    'completed' => '#10b981',
                                    'cancelled' => '#dc2626'
                                ];
                                $statusLabels = [
                                    'pending' => 'قيد الانتظار',
                                    'in_progress' => 'قيد التنفيذ',
                                    'completed' => 'مكتمل',
                                    'cancelled' => 'ملغي'
                                ];
                                $color = $statusColors[$workOrder->status] ?? '#6b7280';
                                $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                            @endphp
                            <div class="kanban-card" 
                                 draggable="true" 
                                 ondragstart="handleDragStart(event, {{ $workOrder->id }})"
                                 data-order-id="{{ $workOrder->id }}">
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
                                    @if($workOrder->job_name)
                                    <p style="font-size: 0.875rem; color: #2563eb; font-weight: 500; margin: 0 0 0.25rem 0;">
                                        {{ $workOrder->job_name }}
                                    </p>
                                    @endif
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
                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الأبعاد</p>
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
                alert('حدث خطأ أثناء تحديث حالة الإنتاج: ' + error.message);
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
                alert('حدث خطأ أثناء تحديث حالة الإنتاج: ' + error.message);
                const select = cardElement.querySelector('.production-status-select');
                if (select) {
                    const originalStatus = currentRow?.getAttribute('data-status') || 'بدون حالة';
                    select.value = originalStatus === 'null' ? 'بدون حالة' : originalStatus;
                }
            });
        }
        @endif

        // Confirm delete function
        function confirmDelete(event) {
            if (!confirm('هل أنت متأكد من حذف هذا الأمر؟ لا يمكن التراجع عن هذه العملية.')) {
                event.preventDefault();
                return false;
            }
            return true;
        }
    </script>

    @if(session('success'))
    <script>
        alert('{{ session('success') }}');
    </script>
    @endif

    @if(session('error'))
    <script>
        alert('{{ session('error') }}');
    </script>
    @endif

</x-app-layout>
