<x-app-layout>
    @php
        $title = 'بيانات العميل';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">بيانات العميل</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $client->name }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            @if(!isset($employee) || !$employee || $employee->account_type !== 'مبيعات' || (isset($isAdmin) && $isAdmin))
                <a href="{{ route('clients.edit', $client) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                    تعديل
                </a>
            @endif
            <a href="{{ route('clients.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الاسم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->name }}</dd>
            </div>

            @if($client->email)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">البريد الإلكتروني</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->email }}</dd>
            </div>
            @endif

            @if($client->phone)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الهاتف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->phone }}</dd>
            </div>
            @endif

            @if($client->company)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشركة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->company }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رصيد أول المدة</dt>
                <dd style="font-size: 1rem; font-weight: 600; color: {{ ($client->opening_balance ?? 0) >= 0 ? '#059669' : '#dc2626' }}; margin: 0;">
                    {{ number_format($client->opening_balance ?? 0, 2) }} جنيه
                </dd>
            </div>

            @if($client->address)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العنوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->address }}</dd>
            </div>
            @endif

            @if($client->notes)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->notes }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإضافة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $client->created_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>
    </div>
</x-app-layout>
