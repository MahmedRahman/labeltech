<x-app-layout>
    @php
        $title = 'الأرشيف - أوامر الشغل';
    @endphp

    <style>
        .table-container {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-content {
            padding: 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background-color: #f9fafb;
        }

        .table th {
            padding: 0.75rem 1rem;
            text-align: right;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .table td {
            padding: 1rem;
            text-align: right;
            font-size: 0.875rem;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-design {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            color: white;
        }

        .badge-status {
            padding: 0.25rem 0.5rem;
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
    </style>

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">الأرشيف - أوامر الشغل</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">جميع أوامر الشغل المؤرشفة</p>
        </div>
        <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة إلى أوامر الشغل
        </a>
    </div>

    @if($workOrders->count() > 0)
        <div class="table-container">
            <div class="table-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>رقم الأمر</th>
                            <th>العميل</th>
                            <th>الخامة</th>
                            <th>الكمية</th>
                            <th>عدد الألوان</th>
                            <th>الحالة</th>
                            <th>التصميم</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workOrders as $workOrder)
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
                            <tr>
                                <td style="font-weight: 600; color: #111827;">{{ $workOrder->order_number ?? 'بدون رقم' }}</td>
                                <td>{{ $workOrder->client->name }}</td>
                                <td>{{ $workOrder->material }}</td>
                                <td>{{ number_format($workOrder->quantity) }}</td>
                                <td>{{ $workOrder->number_of_colors }}</td>
                                <td>
                                    <span class="badge badge-status status-{{ $workOrder->status }}">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    @if($workOrder->has_design ?? false)
                                        <span class="badge badge-design">✓</span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>{{ $workOrder->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('work-orders.show', $workOrder) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('work-orders.edit', $workOrder) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $workOrders->links() }}
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">لا توجد أوامر مؤرشفة</h3>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 2rem;">لم يتم أرشفة أي أوامر شغل حتى الآن</p>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                العودة إلى أوامر الشغل
            </a>
        </div>
    @endif
</x-app-layout>



