<x-app-layout>
    @php
        $title = 'تفاصيل أمر الشغل';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل أمر الشغل</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('work-orders.design.show', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%); color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 2px 4px rgba(139, 92, 246, 0.3);">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                {{ ($workOrder->has_design ?? false) ? 'تعديل التصميم' : 'إضافة التصميم' }}
            </a>
            <a href="{{ route('work-orders.print', $workOrder) }}" target="_blank" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                طباعة
            </a>
            <a href="{{ route('work-orders.edit', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
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
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
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
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رقم أمر الشغل</dt>
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
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الخامة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 500;">{{ $workOrder->material }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الكمية</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->quantity) }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الألوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->number_of_colors }}</dd>
            </div>

            @if($workOrder->rows_count)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->rows_count }}</dd>
            </div>
            @endif

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

            @if($workOrder->width && $workOrder->length)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الأبعاد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }} سم
                </dd>
            </div>
            @endif

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
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اتجاه اللف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @php
                        $windingDirection = $workOrder->winding_direction ?? 'no';
                        if ($windingDirection == 'clockwise') {
                            $windingLabel = 'في اتجاه عقارب الساعة';
                            $windingColor = '#10b981';
                        } elseif ($windingDirection == 'counterclockwise') {
                            $windingLabel = 'عكس عقارب الساعة';
                            $windingColor = '#f59e0b';
                        } elseif ($windingDirection == 'yes') {
                            $windingLabel = 'يوجد';
                            $windingColor = '#2563eb';
                        } else {
                            $windingLabel = 'لا يوجد';
                            $windingColor = '#6b7280';
                        }
                    @endphp
                    <span style="color: {{ $windingColor }}; font-weight: 500;">{{ $windingLabel }}</span>
                </dd>
            </div>

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

            @if($workOrder->addition_price)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر الإضافة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->addition_price, 2) }} ج.م</dd>
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
    @if($workOrder->film_price || $workOrder->film_count || $workOrder->sales_percentage || $workOrder->material_price_per_meter || $workOrder->manufacturing_price_per_meter)
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

            @if($workOrder->sales_percentage)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نسبة المبيعات</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->sales_percentage, 2) }}%</dd>
            </div>
            @endif

            @if($workOrder->material_price_per_meter)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر المتر الخامة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->material_price_per_meter, 2) }} ج.م</dd>
            </div>
            @endif

            @if($workOrder->manufacturing_price_per_meter)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر متر التصنيع</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->manufacturing_price_per_meter, 2) }} ج.م</dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- بيانات التشغيل -->
    @if($workOrder->has_production || $workOrder->paper_width || $workOrder->paper_weight || $workOrder->waste_percentage || $workOrder->number_of_rolls || $workOrder->core_size || $workOrder->pieces_per_sheet || $workOrder->sheets_per_stack || $workOrder->pieces_per_stack)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">بيانات التشغيل</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->paper_width)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عرض الورق</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->paper_width, 2) }} سم</dd>
            </div>
            @endif

            @if($workOrder->paper_weight)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوزن</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->paper_weight, 2) }} جرام/م²</dd>
            </div>
            @endif

            @if($workOrder->waste_percentage)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نسبة الهالك</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->waste_percentage, 2) }}%</dd>
            </div>
            @endif

            @if($workOrder->final_product_shape == 'بكر')
                @if($workOrder->number_of_rolls)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد التكت في البكره</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->number_of_rolls) }}</dd>
                </div>
                @endif

                @if($workOrder->core_size)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">مقاس الكور</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->core_size, 0) }} مم</dd>
                </div>
                @endif
            @elseif($workOrder->final_product_shape == 'شيت')
                @if($workOrder->pieces_per_sheet)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد التكت في الشيت</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->pieces_per_sheet) }}</dd>
                </div>
                @endif

                @if($workOrder->sheets_per_stack)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الشيت في الراكوة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->sheets_per_stack) }}</dd>
                </div>
                @endif

                @if($workOrder->pieces_per_stack)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد التكت في الراكوة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->pieces_per_stack) }}</dd>
                </div>
                @endif
            @endif
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
