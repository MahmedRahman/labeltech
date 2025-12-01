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

    @if($workOrders->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
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
                <div style="background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); padding: 1.5rem; transition: all 0.2s ease-in-out; border: 2px solid {{ ($workOrder->has_design ?? false) ? '#8b5cf6' : '#e5e7eb' }}; position: relative; hover:shadow-lg;">
                    @if($workOrder->has_design ?? false)
                    <!-- Badges Container -->
                    <div style="position: absolute; top: -10px; right: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        @if($workOrder->has_design ?? false)
                        <!-- Design Indicator Badge -->
                        <div style="background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%); color: white; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; box-shadow: 0 2px 4px rgba(139, 92, 246, 0.3); display: flex; align-items: center; gap: 0.375rem;">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            التصميم
                        </div>
                        @endif
                    </div>
                    @endif
                    <!-- Card Header -->
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb; margin-top: {{ ($workOrder->has_design ?? false) ? '0.5rem' : '0' }};">
                        <div>
                            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">
                                {{ $workOrder->order_number ?? 'بدون رقم' }}
                            </h3>
                            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                                {{ $workOrder->client->name }}
                            </p>
                        </div>
                        <span style="display: inline-block; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: {{ $color }}20; color: {{ $color }};">
                            {{ $label }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div style="margin-bottom: 1rem;">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1rem;">
                            <div>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الخامة</p>
                                <p style="font-size: 0.875rem; font-weight: 500; color: #111827; margin: 0;">{{ $workOrder->material }}</p>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الكمية</p>
                                <p style="font-size: 0.875rem; font-weight: 500; color: #111827; margin: 0;">{{ number_format($workOrder->quantity) }}</p>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">عدد الألوان</p>
                                <p style="font-size: 0.875rem; font-weight: 500; color: #111827; margin: 0;">{{ $workOrder->number_of_colors }}</p>
                            </div>
                            @if($workOrder->width && $workOrder->length)
                            <div>
                                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الأبعاد</p>
                                <p style="font-size: 0.875rem; font-weight: 500; color: #111827; margin: 0;">
                                    {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }} سم
                                </p>
                            </div>
                            @endif
                        </div>

                        @if($workOrder->additions)
                        <div style="margin-bottom: 0.75rem; padding: 0.75rem; background-color: #f9fafb; border-radius: 0.5rem;">
                            <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem 0;">الإضافات</p>
                            <p style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->additions }}</p>
                        </div>
                        @endif

                        @if(($workOrder->fingerprint ?? 'no') == 'yes')
                        <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem; background-color: #ecfdf5; border-radius: 0.5rem; margin-bottom: 0.75rem;">
                            <svg style="width: 16px; height: 16px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span style="font-size: 0.875rem; color: #059669; font-weight: 500;">بصمة: موجود</span>
                        </div>
                        @endif

                        <div style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.75rem;">
                            {{ $workOrder->created_at->format('Y-m-d') }}
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div style="padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                        <!-- Design Button -->
                        <a href="{{ route('work-orders.design.show', $workOrder) }}" style="display: block; width: 100%; text-align: center; padding: 0.75rem; background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem; transition: all 0.2s; box-shadow: 0 2px 4px rgba(139, 92, 246, 0.3);">
                            <svg style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            {{ ($workOrder->has_design ?? false) ? 'تعديل التصميم' : 'إضافة التصميم' }}
                        </a>
                        
                        <!-- Other Actions -->
                        <div style="display: flex; gap: 0.75rem;">
                            <a href="{{ route('work-orders.show', $workOrder) }}" style="flex: 1; text-align: center; padding: 0.625rem; background-color: #eff6ff; color: #2563eb; text-decoration: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;">
                                عرض
                            </a>
                            <a href="{{ route('work-orders.edit', $workOrder) }}" style="flex: 1; text-align: center; padding: 0.625rem; background-color: #f0fdf4; color: #10b981; text-decoration: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;">
                                تعديل
                            </a>
                            <form action="{{ route('work-orders.destroy', $workOrder) }}" method="POST" style="flex: 1; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا الأمر؟')" style="width: 100%; padding: 0.625rem; background-color: #fef2f2; color: #dc2626; border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: all 0.2s;">
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $workOrders->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 0.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <svg style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.5rem;">لا توجد أوامر شغل</h3>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 2rem;">ابدأ بإضافة أمر شغل جديد</p>
            <a href="{{ route('work-orders.create') }}" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة أمر شغل جديد
            </a>
        </div>
    @endif
</x-app-layout>




