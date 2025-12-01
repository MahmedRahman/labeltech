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

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">البصمة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->fingerprint ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">موجود</span>
                    @else
                        <span style="color: #6b7280;">لا</span>
                    @endif
                </dd>
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

        @if($workOrder->has_design ?? false)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #8b5cf6;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
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
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملف التصميم</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                        <a href="{{ asset('storage/designs/' . $workOrder->design_file) }}" target="_blank" style="color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        @if($workOrder->has_production ?? false)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #10b981;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات التشغيل</h3>
            </div>

            <!-- بيانات التشغيل المدخلة -->
            <div style="margin-bottom: 2rem; padding: 1rem; background-color: #f9fafb; border-radius: 0.5rem;">
                <h4 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">البيانات المدخلة</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    @if($workOrder->paper_width)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عرض الورق</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->paper_width, 2) }} سم</dd>
                    </div>
                    @endif
                    @if($workOrder->paper_weight)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">الوزن</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->paper_weight, 2) }} جرام/م²</dd>
                    </div>
                    @endif
                    @if($workOrder->waste_percentage)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">نسبة الهالك</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->waste_percentage, 2) }}%</dd>
                    </div>
                    @endif
                    @if($workOrder->number_of_rolls)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد التكت في البكره</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->number_of_rolls }}</dd>
                    </div>
                    @endif
                    @if($workOrder->core_size)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">مقاس الكور</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->core_size, 2) }} سم</dd>
                    </div>
                    @endif
                    @if($workOrder->pieces_per_sheet)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد التكت في الشيت</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->pieces_per_sheet }}</dd>
                    </div>
                    @endif
                    @if($workOrder->sheets_per_stack)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد الشيت في الراكوة</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->sheets_per_stack }}</dd>
                    </div>
                    @endif
                    @if($workOrder->pieces_per_stack)
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد التكت في الراكوة</dt>
                        <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->pieces_per_stack }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            @if(isset($calculations))
            <!-- حسابات الورق الأساسية -->
            <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #eff6ff; border-radius: 0.5rem; border-left: 4px solid #2563eb;">
                <h4 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">🔸 حسابات الورق الأساسية</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">المتر الطولي الصافي</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['basic']['net_linear_meters'], 4) }} م</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">المتر الطولي + نسبة الهالك</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['basic']['linear_meters_with_waste'], 4) }} م</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">المتر المربع (للقطعة)</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['basic']['square_meters_per_piece'], 4) }} م²</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">المتر المربع (الإجمالي)</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['basic']['total_square_meters'], 2) }} م²</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">الوزن الكلي (كجم)</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['basic']['total_weight_kg'], 2) }} كجم</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">الوزن الكلي (طن)</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['basic']['total_weight_ton'], 4) }} طن</dd>
                    </div>
                </div>
            </div>

            @if($workOrder->final_product_shape == 'بكر' && isset($calculations['roll']))
            <!-- حسابات البكر -->
            <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #f0fdf4; border-radius: 0.5rem; border-left: 4px solid #10b981;">
                <h4 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">🔸 لو التشغيل "بكر"</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">مقاس البكر</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['roll']['roll_size'], 2) }} سم</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد التكرار للقص</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['roll']['cutting_repeat_count'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد التكرار للفظ (Output Per Roll)</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['roll']['output_per_roll'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">إجمالي عدد الامتار للبكرة الواحدة</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ number_format($calculations['roll']['total_meters_per_roll'], 2) }} م</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">إجمالي عدد التكت في البكر</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['roll']['total_pieces_per_roll'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">إجمالي عدد الأطقم من البكر</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['roll']['total_sets_from_roll'] }}</dd>
                    </div>
                </div>
            </div>
            @endif

            @if($workOrder->final_product_shape == 'شيت' && isset($calculations['sheet']))
            <!-- حسابات الشيت -->
            <div style="margin-bottom: 2rem; padding: 1.5rem; background-color: #fef3c7; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
                <h4 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">🔸 لو التشغيل "شيت"</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد الشيت في الراكوة</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['sheet']['sheets_per_stack'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">عدد التكت في الشيت</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['sheet']['pieces_per_sheet'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">إجمالي عدد التكت في الراكوة</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['sheet']['pieces_per_stack'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">إجمالي عدد التكت المطلوب لإنتاج عدد الأطقم</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['sheet']['total_pieces_needed'] }}</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.25rem;">إجمالي عدد الشيت المطلوب للإنتاج</dt>
                        <dd style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $calculations['sheet']['total_sheets_needed'] }}</dd>
                    </div>
                </div>
            </div>
            @endif

            <!-- النواتج النهائية -->
            <div style="margin-bottom: 2rem; padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 0.5rem; color: white;">
                <h4 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: white;">🔸 نواتج نهائية</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; opacity: 0.9; margin-bottom: 0.25rem;">إجمالي الإنتاج النهائي</dt>
                        <dd style="font-size: 1.25rem; font-weight: 700; margin: 0;">{{ number_format($calculations['final']['total_production']) }} طقم</dd>
                    </div>
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; opacity: 0.9; margin-bottom: 0.25rem;">الهالك الفعلي المستهلك</dt>
                        <dd style="font-size: 1.25rem; font-weight: 700; margin: 0;">{{ number_format($calculations['final']['actual_waste_consumed'], 2) }} م</dd>
                    </div>
                    @if($workOrder->final_product_shape == 'بكر' && $calculations['final']['rolls_needed'])
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; opacity: 0.9; margin-bottom: 0.25rem;">عدد البكر المطلوبة</dt>
                        <dd style="font-size: 1.25rem; font-weight: 700; margin: 0;">{{ $calculations['final']['rolls_needed'] }} بكر</dd>
                    </div>
                    @endif
                    @if($workOrder->final_product_shape == 'شيت' && $calculations['final']['stacks_needed'])
                    <div>
                        <dt style="font-size: 0.875rem; font-weight: 500; opacity: 0.9; margin-bottom: 0.25rem;">عدد الراكوات</dt>
                        <dd style="font-size: 1.25rem; font-weight: 700; margin: 0;">{{ $calculations['final']['stacks_needed'] }} راكوة</dd>
                    </div>
                    @endif
                </div>
            </div>
            @endif
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




