<x-app-layout>
    @php
        $title = 'تفاصيل أمر الشغل - التشغيل';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل أمر الشغل</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('employee.production.work-orders') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
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
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 2rem;">
            <!-- Row 1 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">اسم الشغلانة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->job_name ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">رقم عرض السعر:</span>
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
                    {{ $workOrder->client->name ?? 'غير محدد' }}
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
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #8b5cf6;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 24px; height: 24px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات التصميم</h3>
            </div>
            <button type="button" onclick="toggleEditDesignFields()" id="edit-design-btn" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #8b5cf6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; font-size: 0.875rem;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                تعديل
            </button>
        </div>
        
        <!-- عرض البيانات -->
        <div id="design-fields-display" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
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
                    {{ $workOrder->designKnife->knife_code }} - {{ $workOrder->designKnife->type ?? 'بدون نوع' }}
                </dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف في التصميم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;" id="display-rows-count">{{ $workOrder->design_rows_count ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الدرافيل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;" id="display-drills">{{ $workOrder->design_drills ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ترس التكسير</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;" id="display-breaking-gear">{{ $workOrder->design_breaking_gear ?? '-' }}</dd>
            </div>

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
        
        <!-- نموذج التعديل -->
        <div id="design-fields-edit" style="display: none; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #e5e7eb;">
            <form action="{{ route('employee.production.work-orders.update-design-fields', $workOrder) }}" method="POST" id="edit-design-form">
                @csrf
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <div>
                        <label for="design_rows_count" style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف في التصميم</label>
                        <input type="number" id="design_rows_count" name="design_rows_count" value="{{ $workOrder->design_rows_count ?? '' }}" min="1" step="1" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827;">
                    </div>
                    
                    <div>
                        <label for="design_drills" style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الدرافيل</label>
                        <input type="text" id="design_drills" name="design_drills" value="{{ $workOrder->design_drills ?? '' }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827;">
                    </div>
                    
                    <div>
                        <label for="design_breaking_gear" style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ترس التكسير</label>
                        <input type="text" id="design_breaking_gear" name="design_breaking_gear" value="{{ $workOrder->design_breaking_gear ?? '' }}" style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827;">
                    </div>
                </div>
                
                <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                    <button type="submit" style="display: inline-flex; align-items: center; padding: 0.625rem 1.25rem; background-color: #10b981; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; font-size: 0.875rem;">
                        <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        حفظ
                    </button>
                    <button type="button" onclick="cancelEditDesignFields()" style="display: inline-flex; align-items: center; padding: 0.625rem 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; font-size: 0.875rem;">
                        <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        إلغاء
                    </button>
                </div>
            </form>
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
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->designer_gap }}</dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- السكاكين المختارة -->
    @if($workOrder->length && $workOrder->width && $workOrder->design_drills)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">السكاكين المختارة</h3>
        </div>
        
        @if($availableKnives && $availableKnives->count() > 0)
        <div style="margin-bottom: 1rem; padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">
                <strong>معايير البحث:</strong> الطول: {{ number_format($workOrder->length, 2) }} سم | العرض: {{ number_format($workOrder->width, 2) }} سم | الدرافيل: {{ $workOrder->design_drills }}
            </p>
        </div>
        
        <form action="{{ route('employee.production.work-orders.update-knife', $workOrder) }}" method="POST" id="select-knife-form">
            @csrf
            <div id="knives-cards-container" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                @foreach($availableKnives as $knife)
                <label class="knife-card" style="display: flex; flex-direction: column; padding: 1.25rem; border: 2px solid {{ $workOrder->design_knife_id == $knife->id ? '#10b981' : '#e5e7eb' }}; border-radius: 0.75rem; background-color: {{ $workOrder->design_knife_id == $knife->id ? '#ecfdf5' : '#ffffff' }}; cursor: pointer; transition: all 0.2s; box-shadow: {{ $workOrder->design_knife_id == $knife->id ? '0 4px 6px rgba(16, 185, 129, 0.2)' : '0 1px 3px rgba(0, 0, 0, 0.05)' }};">
                    <input type="radio" name="design_knife_id" value="{{ $knife->id }}" {{ $workOrder->design_knife_id == $knife->id ? 'checked' : '' }} style="display: none;" onchange="document.getElementById('select-knife-form').submit();">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                        <span style="font-size: 1rem; font-weight: 700; color: #111827;">{{ $knife->knife_code }}</span>
                        @if($workOrder->design_knife_id == $knife->id)
                        <svg style="width: 20px; height: 20px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        @endif
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; font-size: 0.875rem;">
                        <div>
                            <span style="color: #6b7280;">النوع:</span>
                            <span style="color: #111827; font-weight: 500; margin-right: 0.25rem;">{{ $knife->type ?? '-' }}</span>
                        </div>
                        <div>
                            <span style="color: #6b7280;">الترس:</span>
                            <span style="color: #111827; font-weight: 500; margin-right: 0.25rem;">{{ $knife->gear ?? '-' }}</span>
                        </div>
                        <div>
                            <span style="color: #6b7280;">الدرافيل:</span>
                            <span style="color: #111827; font-weight: 500; margin-right: 0.25rem;">{{ $knife->dragile_drive ?? '-' }}</span>
                        </div>
                        <div>
                            <span style="color: #6b7280;">عدد الصفوف:</span>
                            <span style="color: #111827; font-weight: 500; margin-right: 0.25rem;">{{ $knife->rows_count ?? '-' }}</span>
                        </div>
                        <div>
                            <span style="color: #6b7280;">الطول:</span>
                            <span style="color: #111827; font-weight: 500; margin-right: 0.25rem;">{{ $knife->length ? number_format($knife->length, 2) : '-' }} سم</span>
                        </div>
                        <div>
                            <span style="color: #6b7280;">العرض:</span>
                            <span style="color: #111827; font-weight: 500; margin-right: 0.25rem;">{{ $knife->width ? number_format($knife->width, 2) : '-' }} سم</span>
                        </div>
                    </div>
                    @if($knife->notes)
                    <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb;">
                        <span style="font-size: 0.75rem; color: #6b7280;">{{ \Illuminate\Support\Str::limit($knife->notes, 50) }}</span>
                    </div>
                    @endif
                </label>
                @endforeach
            </div>
        </form>
        @else
        <div style="padding: 2rem; text-align: center; background-color: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
            <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">لا توجد سكاكين متاحة بناءً على المعايير المحددة</p>
            <p style="font-size: 0.75rem; color: #9ca3af; margin: 0.5rem 0 0 0;">الطول: {{ number_format($workOrder->length, 2) }} سم | العرض: {{ number_format($workOrder->width, 2) }} سم | الدرافيل: {{ $workOrder->design_drills }}</p>
        </div>
        @endif
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
        // تحديث أسلوب الكاردات عند الاختيار
        document.addEventListener('DOMContentLoaded', function() {
            const knifeCards = document.querySelectorAll('.knife-card');
            
            knifeCards.forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                
                // تحديث الأسلوب عند hover
                card.addEventListener('mouseenter', function() {
                    if (!radio.checked) {
                        this.style.borderColor = '#10b981';
                        this.style.backgroundColor = '#f0fdf4';
                        this.style.transform = 'translateY(-2px)';
                        this.style.boxShadow = '0 4px 6px rgba(16, 185, 129, 0.2)';
                    }
                });
                
                card.addEventListener('mouseleave', function() {
                    if (!radio.checked) {
                        this.style.borderColor = '#e5e7eb';
                        this.style.backgroundColor = '#ffffff';
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                    }
                });
                
                // تحديث الأسلوب عند النقر
                card.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'INPUT') {
                        radio.checked = true;
                        updateKnifeCardsStyle();
                        document.getElementById('select-knife-form').submit();
                    }
                });
            });
        });
        
        function updateKnifeCardsStyle() {
            const knifeCards = document.querySelectorAll('.knife-card');
            knifeCards.forEach(card => {
                const radio = card.querySelector('input[type="radio"]');
                if (radio.checked) {
                    card.style.borderColor = '#10b981';
                    card.style.backgroundColor = '#ecfdf5';
                    card.style.boxShadow = '0 4px 6px rgba(16, 185, 129, 0.2)';
                } else {
                    card.style.borderColor = '#e5e7eb';
                    card.style.backgroundColor = '#ffffff';
                    card.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.05)';
                }
            });
        }
        
        function toggleEditDesignFields() {
            const displayDiv = document.getElementById('design-fields-display');
            const editDiv = document.getElementById('design-fields-edit');
            const editBtn = document.getElementById('edit-design-btn');
            
            if (displayDiv.style.display === 'none') {
                // إخفاء نموذج التعديل وإظهار البيانات
                displayDiv.style.display = 'grid';
                editDiv.style.display = 'none';
                editBtn.textContent = 'تعديل';
                editBtn.innerHTML = '<svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> تعديل';
            } else {
                // إظهار نموذج التعديل وإخفاء البيانات
                displayDiv.style.display = 'none';
                editDiv.style.display = 'block';
                editBtn.textContent = 'إلغاء';
                editBtn.innerHTML = '<svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> إلغاء';
            }
        }
        
        function cancelEditDesignFields() {
            const displayDiv = document.getElementById('design-fields-display');
            const editDiv = document.getElementById('design-fields-edit');
            const editBtn = document.getElementById('edit-design-btn');
            
            displayDiv.style.display = 'grid';
            editDiv.style.display = 'none';
            editBtn.textContent = 'تعديل';
            editBtn.innerHTML = '<svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> تعديل';
            
            // إعادة تعيين القيم إلى القيم الأصلية
            document.getElementById('design_rows_count').value = '{{ $workOrder->design_rows_count ?? '' }}';
            document.getElementById('design_drills').value = '{{ $workOrder->design_drills ?? '' }}';
            document.getElementById('design_breaking_gear').value = '{{ $workOrder->design_breaking_gear ?? '' }}';
        }
        
        // تحديث البيانات بعد الحفظ الناجح
        @php
            $hasSuccess = session('success');
        @endphp
    </script>
    @if($hasSuccess)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const displayRowsCount = document.getElementById('display-rows-count');
            const displayDrills = document.getElementById('display-drills');
            const displayBreakingGear = document.getElementById('display-breaking-gear');
            
            if (displayRowsCount) {
                displayRowsCount.textContent = document.getElementById('design_rows_count').value || '-';
            }
            if (displayDrills) {
                displayDrills.textContent = document.getElementById('design_drills').value || '-';
            }
            if (displayBreakingGear) {
                displayBreakingGear.textContent = document.getElementById('design_breaking_gear').value || '-';
            }
            
            cancelEditDesignFields();
        });
    </script>
    @endif
</x-app-layout>

