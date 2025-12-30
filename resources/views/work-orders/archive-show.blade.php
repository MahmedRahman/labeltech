<x-app-layout>
    @php
        $title = 'تفاصيل الأرشيف';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل الأرشيف</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('work-orders.print', $workOrder) }}" target="_blank" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                طباعة
            </a>
            <a href="{{ route('work-orders.archive') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للأرشيف
            </a>
        </div>
    </div>

    <!-- Archive Status Notice -->
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border: 2px solid #dc2626;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <svg style="width: 24px; height: 24px; color: #dc2626; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #991b1b; margin: 0;">هذا العنصر في الأرشيف</p>
                        <p style="font-size: 0.75rem; color: #b91c1c; margin: 0.25rem 0 0 0;">تم أرشفة هذا العنصر</p>
                    </div>
                </div>
                <form action="{{ route('work-orders.archive.restore', $workOrder) }}" method="POST" style="display: inline-block;">
                    @csrf
                    <button type="submit" onclick="return confirm('هل أنت متأكد من إعادة عرض السعر مرة أخرى؟ سيتم تغيير الحالة إلى قيد الانتظار.')" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background-color: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        إعادة عرض السعر مرة أخرى
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!-- معلومات أساسية -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات أساسية</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 2rem;">
            <!-- Row 1 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">اسم الشغلانة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->job_name ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">أمر الشغل:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 600;">{{ $workOrder->order_number ?? 'بدون رقم' }}</span>
            </div>
            
            <!-- Row 2 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">التاريخ:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->created_at->format('d/m/Y') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">أسم العميل:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">
                    <a href="{{ route('clients.show', $workOrder->client) }}" style="color: #2563eb; text-decoration: none;">
                        {{ $workOrder->client->name }}
                    </a>
                </span>
            </div>
            
            <!-- Row 3 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">العرض:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->width ? number_format($workOrder->width, 1) : '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الطول:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->length ? number_format($workOrder->length, 1) : '-' }}</span>
            </div>
            
            <!-- Row 4 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">نوع الخامة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->material ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الاضافات:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->additions ?? 'لا يوجد' }}</span>
            </div>
            
            <!-- Row 5 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الكمية:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ number_format($workOrder->quantity) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">عدد الألوان:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->number_of_colors ?? '-' }}</span>
            </div>
        </div>
    </div>
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العميل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('clients.show', $workOrder->client) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                        {{ $workOrder->client->name }}
                    </a>
                </dd>
            </div>

            @if($workOrder->order_number)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رقم عرض السعر</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->order_number }}</dd>
            </div>
            @endif

            @if($workOrder->job_name)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اسم الشغلانه</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->job_name }}</dd>
            </div>
            @endif

            @if($workOrder->created_by)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشخص المسؤول</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->created_by }}</dd>
            </div>
            @endif

            @if($workOrder->client_response)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رد العميل على عرض السعر</dt>
                <dd style="margin: 0;">
                    @php
                        $clientResponseColors = [
                            'موافق' => '#10b981',
                            'رفض' => '#dc2626',
                            'لم يرد' => '#6b7280'
                        ];
                        $responseColor = $clientResponseColors[$workOrder->client_response] ?? '#6b7280';
                    @endphp
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $responseColor }}20; color: {{ $responseColor }};">
                        {{ $workOrder->client_response }}
                    </span>
                </dd>
            </div>
            @endif

            @if(($workOrder->status ?? '') === 'work_order')
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">إرسال إلى المصمم</dt>
                <dd style="margin: 0;">
                    @if(($workOrder->sent_to_designer ?? 'no') == 'yes')
                        <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: #8b5cf620; color: #8b5cf6;">
                            تم الإرسال
                        </span>
                    @else
                        <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: #6b728020; color: #6b7280;">
                            لم يتم الإرسال
                        </span>
                    @endif
                </dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الحالة</dt>
                <dd style="margin: 0;">
                    @php
                        $statusColors = [
                            'draft' => '#6b7280',
                            'pending' => '#f59e0b',
                            'in_progress' => '#2563eb',
                            'completed' => '#10b981',
                            'cancelled' => '#dc2626',
                            'work_order' => '#2563eb'
                        ];
                        $statusLabels = [
                            'draft' => 'مسودة',
                            'pending' => 'قيد الانتظار',
                            'in_progress' => 'قيد التنفيذ',
                            'completed' => 'مكتمل',
                            'cancelled' => 'ملغي',
                            'work_order' => 'أمر شغل'
                        ];
                        $color = $statusColors[$workOrder->status] ?? '#6b7280';
                        $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                    @endphp
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $color }}20; color: {{ $color }};">
                        {{ $label }}
                    </span>
                </dd>
            </div>

            @if($workOrder->production_status)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">حالة الإنتاج</dt>
                <dd style="margin: 0;">
                    @php
                        $productionStatusColors = [
                            'بدون حالة' => '#6b7280',
                            'طباعة' => '#2563eb',
                            'قص' => '#f59e0b',
                            'تقفيل' => '#10b981',
                            'أرشيف' => '#9ca3af'
                        ];
                        $prodStatus = $workOrder->production_status ?? 'بدون حالة';
                        $prodColor = $productionStatusColors[$prodStatus] ?? '#6b7280';
                    @endphp
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $prodColor }}20; color: {{ $prodColor }};">
                        {{ $prodStatus }}
                    </span>
                </dd>
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
    </div>

    <!-- معلومات المنتج -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات المنتج</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">البصمة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->fingerprint ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">✓ موجود</span>
                        @if($workOrder->fingerprint_price)
                            <span style="color: #111827; margin-right: 0.5rem;">- {{ number_format($workOrder->fingerprint_price, 2) }} ج.م</span>
                        @endif
                    @else
                        <span style="color: #6b7280;">✗ لا يوجد</span>
                    @endif
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">التكسير الخارجي</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->external_breaking ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">✓ موجود</span>
                        @if($workOrder->external_breaking_price)
                            <span style="color: #111827; margin-right: 0.5rem;">- {{ number_format($workOrder->external_breaking_price, 2) }} ج.م</span>
                        @endif
                    @else
                        <span style="color: #6b7280;">✗ لا يوجد</span>
                    @endif
                </dd>
            </div>

            @if($workOrder->additions && $workOrder->additions != 'لا يوجد')
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الإضافات المطلوبة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->additions }}</dd>
            </div>
            @endif

            @if($workOrder->final_product_shape)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">شكل المنتج النهائي</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 500;">{{ $workOrder->final_product_shape }}</dd>
            </div>
            @endif
        </div>
    </div>

    <!-- التجهيزات -->
    @if($workOrder->film_price || $workOrder->film_count || $workOrder->waste_per_roll || $workOrder->knife_exists)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">التجهيزات</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->film_price)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر الفيلم الواحد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->film_price, 2) }} ج.م</dd>
            </div>
            @endif

            @if($workOrder->film_count)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العدد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->film_count) }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">السكينة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->knife_exists ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">✓ موجود</span>
                        @if($workOrder->knife_price)
                            <span style="color: #111827; margin-right: 0.5rem;">- {{ number_format($workOrder->knife_price, 2) }} ج.م</span>
                        @endif
                    @else
                        <span style="color: #6b7280;">✗ لا يوجد</span>
                    @endif
                </dd>
            </div>
        </div>
    </div>
    @endif

    <!-- معلومات التصميم -->
    @if($workOrder->has_design ?? false)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #8b5cf6;">
            <svg style="width: 24px; height: 24px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات التصميم</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->design_shape)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشكل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_shape }}</dd>
            </div>
            @endif

            @if($workOrder->design_films)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">أفلام</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_films }}</dd>
            </div>
            @endif

            @if($workOrder->design_knives)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سكاكين</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_knives }}</dd>
            </div>
            @endif

            @if($workOrder->designKnife)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">السكينة المختارة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('knives.show', $workOrder->designKnife) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                        {{ $workOrder->designKnife->knife_code }} - {{ $workOrder->designKnife->type ?? 'بدون نوع' }}
                    </a>
                </dd>
            </div>
            @endif

            @if($workOrder->design_rows_count)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف في التصميم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->design_rows_count }}</dd>
            </div>
            @endif

            @if($workOrder->design_drills)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الدرافيل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_drills }}</dd>
            </div>
            @endif

            @if($workOrder->design_breaking_gear)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ترس التكسير</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_breaking_gear }}</dd>
            </div>
            @endif

            @if($workOrder->design_gab)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الجاب</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_gab }}</dd>
            </div>
            @endif

            @if($workOrder->design_cliches)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الكلاشيهات المعده</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_cliches }}</dd>
            </div>
            @endif

            @if($workOrder->design_file)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملف التصميم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ asset('storage/designs/' . $workOrder->design_file) }}" target="_blank" style="color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #eff6ff; border-radius: 0.375rem; border: 1px solid #bfdbfe;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        عرض الملف
                    </a>
                </dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- الحسابات الديناميكية -->
    @if(isset($calculations))
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid rgba(255, 255, 255, 0.3);">
            <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: white; margin: 0;">الحسابات</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">عرض الورق</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['paper_width'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">سم</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">المتر الطولي</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['linear_meter'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">م</span>
                </dd>
            </div>

            @if($calculations['waste'] ?? $workOrder->waste || $calculations['waste_percentage'] ?? $workOrder->waste_percentage)
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">الهالك + نسبة الهالك</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format(($calculations['waste'] ?? $workOrder->waste ?? 0) + ($calculations['waste_percentage'] ?? $workOrder->waste_percentage ?? 0), 2) }}
                </dd>
            </div>
            @endif

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">المتر الطولي + الهالك</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['linear_meter_with_waste'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">المتر المربع</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['square_meter'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">م²</span>
                </dd>
            </div>


            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_amount'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            @if($workOrder->sales_percentage && $workOrder->sales_percentage > 0)
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">نسبة المبيعات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['sales_percentage_amount'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
                <small style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.8); margin-top: 0.25rem; display: block;">
                    ({{ number_format($workOrder->sales_percentage, 2) }}% من إجمالي المبلغ)
                </small>
            </div>

            <div style="background: rgba(255, 255, 255, 0.15); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ + نسبة المبيعات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_amount_with_sales'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>
            @endif

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي التجهيزات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_preparations'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.2); padding: 1.25rem; border-radius: 0.5rem; backdrop-filter: blur(10px); border: 2px solid rgba(255, 255, 255, 0.3);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ شامل التجهيزات و نسبة المبيعات</dt>
                <dd style="font-size: 1.5rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_order'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">سعر الألف شامل التجهيزات و نسبة المبيعات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['price_per_thousand'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>
        </div>
    </div>
    @endif

    <!-- الملاحظات -->
    @if($workOrder->notes)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">ملاحظات</h3>
        </div>
        <div style="font-size: 0.875rem; color: #111827; line-height: 1.6; white-space: pre-wrap;">{{ $workOrder->notes }}</div>
    </div>
    @endif
</x-app-layout>
