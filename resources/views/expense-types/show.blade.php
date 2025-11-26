<x-app-layout>
    @php
        $title = 'تفاصيل نوع المصروف';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل نوع المصروف</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $expenseType->name }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('expense-types.edit', $expenseType) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('expense-types.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الاسم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expenseType->name }}</dd>
            </div>

            @if($expenseType->parent)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">النوع الرئيسي</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('expense-types.show', $expenseType->parent) }}" style="color: #2563eb; text-decoration: none;">{{ $expenseType->parent->name }}</a>
                </dd>
            </div>
            @endif

            @if($expenseType->description)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوصف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expenseType->description }}</dd>
            </div>
            @endif

            @if($expenseType->children->count() > 0)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الأنواع الفرعية</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.5rem;">
                        @foreach($expenseType->children as $child)
                            <a href="{{ route('expense-types.show', $child) }}" style="display: inline-block; padding: 0.25rem 0.75rem; background-color: #eff6ff; color: #2563eb; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                </dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإضافة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expenseType->created_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>
    </div>
</x-app-layout>

