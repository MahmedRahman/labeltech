<x-app-layout>
    @php
        $title = 'قائمة أوامر الشغل';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة أوامر الشغل</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع أوامر الشغل من مكان واحد</p>
        </div>
        <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة أمر شغل جديد
        </a>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($workOrders->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>رقم الأمر</th>
                            <th>العميل</th>
                            <th>الخامة</th>
                            <th>الكمية</th>
                            <th>عدد الألوان</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workOrders as $workOrder)
                            <tr>
                                <td style="font-weight: 500; color: #111827;">{{ $workOrder->order_number ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $workOrder->client->name }}</td>
                                <td style="color: #6b7280;">{{ $workOrder->material }}</td>
                                <td style="color: #6b7280;">{{ $workOrder->quantity }}</td>
                                <td style="color: #6b7280;">{{ $workOrder->number_of_colors }}</td>
                                <td>
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
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: {{ $color }}20; color: {{ $color }};">
                                        {{ $label }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('work-orders.show', $workOrder) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('work-orders.edit', $workOrder) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('work-orders.destroy', $workOrder) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا الأمر؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $workOrders->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد أوامر شغل</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة أمر شغل جديد</p>
                    <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة أمر شغل جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

