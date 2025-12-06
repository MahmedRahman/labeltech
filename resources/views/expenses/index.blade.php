<x-app-layout>
    @php
        $title = 'قائمة المصروفات';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة المصروفات</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع مصروفات المطبعة</p>
        </div>
        <a href="{{ route('expenses.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة مصروف جديد
        </a>
    </div>

    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">إجمالي المصروفات</div>
            <div style="font-size: 2rem; font-weight: 700; color: #dc2626;">{{ number_format($totalAmount, 2) }} جنيه</div>
        </div>
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">مصروفات هذا الشهر</div>
            <div style="font-size: 2rem; font-weight: 700; color: #f59e0b;">{{ number_format($thisMonthAmount, 2) }} جنيه</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($expenses->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>نوع المصروف</th>
                            <th>المورد</th>
                            <th>المبلغ</th>
                            <th>طريقة السداد</th>
                            <th>الوصف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr>
                                <td style="color: #6b7280;">{{ $expense->date->format('Y-m-d') }}</td>
                                <td style="font-weight: 500; color: #111827;">
                                    {{ $expense->expenseType->name }}
                                    @if($expense->expenseType->parent)
                                        <span style="color: #6b7280; font-size: 0.75rem;">({{ $expense->expenseType->parent->name }})</span>
                                    @endif
                                </td>
                                <td style="color: #6b7280;">{{ $expense->supplier->name ?? '-' }}</td>
                                <td style="font-weight: 600; color: #dc2626;">{{ number_format($expense->amount, 2) }} جنيه</td>
                                <td style="color: #6b7280;">{{ $expense->paymentMethod->name ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $expense->description ? Str::limit($expense->description, 30) : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('expenses.show', $expense) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('expenses.edit', $expense) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا المصروف؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $expenses->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد مصروفات</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة مصروف جديد</p>
                    <a href="{{ route('expenses.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة مصروف جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>










