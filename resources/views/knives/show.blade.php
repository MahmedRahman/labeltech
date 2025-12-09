<x-app-layout>
    @php
        $title = 'تفاصيل السكينة';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل السكينة</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $knife->knife_code }}</p>
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
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الرقم الكود</dt>
                <dd style="font-size: 1.125rem; color: #111827; margin: 0; font-weight: 600;">{{ $knife->knife_code }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">النوع</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->type ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تُرس</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->gear ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">دراغيل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->dragile_drive ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->rows_count ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد العيون</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->eyes_count ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الجيب</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->flap_size ?? '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الطول</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->length ? number_format($knife->length, 2) : '-' }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العرض</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $knife->width ? number_format($knife->width, 2) : '-' }}</dd>
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

        @if($knife->notes)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $knife->notes }}</dd>
        </div>
        @endif
    </div>
</x-app-layout>
