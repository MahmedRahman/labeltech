<x-app-layout>
    @php
        $title = 'تفاصيل أمر الشغل';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل أمر الشغل</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('work-orders.edit', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العميل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('clients.show', $workOrder->client) }}" style="color: #2563eb; text-decoration: none;">
                        {{ $workOrder->client->name }}
                    </a>
                </dd>
            </div>

            @if($workOrder->order_number)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رقم أمر الشغل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->order_number }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الحالة</dt>
                <dd style="margin: 0;">
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
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $color }}20; color: {{ $color }};">
                        {{ $label }}
                    </span>
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الخامة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->material }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الكمية</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->quantity }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الألوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->number_of_colors }}</dd>
            </div>

            @if($workOrder->width)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العرض</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->width, 2) }} سم</dd>
            </div>
            @endif

            @if($workOrder->length)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الطول</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->length, 2) }} سم</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإنشاء</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->created_at->format('Y-m-d H:i') }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">آخر تحديث</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->updated_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>

        @if($workOrder->final_product_shape)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">شكل المنتج النهائي</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $workOrder->final_product_shape }}</dd>
        </div>
        @endif

        @if($workOrder->additions)
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الإضافات المطلوبة</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $workOrder->additions }}</dd>
        </div>
        @endif

        @if($workOrder->notes)
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $workOrder->notes }}</dd>
        </div>
        @endif
    </div>
</x-app-layout>

