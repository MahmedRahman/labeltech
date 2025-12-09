<x-app-layout>
    @php
        $title = 'طرق السداد';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">طرق السداد</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">إدارة طرق السداد المتاحة في النظام</p>
        </div>
        <a href="{{ route('payment-methods.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة طريقة سداد جديدة
        </a>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($paymentMethods->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>الحالة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentMethods as $paymentMethod)
                            <tr>
                                <td style="font-weight: 600; color: #111827;">{{ $paymentMethod->name }}</td>
                                <td style="color: #6b7280;">{{ $paymentMethod->description ?? '-' }}</td>
                                <td>
                                    @if($paymentMethod->is_active)
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; background-color: #d1fae5; color: #065f46; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                                            <svg style="width: 12px; height: 12px; margin-left: 0.375rem;" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            نشط
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; background-color: #fee2e2; color: #991b1b; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                                            <svg style="width: 12px; height: 12px; margin-left: 0.375rem;" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            غير نشط
                                        </span>
                                    @endif
                                </td>
                                <td style="color: #6b7280;">{{ $paymentMethod->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('payment-methods.show', $paymentMethod) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('payment-methods.edit', $paymentMethod) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('payment-methods.destroy', $paymentMethod) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف طريقة السداد هذه؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $paymentMethods->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد طرق سداد</h3>
                    <p style="font-size: 1rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة طريقة سداد جديدة</p>
                    <a href="{{ route('payment-methods.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة طريقة سداد جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

