<x-app-layout>
    @php
        $title = 'أنواع المصروفات';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">أنواع المصروفات</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">إدارة أنواع المصروفات الرئيسية والفرعية</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('expense-types.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة نوع جديد
            </a>
        </div>
    </div>

    <div class="table-container">
        <div class="table-content">
            @if($parentTypes->count() > 0)
                @foreach($parentTypes as $parent)
                    <div style="margin-bottom: 2rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                        <!-- Parent Type -->
                        <div style="background-color: #f3f4f6; padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <svg style="width: 20px; height: 20px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">{{ $parent->name }}</h3>
                                    @if($parent->description)
                                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0.25rem 0 0 0;">{{ $parent->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('expense-types.edit', $parent) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                <form action="{{ route('expense-types.destroy', $parent) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا النوع وجميع أنواعه الفرعية؟')">حذف</button>
                                </form>
                            </div>
                        </div>

                        <!-- Children Types -->
                        @if($parent->children->count() > 0)
                            <div style="padding: 1rem 1.5rem; background-color: white;">
                                <div style="display: grid; gap: 0.75rem;">
                                    @foreach($parent->children as $child)
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background-color: #f9fafb; border-radius: 0.375rem; border-right: 3px solid #2563eb;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <svg style="width: 16px; height: 16px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                                <div>
                                                    <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">{{ $child->name }}</span>
                                                    @if($child->description)
                                                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0.25rem 0 0 0;">{{ $child->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="display: flex; gap: 0.75rem;">
                                                <a href="{{ route('expense-types.edit', $child) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                                <form action="{{ route('expense-types.destroy', $child) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا النوع؟')">حذف</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div style="padding: 1rem 1.5rem; background-color: white; text-align: center;">
                                <p style="font-size: 0.875rem; color: #9ca3af; margin: 0;">لا توجد أنواع فرعية</p>
                            </div>
                        @endif

                        <!-- Add Child Button -->
                        <div style="padding: 0.75rem 1.5rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb;">
                            <a href="{{ route('expense-types.create', ['parent_id' => $parent->id]) }}" style="display: inline-flex; align-items: center; color: #2563eb; text-decoration: none; font-size: 0.875rem;">
                                <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                إضافة نوع فرعي
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا يوجد أنواع مصروفات</h3>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة نوع مصروف جديد</p>
                    <a href="{{ route('expense-types.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة نوع جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

