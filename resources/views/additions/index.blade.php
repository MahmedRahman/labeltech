<x-app-layout>
    @php
        $title = 'قائمة الاضافات';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة الاضافات</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع أنواع الاضافات المتاحة</p>
        </div>
        <a href="{{ route('additions.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة اضافة جديدة
        </a>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($additions->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>اسم الاضافة</th>
                            <th>السعر</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($additions as $addition)
                            <tr>
                                <td style="font-weight: 500; color: #111827;">{{ $addition->name }}</td>
                                <td style="color: #111827; font-weight: 500;">{{ number_format($addition->price, 2) }} ج.م</td>
                                <td style="color: #6b7280;">{{ $addition->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('additions.show', $addition) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('additions.edit', $addition) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('additions.destroy', $addition) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذه الاضافة؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $additions->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد اضافات</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة اضافة جديدة</p>
                    <a href="{{ route('additions.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة اضافة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


