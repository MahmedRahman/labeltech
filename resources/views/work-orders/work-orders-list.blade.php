<x-app-layout>
    @php
        $title = 'بروفا';
    @endphp

    <style>
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

        .table-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-view {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            background-color: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background-color: #bfdbfe;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            cursor: pointer;
        }

        .stat-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-card.active {
            border: 2px solid #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-card-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            margin: 0;
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">بروفا</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">عرض جميع البروفات المحولة من عروض الأسعار</p>
        </div>
        <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة للقائمة
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <!-- Total Work Orders Card -->
        <div class="stat-card active" data-filter="all" onclick="filterTable('all')">
            <div class="stat-card-header">
                <h3 class="stat-card-title">إجمالي البروفات</h3>
                <div class="stat-card-icon" style="background-color: #dbeafe;">
                    <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value">{{ $totalCount ?? 0 }}</p>
        </div>

        <!-- Sent to Designer Card -->
        <div class="stat-card" data-filter="sent" onclick="filterTable('sent')">
            <div class="stat-card-header">
                <h3 class="stat-card-title">تم الإرسال إلى المصمم</h3>
                <div class="stat-card-icon" style="background-color: #d1fae5;">
                    <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value" style="color: #10b981;">{{ $sentToDesignerCount ?? 0 }}</p>
        </div>

        <!-- Not Sent to Designer Card -->
        <div class="stat-card" data-filter="not-sent" onclick="filterTable('not-sent')">
            <div class="stat-card-header">
                <h3 class="stat-card-title">لم يتم الإرسال إلى المصمم</h3>
                <div class="stat-card-icon" style="background-color: #fee2e2;">
                    <svg style="width: 24px; height: 24px; color: #dc2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value" style="color: #dc2626;">{{ $notSentToDesignerCount ?? 0 }}</p>
        </div>
    </div>

    @if($workOrders->count() > 0)
        <!-- Table View -->
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
                        <th>تم الإرسال إلى المصمم</th>
                        <th>موافقة العميل على التصميم</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workOrders as $workOrder)
                        @if(isset($workOrder->id) && !is_null($workOrder->id))
                        @php
                            $statusColors = [
                                'work_order' => '#2563eb'
                            ];
                            $statusLabels = [
                                'work_order' => 'بروفا'
                            ];
                            $color = $statusColors[$workOrder->status] ?? '#6b7280';
                            $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                        @endphp
                        <tr data-sent-to-designer="{{ ($workOrder->sent_to_designer ?? 'no') == 'yes' ? 'sent' : 'not-sent' }}">
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
                                @if(($workOrder->sent_to_designer ?? 'no') == 'yes')
                                    <span class="status-badge" style="background-color: #10b98120; color: #10b981;">
                                        <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        نعم
                                    </span>
                                @else
                                    <span class="status-badge" style="background-color: #dc262620; color: #dc2626;">
                                        <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        لا
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($workOrder->client_design_approval)
                                    @php
                                        $designApprovalColors = [
                                            'موافق' => '#10b981',
                                            'رفض' => '#dc2626',
                                            'لم يرد' => '#6b7280'
                                        ];
                                        $approvalColor = $designApprovalColors[$workOrder->client_design_approval] ?? '#6b7280';
                                    @endphp
                                    <span class="status-badge" style="background-color: {{ $approvalColor }}20; color: {{ $approvalColor }};">
                                        @if($workOrder->client_design_approval == 'موافق')
                                            <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @elseif($workOrder->client_design_approval == 'رفض')
                                            <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                        {{ $workOrder->client_design_approval }}
                                    </span>
                                @else
                                    <span class="status-badge" style="background-color: #6b728020; color: #6b7280;">
                                        <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        لم يرد
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge" style="background-color: {{ $color }}20; color: {{ $color }};">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('work-orders-list.show', $workOrder->id) }}" class="btn-view">عرض</a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 3rem; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0;">لا توجد بروفات</h3>
            <p style="font-size: 1rem; color: #6b7280; margin: 0 0 1.5rem 0;">لم يتم تحويل أي عرض سعر إلى بروفا بعد</p>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة الرئيسية
            </a>
        </div>
    @endif

    <script>
        function filterTable(filterType) {
            // Remove active class from all cards
            document.querySelectorAll('.stat-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Add active class to clicked card
            event.currentTarget.classList.add('active');
            
            // Get all table rows
            const rows = document.querySelectorAll('tbody tr[data-sent-to-designer]');
            
            rows.forEach(row => {
                const sentStatus = row.getAttribute('data-sent-to-designer');
                
                if (filterType === 'all') {
                    // Show all rows
                    row.style.display = '';
                } else if (filterType === 'sent') {
                    // Show only sent rows
                    row.style.display = sentStatus === 'sent' ? '' : 'none';
                } else if (filterType === 'not-sent') {
                    // Show only not sent rows
                    row.style.display = sentStatus === 'not-sent' ? '' : 'none';
                }
            });
        }
    </script>
</x-app-layout>

