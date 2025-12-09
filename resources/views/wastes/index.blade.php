<x-app-layout>
    @php
        $title = 'قائمة الطباعة';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">قائمة الطباعة</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">إدارة بيانات الطباعة حسب عدد الألوان</p>
        </div>
        <a href="{{ route('wastes.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة بيانات طباعة جديدة
        </a>
    </div>

    <!-- Statistics Card -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">إجمالي السجلات</div>
            <div style="font-size: 2rem; font-weight: 700; color: #111827;">{{ $totalWastes }}</div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($wastes->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>عدد الألوان</th>
                            <th>نسبة الطباعة (%)</th>
                            <th>السعر</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wastes as $waste)
                            <tr>
                                <td style="font-weight: 600; color: #2563eb; font-size: 1.125rem;">{{ $waste->number_of_colors }}</td>
                                <td style="font-weight: 500; color: #111827;">{{ number_format($waste->waste_percentage, 2) }}%</td>
                                <td style="color: #111827; font-weight: 500;">{{ $waste->price ? number_format($waste->price, 2) . ' ج.م' : '-' }}</td>
                                <td style="color: #6b7280;">{{ $waste->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('wastes.show', $waste) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('wastes.edit', $waste) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('wastes.destroy', $waste) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذه البيانات؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $wastes->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد بيانات طباعة</h3>
                    <p style="font-size: 1rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة بيانات طباعة جديدة</p>
                    <a href="{{ route('wastes.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة بيانات طباعة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

