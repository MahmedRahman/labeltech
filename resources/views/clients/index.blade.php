<x-app-layout>
    @php
        $title = 'قائمة العملاء';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">قائمة العملاء</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">
                @if($employee && $employee->account_type === 'مبيعات' && !$isAdmin)
                    @if($employeeTeams && $employeeTeams->count() > 0)
                        عرض عملاء فريق{{ $employeeTeams->count() > 1 ? 'ك' : '' }}: {{ $employeeTeams->pluck('name')->join('، ') }}
                    @else
                        لا يوجد لديك فرق مبيعات مخصصة
                    @endif
                @else
                    إدارة جميع عملائك من مكان واحد
                @endif
            </p>
        </div>
        <a href="{{ route('clients.create') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            إضافة عميل جديد
        </a>
    </div>

    <!-- Search Filter + عرض العملاء المندوبين -->
    @if(!isset($employee) || !$employee || $employee->account_type !== 'مبيعات' || (isset($isAdmin) && $isAdmin))
        <div style="background: white; border-radius: 0.75rem; border: 1px solid #e5e7eb; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);">
            <form method="GET" action="{{ route('clients.index') }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: end;">
                <div style="flex: 1; min-width: 200px;">
                    <label for="search_name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 0.5rem;">البحث بالاسم</label>
                    <input type="text" 
                           name="search_name" 
                           id="search_name" 
                           value="{{ request('search_name') }}"
                           placeholder="ابحث عن عميل بالاسم..."
                           style="width: 100%; padding: 0.625rem 0.875rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; color: #111827; background-color: #fff;">
                </div>
                @if(request('representatives_only'))
                    <input type="hidden" name="representatives_only" value="1">
                @endif
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    @if(request('representatives_only'))
                        <a href="{{ route('clients.index', request()->only('search_name')) }}" style="padding: 0.625rem 1.25rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center;">
                            عرض الكل
                        </a>
                    @else
                        <a href="{{ route('clients.index', array_merge(request()->only('search_name'), ['representatives_only' => 1])) }}" style="padding: 0.625rem 1.25rem; background-color: #f3f4f6; color: #374151; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center;">
                            العملاء اللي شغالين كمندوب
                        </a>
                    @endif
                    <button type="submit" style="padding: 0.625rem 1.5rem; background-color: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;">
                        بحث
                    </button>
                    @if(request()->has('search_name') || request('representatives_only'))
                        <a href="{{ route('clients.index') }}" style="padding: 0.625rem 1.5rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center;">
                            إلغاء الفلتر
                        </a>
                    @endif
                </div>
            </form>
        </div>
    @endif

    @if(isset($employee) && $employee && $employee->account_type === 'مبيعات' && (!isset($isAdmin) || !$isAdmin) && (!$employeeTeams || $employeeTeams->count() == 0))
        <div style="padding: 1.5rem; background-color: #fef3c7; color: #92400e; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid #f59e0b;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <svg style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <strong>تنبيه:</strong> لا يوجد لديك فرق مبيعات مخصصة. يرجى الاتصال بالإدارة لإضافتك إلى فريق مبيعات لعرض العملاء.
                </div>
            </div>
        </div>
    @endif

    <div class="table-container">
        <div class="table-content">
            @if($clients->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>الشركة</th>
                            @if(!isset($employee) || !$employee || $employee->account_type !== 'مبيعات' || (isset($isAdmin) && $isAdmin))
                            <th>شغال كمندوب</th>
                                <th>الإجراءات</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td style="font-weight: 500; color: #111827;">{{ $client->name }}</td>
                                <td style="color: #6b7280;">{{ $client->email ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $client->phone ?? '-' }}</td>
                                <td style="color: #6b7280;">{{ $client->company ?? '-' }}</td>
                                @if(!isset($employee) || !$employee || $employee->account_type !== 'مبيعات' || (isset($isAdmin) && $isAdmin))
                                <td style="color: #6b7280;">{{ $client->is_representative ? 'نعم' : 'لا' }}</td>
                                @endif
                                @if(!isset($employee) || !$employee || $employee->account_type !== 'مبيعات' || (isset($isAdmin) && $isAdmin))
                                    <td>
                                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                                            <a href="{{ route('clients.show', $client) }}" style="color: #2563eb; text-decoration: none; font-size: 0.875rem;">عرض</a>
                                            <a href="{{ route('clients.edit', $client) }}" style="color: #10b981; text-decoration: none; font-size: 0.875rem;">تعديل</a>
                                            <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #dc2626; text-decoration: none; font-size: 0.875rem; border: none; background: none; cursor: pointer;" onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="margin-top: 1.5rem;">
                    {{ $clients->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 3rem 0;">
                    <svg style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 style="font-size: 0.875rem; font-weight: 500; color: #111827; margin-bottom: 0.5rem;">لا يوجد عملاء</h3>
                    <p style="font-size: 1rem; color: #6b7280; margin-bottom: 1.5rem;">ابدأ بإضافة عميل جديد</p>
                    <a href="{{ route('clients.create') }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #2563eb; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة عميل جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
