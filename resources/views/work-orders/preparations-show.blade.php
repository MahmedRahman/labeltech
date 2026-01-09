<x-app-layout>
    @php
        $title = 'تفاصيل التجهيزات';
        $isEmployee = auth('employee')->check();
        $isAdmin = auth('web')->check();
        $employeeAccountType = $isEmployee ? auth('employee')->user()->account_type : null;
        $isSalesEmployee = $isEmployee && $employeeAccountType === 'مبيعات';
        $isDesignEmployee = $isEmployee && $employeeAccountType === 'تصميم';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل التجهيزات</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            @if(!$isSalesEmployee && !$isDesignEmployee)
            <a href="{{ route('work-orders.print', $workOrder) }}" target="_blank" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                طباعة
            </a>
            <a href="{{ route('work-orders.edit', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            @endif
            @if($isDesignEmployee)
            <a href="{{ route('employee.designer.preparations') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
            @else
            <a href="{{ route('work-orders.preparations') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
            @endif
        </div>
    </div>

    <!-- Add Preparations Section - For Designer Only -->
    @if($isDesignEmployee && ($workOrder->status ?? '') === 'in_progress')
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 2px solid #2563eb;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e40af; margin: 0;">إضافة التجهيزات</h3>
            </div>
            <p style="font-size: 0.875rem; color: #1e40af; margin-bottom: 1.5rem;">يمكنك تعديل عدد الألوان والدرايفيل وترس التكسير وعرض الورق.</p>
            <a href="{{ route('employee.designer.preparations.edit', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: all 0.2s; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                إضافة/تعديل التجهيزات
            </a>
        </div>
    </div>
    @endif

    <!-- Move to Production Section -->
    @if(($workOrder->status ?? '') === 'in_progress' && !$isSalesEmployee)
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #f59e0b;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #92400e; margin: 0;">نقل إلى التشغيل</h3>
            </div>
            <p style="font-size: 0.875rem; color: #b45309; margin-bottom: 1.5rem;">بعد اكتمال التجهيزات، يمكنك نقل الطلب إلى التشغيل.</p>
            <form action="{{ route('work-orders.move-to-production', $workOrder) }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('هل أنت متأكد من نقل الطلب إلى التشغيل؟')" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                    <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    نقل إلى التشغيل
                </button>
            </form>
        </div>
    </div>
    @endif


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
            @if($workOrder->film_price && !$isDesignEmployee)
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

    <!-- التصميم -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #8b5cf6;">
            <svg style="width: 24px; height: 24px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">التصميم</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 2rem;">
            <!-- Left Column -->
            <div>
                @if($workOrder->designKnife)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">سكاكين:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">
                        <a href="{{ route('knives.show', $workOrder->designKnife) }}" style="color: #2563eb; text-decoration: none;">
                            {{ $workOrder->designKnife->knife_code ?? '-' }}
                        </a>
                    </span>
                </div>
                @endif
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">ترس التكسير:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->design_breaking_gear ?? ($workOrder->breaking_gear ?? '-') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">عدد الصفوف:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->design_rows_count ?? ($workOrder->rows_count ?? '-') }}</span>
                </div>
            </div>
            <!-- Right Column -->
            <div>
                @if($workOrder->design_shape)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الشكل:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->design_shape }}</span>
                </div>
                @endif
                @if($workOrder->design_films)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">افلام:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->design_films }}</span>
                </div>
                @else
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">افلام:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">جديده</span>
                </div>
                @endif
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الدرافيل:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->design_drills ?? ($workOrder->drills ?? '-') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الجاب:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500; background-color: #fef3c7; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">{{ $workOrder->design_gab ?? ($workOrder->gab ?? '-') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                    <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الاكلاشيهات المعادة:</span>
                    <span style="font-size: 0.875rem; color: #111827; font-weight: 500; border: 2px solid #10b981; padding: 0.25rem 0.5rem; border-radius: 0.25rem;">{{ $workOrder->design_cliches ?? ($workOrder->cliches ?? '0') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- تجهيزات المصمم -->
    @if($workOrder->designer_number_of_colors || $workOrder->designer_drills || $workOrder->designer_breaking_gear || $workOrder->designer_paper_width || $workOrder->designer_gap)
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 2px solid #2563eb;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #2563eb;">
            <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e40af; margin: 0;">تجهيزات المصمم</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->designer_number_of_colors)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الألوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->designer_number_of_colors }}</dd>
                @if($workOrder->number_of_colors)
                <small style="font-size: 0.75rem; color: #9ca3af;">(الأصلي: {{ $workOrder->number_of_colors }})</small>
                @endif
            </div>
            @endif

            @if($workOrder->designer_drills)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الدرايفيل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->designer_drills }}</dd>
                @if($workOrder->design_drills)
                <small style="font-size: 0.75rem; color: #9ca3af;">(الأصلي: {{ $workOrder->design_drills }})</small>
                @endif
            </div>
            @endif

            @if($workOrder->designer_breaking_gear)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ترس التكسير</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->designer_breaking_gear }}</dd>
                @if($workOrder->design_breaking_gear)
                <small style="font-size: 0.75rem; color: #9ca3af;">(الأصلي: {{ $workOrder->design_breaking_gear }})</small>
                @endif
            </div>
            @endif

            @if($workOrder->designer_paper_width)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عرض الورق</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->designer_paper_width, 2) }} سم</dd>
                @if($workOrder->paper_width)
                <small style="font-size: 0.75rem; color: #9ca3af;">(الأصلي: {{ number_format($workOrder->paper_width, 2) }} سم)</small>
                @endif
            </div>
            @endif

            @if($workOrder->designer_gap)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الجاب الدرافيل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->designer_gap, 2) }}</dd>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update client design approval card styles
            function updateClientDesignApprovalStyle() {
                const designApprovalColors = {
                    'موافق': '#10b981',
                    'رفض': '#dc2626',
                    'لم يرد': '#6b7280'
                };
                
                document.querySelectorAll('input[name="client_design_approval"]').forEach(radio => {
                    const label = radio.closest('label.client-design-approval-card');
                    if (label) {
                        const value = radio.value;
                        const color = designApprovalColors[value] || '#6b7280';
                        
                        if (radio.checked) {
                            label.style.borderColor = color;
                            label.style.backgroundColor = color + '20';
                            label.style.borderWidth = '2px';
                            const span = label.querySelector('span');
                            if (span) {
                                span.style.color = color;
                            }
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                            label.style.borderWidth = '2px';
                            const span = label.querySelector('span');
                            if (span) {
                                span.style.color = '#111827';
                            }
                        }
                    }
                });
            }
            
            // Initialize styles on page load
            updateClientDesignApprovalStyle();
            
            // Update styles when radio buttons change
            document.querySelectorAll('input[name="client_design_approval"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    updateClientDesignApprovalStyle();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label.client-design-approval-card');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            setTimeout(function() {
                                updateClientDesignApprovalStyle();
                            }, 10);
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
