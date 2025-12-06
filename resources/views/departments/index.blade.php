<x-app-layout>
    @php
        $title = 'أقسام الشركة';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">أقسام الشركة</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة أقسام الشركة والمناصب</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('departments.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة قسم جديد
            </a>
            <a href="{{ route('positions.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة منصب جديد
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($departments->count() > 0)
                @foreach($departments as $department)
                    <div style="margin-bottom: 2rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                        <!-- Department Header -->
                        <div style="background-color: #f3f4f6; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 20px; height: 20px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $department->name }}</h3>
                                    @if($department->description)
                                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0.25rem 0 0 0;">{{ $department->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('departments.edit', $department) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا القسم وجميع مناصبه؟')">حذف</button>
                                </form>
                            </div>
                        </div>

                        <!-- Positions -->
                        @if($department->positions->count() > 0)
                            <div style="padding: 1rem 1.5rem; background-color: white;">
                                <div style="display: grid; gap: 0.75rem;">
                                    @foreach($department->positions as $position)
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background-color: #f9fafb; border-radius: 0.375rem; border-right: 3px solid #10b981;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <svg style="width: 16px; height: 16px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                                <div>
                                                    <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">{{ $position->name }}</span>
                                                    @if($position->description)
                                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0.25rem 0 0 0;">{{ $position->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="display: flex; gap: 0.75rem;">
                                                <a href="{{ route('positions.edit', $position) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                                <form action="{{ route('positions.destroy', $position) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا المنصب؟')">حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div style="padding: 1rem 1.5rem; background-color: white; text-align: center;">
                                <p style="font-size: 0.875rem; color: #9ca3af; margin: 0;">لا توجد مناصب في هذا القسم</p>
                            </div>
                        @endif

                        <!-- Add Position Button -->
                        <div style="padding: 0.75rem 1.5rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb;">
                            <a href="{{ route('positions.create', ['department_id' => $department->id]) }}" style="display: inline-flex; align-items: center; color: #10b981; text-decoration: none; font-size: 0.875rem;">
                                <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                إضافة منصب لهذا القسم
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا يوجد أقسام</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة قسم جديد</p>
                    <a href="{{ route('departments.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة قسم جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>




