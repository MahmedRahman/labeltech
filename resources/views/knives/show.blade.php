<x-app-layout>
    @php
        $title = 'تفاصيل السكينة';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل السكينة</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $knife->knife_name }} - {{ $knife->knife_code }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('knives.edit', $knife) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('knives.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <!-- معلومات أساسية -->
        <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">معلومات أساسية</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">كود السكينة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $knife->knife_code }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اسم السكينة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $knife->knife_name }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نوع السكينة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->knife_type ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">المقاس</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->size ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">حالة السكينة</dt>
                    <dd style="margin: 0;">
                        @php
                            $statusColors = [
                                'active' => ['bg' => '#d1fae5', 'text' => '#065f46', 'label' => 'نشط'],
                                'inactive' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'غير نشط'],
                                'maintenance' => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'صيانة'],
                                'retired' => ['bg' => '#e5e7eb', 'text' => '#374151', 'label' => 'متقاعد'],
                            ];
                            $status = $statusColors[$knife->knife_status] ?? $statusColors['inactive'];
                        @endphp
                        <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $status['bg'] }}; color: {{ $status['text'] }};">
                            {{ $status['label'] }}
                        </span>
                    </dd>
                </div>
            </div>
        </div>

        <!-- المواصفات الفنية -->
        <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">المواصفات الفنية</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->rows_count ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد العيون</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->eyes_count ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">حجم الجيب</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->flap_size ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اتجاه البحر</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->grain_direction ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سُمك السكينة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->knife_thickness ? number_format($knife->knife_thickness, 2) : '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">خطوط التكسير</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->crease_lines ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الثقوب</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->punch_holes ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">مقاس البرّافات</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->drill_size ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نوع المعدن</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->material_type ?? '-' }}</dd>
                </div>
            </div>
        </div>

        <!-- معلومات الإدارة -->
        <div style="margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">معلومات الإدارة</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الشراء</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->purchase_date ? $knife->purchase_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الاستخدام</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->usage_count }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">مكان التخزين</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->storage_location ?? '-' }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإنشاء</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->created_at->format('Y-m-d H:i') }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">آخر تحديث</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->updated_at->format('Y-m-d H:i') }}</dd>
                </div>
            </div>
        </div>

        @if($knife->notes)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $knife->notes }}</dd>
        </div>
        @endif
    </div>
</x-app-layout>

