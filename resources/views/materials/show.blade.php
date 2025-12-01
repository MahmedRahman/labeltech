<x-app-layout>
    @php
        $title = 'بيانات الخامة';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">بيانات الخامة</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $material->name }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('materials.edit', $material) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('materials.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اسم الخامة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $material->name }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الحالة</dt>
                <dd style="margin: 0;">
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $material->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $material->is_active ? '#065f46' : '#991b1b' }};">
                        {{ $material->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإنشاء</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $material->created_at->format('Y-m-d H:i') }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">آخر تحديث</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $material->updated_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>

        @if($material->description)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوصف</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $material->description }}</dd>
        </div>
        @endif
    </div>
</x-app-layout>


