<x-app-layout>
    @php
        $title = 'أوامر الشغل المرسلة إلى المصمم';
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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-card-title {
            font-size: 0.875rem;
            font-weight: 600;
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
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">أوامر الشغل المرسلة إلى المصمم</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">عرض جميع أوامر الشغل المرسلة إلى المصمم</p>
        </div>
        <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            العودة للقائمة
        </a>
    </div>

    <!-- Statistics Card -->
    <div class="stats-cards">
        <!-- Total Sent to Designer Card -->
        <div class="stat-card active">
            <div class="stat-card-header">
                <h3 class="stat-card-title">إجمالي المرسلة إلى المصمم</h3>
                <div class="stat-card-icon" style="background-color: #dbeafe;">
                    <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <p class="stat-card-value" style="color: #2563eb;">{{ $totalCount ?? 0 }}</p>
        </div>
    </div>

    @if(isset($workOrders) && $workOrders->count() > 0)
        <!-- Table View -->
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>تاريخ الإنشاء</th>
                        <th>رقم البروفا</th>
                        <th>العميل</th>
                        <th>الخامة</th>
                        <th>الكمية</th>
                        <th>المقاس</th>
                        <th>عدد الألوان</th>
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
                        <tr>
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
                            <td>{{ $workOrder->number_of_colors ?? '-' }}</td>
                            <td>
                                <span class="status-badge" style="background-color: {{ $color }}20; color: {{ $color }}; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('work-orders.sent-to-designer.show', $workOrder->id) }}" class="btn-view">عرض</a>
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
            <h3 style="font-size: 1.25rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0;">لا توجد أوامر شغل مرسلة إلى المصمم</h3>
            <p style="font-size: 1rem; color: #6b7280; margin: 0 0 1.5rem 0;">لا توجد أوامر شغل مرسلة إلى المصمم حالياً</p>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة الرئيسية
            </a>
        </div>
    @endif
</x-app-layout>

