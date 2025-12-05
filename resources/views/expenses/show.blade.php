<x-app-layout>
    @php
        $title = 'تفاصيل المصروف';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل المصروف</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">مصروف بتاريخ: {{ $expense->date->format('Y-m-d') }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('expenses.edit', $expense) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('expenses.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نوع المصروف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">
                    {{ $expense->expenseType->name }}
                    @if($expense->expenseType->parent)
                        <span style="color: #6b7280; font-size: 0.75rem;">({{ $expense->expenseType->parent->name }})</span>
                    @endif
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">المبلغ</dt>
                <dd style="font-size: 1.5rem; font-weight: 700; color: #dc2626; margin: 0;">{{ number_format($expense->amount, 2) }} جنيه</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">التاريخ</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expense->date->format('Y-m-d') }}</dd>
            </div>

            @if($expense->supplier)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">المورد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('suppliers.show', $expense->supplier) }}" style="color: #2563eb; text-decoration: none;">
                        {{ $expense->supplier->name }}
                    </a>
                </dd>
            </div>
            @endif

            @if($expense->paymentMethod)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">طريقة السداد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expense->paymentMethod->name }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإنشاء</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expense->created_at->format('Y-m-d H:i') }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">آخر تحديث</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $expense->updated_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>

        @if($expense->description)
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوصف</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $expense->description }}</dd>
        </div>
        @endif

        @if($expense->notes)
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
            <dd style="font-size: 0.875rem; color: #111827; margin: 0; white-space: pre-wrap;">{{ $expense->notes }}</dd>
        </div>
        @endif
    </div>
</x-app-layout>









