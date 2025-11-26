<x-app-layout>
    @php
        $title = 'بيانات المورد';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0 0 0.25rem 0;">بيانات المورد</h2>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">{{ $supplier->name }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('suppliers.edit', $supplier) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('suppliers.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الاسم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->name }}</dd>
            </div>

            @if($supplier->email)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">البريد الإلكتروني</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->email }}</dd>
            </div>
            @endif

            @if($supplier->phone)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الهاتف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->phone }}</dd>
            </div>
            @endif

            @if($supplier->company)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشركة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->company }}</dd>
            </div>
            @endif

            @if($supplier->contact_person)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشخص المسؤول</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->contact_person }}</dd>
            </div>
            @endif

            @if($supplier->address)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العنوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->address }}</dd>
            </div>
            @endif

            @if($supplier->products)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">المنتجات/الخدمات</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->products }}</dd>
            </div>
            @endif

            @if($supplier->notes)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملاحظات</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->notes }}</dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإضافة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $supplier->created_at->format('Y-m-d H:i') }}</dd>
            </div>
        </div>
    </div>
</x-app-layout>

