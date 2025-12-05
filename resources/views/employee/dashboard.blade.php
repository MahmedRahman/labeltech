<x-employee-layout>
    @php
        $title = 'لوحة التحكم';
    @endphp

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-label">إجمالي أوامر الشغل</div>
            <div class="stat-number">{{ $workOrdersCount }}</div>
        </div>
    </div>

    <div style="background-color: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <div class="table-header">
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">أحدث أوامر الشغل</h3>
        </div>
        <div class="table-content">
            @if($recentWorkOrders->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>رقم أمر الشغل</th>
                                <th>العميل</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentWorkOrders as $workOrder)
                                <tr>
                                    <td>#{{ $workOrder->id }}</td>
                                    <td>{{ $workOrder->client->name ?? 'غير محدد' }}</td>
                                    <td>{{ $workOrder->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background-color: #dbeafe; color: #1e40af;">
                                            {{ $workOrder->production_status ?? 'بدون حالة' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('employee.work-orders.show', $workOrder) }}" style="color: #2563eb; text-decoration: none; font-weight: 500; margin-left: 0.5rem;">عرض</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #6b7280; padding: 2rem;">لا توجد أوامر شغل حالياً</p>
            @endif
        </div>
    </div>
</x-employee-layout>




