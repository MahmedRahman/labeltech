<x-app-layout>
    @php
        $title = 'قائمة الخامات';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة الخامات</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع أنواع الخامات المتاحة</p>
        </div>
        <a href="{{ route('materials.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة خامة جديدة
        </a>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($materials->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>اسم الخامة</th>
                            <th>الوصف</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materials as $material)
                            <tr>
                                <td style="font-weight: 500; color: #111827;">{{ $material->name }}</td>
                                <td style="color: #6b7280;">{{ $material->description ? Str::limit($material->description, 50) : '-' }}</td>
                                <td style="color: #111827; font-weight: 500;">{{ $material->price ? number_format($material->price, 2) . ' ج.م' : '-' }}</td>
                                <td>
                                    <span style="display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: {{ $material->is_active ? '#d1fae5' : '#fee2e2' }}; color: {{ $material->is_active ? '#065f46' : '#991b1b' }};">
                                        {{ $material->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td style="color: #6b7280;">{{ $material->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('materials.show', $material) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('materials.edit', $material) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذه الخامة؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $materials->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد خامات</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة خامة جديدة</p>
                    <a href="{{ route('materials.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة خامة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>









