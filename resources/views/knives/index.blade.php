<x-app-layout>
    @php
        $title = 'قائمة السكاكين';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">قائمة السكاكين</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة جميع السكاكين في المطبعة</p>
        </div>
        <a href="{{ route('knives.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة سكينة جديدة
        </a>
    </div>

    <!-- Statistics Card -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <div style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">إجمالي السكاكين</div>
            <div style="font-size: 2rem; font-weight: 700; color: #111827;">{{ $totalKnives }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
        <form method="GET" action="{{ route('knives.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <!-- Filter by Type -->
            <div>
                <label for="filter_type" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">النوع</label>
                <select name="filter_type" 
                        id="filter_type" 
                        style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                    <option value="">جميع الأنواع</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('filter_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by Width -->
            <div>
                <label for="filter_width" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">العرض</label>
                <select name="filter_width" 
                        id="filter_width" 
                        style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                    <option value="">جميع الأعراض</option>
                    @foreach($widths as $width)
                        <option value="{{ $width }}" {{ request('filter_width') == $width ? 'selected' : '' }}>{{ number_format($width, 2) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by Length -->
            <div>
                <label for="filter_length" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">الطول</label>
                <select name="filter_length" 
                        id="filter_length" 
                        style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                    <option value="">جميع الأطوال</option>
                    @foreach($lengths as $length)
                        <option value="{{ $length }}" {{ request('filter_length') == $length ? 'selected' : '' }}>{{ number_format($length, 2) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Actions -->
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" style="flex: 1; padding: 0.625rem 1rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.15s;">
                    تطبيق الفلترة
                </button>
                @if(request()->hasAny(['filter_type', 'filter_width', 'filter_length']))
                    <a href="{{ route('knives.index') }}" style="flex: 1; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-align: center; display: flex; align-items: center; justify-content: center;">
                        إلغاء الفلترة
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($knives->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>الرقم الكود</th>
                            <th>النوع</th>
                            <th>تُرس</th>
                            <th>دراغيل</th>
                            <th>عدد الصفوف</th>
                            <th>عدد العيون</th>
                            <th>الجيب</th>
                            <th>الطول</th>
                            <th>العرض</th>
                            <th>الملاحظات</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($knives as $knife)
                            <tr>
                                <td style="font-weight: 600; color: #2563eb;">{{ $knife->knife_code }}</td>
                                <td style="color: #6b7280;">{{ $knife->type ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->gear ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->dragile_drive ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->rows_count ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->eyes_count ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->flap_size ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->length ? number_format($knife->length, 2) : '-' }}</td>
                                <td style="color: #6b7280;">{{ $knife->width ? number_format($knife->width, 2) : '-' }}</td>
                                <td style="color: #6b7280; max-width: 200px;">{{ $knife->notes ? Str::limit($knife->notes, 50) : '-' }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.75rem;">
                                        <a href="{{ route('knives.show', $knife) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                        <a href="{{ route('knives.edit', $knife) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                        <form action="{{ route('knives.destroy', $knife) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذه السكينة؟')">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $knives->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا توجد سكاكين</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة سكينة جديدة</p>
                    <a href="{{ route('knives.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة سكينة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

