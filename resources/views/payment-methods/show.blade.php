<x-app-layout>
    @php
        $title = 'تفاصيل طريقة السداد';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل طريقة السداد</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $paymentMethod->name }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('payment-methods.edit', $paymentMethod) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('payment-methods.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الاسم</dt>
                <dd style="font-size: 0.9375rem; font-weight: 600; color: #111827; margin: 0;">{{ $paymentMethod->name }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الحالة</dt>
                <dd style="margin: 0;">
                    @if($paymentMethod->is_active)
                        <span style="display: inline-flex; align-items: center; padding: 0.375rem 0.875rem; background-color: #d1fae5; color: #065f46; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                            <svg style="width: 14px; height: 14px; margin-left: 0.5rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            نشط
                        </span>
                    @else
                        <span style="display: inline-flex; align-items: center; padding: 0.375rem 0.875rem; background-color: #fee2e2; color: #991b1b; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">
                            <svg style="width: 14px; height: 14px; margin-left: 0.5rem;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            غير نشط
                        </span>
                    @endif
                </dd>
            </div>

            @if($paymentMethod->description)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوصف</dt>
                <dd style="font-size: 0.9375rem; color: #111827; margin: 0; line-height: 1.6;">{{ $paymentMethod->description }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإضافة</dt>
                <dd style="font-size: 0.9375rem; color: #111827; margin: 0;">{{ $paymentMethod->created_at->format('Y-m-d H:i') }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">آخر تحديث</dt>
                <dd style="font-size: 0.9375rem; color: #111827; margin: 0;">{{ $paymentMethod->updated_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>
    </div>
</x-app-layout>

