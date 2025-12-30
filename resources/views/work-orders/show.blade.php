<x-app-layout>
    @php
        $title = 'تفاصيل أمر الشغل';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل أمر الشغل</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('work-orders.print-price-quote', $workOrder) }}" target="_blank" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                طباعة عرض السعر
            </a>
            @if(($workOrder->sent_to_client ?? 'no') == 'no')
            <form action="{{ route('work-orders.mark-as-sent', $workOrder) }}" method="POST" style="display: inline;" id="mark-as-sent-form">
                @csrf
                <button type="submit" onclick="event.preventDefault(); handleMarkAsSent(event);" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #f59e0b; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                    <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    تم الإرسال للعميل
                </button>
            </form>
            @else
            <span style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #d1fae5; color: #065f46; border-radius: 0.375rem; font-weight: 500;">
                <svg style="width: 18px; height: 18px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                تم الإرسال للعميل
            </span>
            @endif
            <a href="{{ route('work-orders.edit', $workOrder) }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #10b981; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                تعديل
            </a>
            <a href="{{ route('work-orders.index') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Client Response Section -->
    @if(($workOrder->sent_to_client ?? 'no') == 'yes' && empty($workOrder->client_response))
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #f59e0b;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #92400e; margin: 0;">رد العميل على عرض السعر</h3>
            </div>
            <p style="font-size: 0.875rem; color: #78350f; margin-bottom: 1.5rem;">تم إرسال عرض السعر للعميل. يرجى تحديد رد العميل:</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="display: flex; flex-direction: column;">
                    <form action="{{ route('work-orders.client-response.update', $workOrder) }}" method="POST" id="client-response-approved-form">
                        @csrf
                        <input type="hidden" name="client_response" value="موافق">
                        <button type="submit" onclick="event.preventDefault(); handleClientResponse(event, 'موافق', 'هل أنت متأكد أن العميل وافق على عرض السعر؟');" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.25rem; background-color: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                            <svg style="width: 32px; height: 32px; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span style="font-size: 1rem;">العميل موافق</span>
                            <span style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.25rem;">تم الموافقة على العرض</span>
                        </button>
                    </form>
                    <div style="margin-top: 0.75rem; padding: 0.75rem; background-color: #ecfdf5; border-radius: 0.5rem; border: 1px solid #10b981;">
                        <p style="font-size: 0.75rem; color: #065f46; margin: 0; line-height: 1.5;">
                            <strong>ملاحظة:</strong> عند الضغط على موافق سيتم قبول عرض السعر وسيتم إرساله إلى المصمم لطلب البروفا.
                        </p>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <form action="{{ route('work-orders.client-response.update', $workOrder) }}" method="POST" id="client-response-rejected-form">
                        @csrf
                        <input type="hidden" name="client_response" value="رفض">
                        <button type="submit" onclick="event.preventDefault(); handleClientResponse(event, 'رفض', 'هل أنت متأكد أن العميل رفض عرض السعر؟');" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.25rem; background-color: #dc2626; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);">
                            <svg style="width: 32px; height: 32px; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span style="font-size: 1rem;">العميل رفض</span>
                            <span style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.25rem;">تم رفض العرض</span>
                        </button>
                    </form>
                    <div style="margin-top: 0.75rem; padding: 0.75rem; background-color: #fef2f2; border-radius: 0.5rem; border: 1px solid #dc2626;">
                        <p style="font-size: 0.75rem; color: #991b1b; margin: 0; line-height: 1.5;">
                            <strong>ملاحظة:</strong> سيتم إرسال عرض السعر إلى الأرشيف. يمكنك استرجاعه إذا غير العميل رأيه أو رد.
                        </p>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <form action="{{ route('work-orders.client-response.update', $workOrder) }}" method="POST" id="client-response-no-response-form">
                        @csrf
                        <input type="hidden" name="client_response" value="لم يرد">
                        <button type="submit" onclick="event.preventDefault(); handleClientResponse(event, 'لم يرد', 'هل تريد تحديد أن العميل لم يرد على عرض السعر؟');" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3);">
                            <svg style="width: 32px; height: 32px; margin-bottom: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span style="font-size: 1rem;">العميل لم يرد</span>
                            <span style="font-size: 0.75rem; opacity: 0.9; margin-top: 0.25rem;">لم يتم الرد بعد</span>
                        </button>
                    </form>
                    <div style="margin-top: 0.75rem; padding: 0.75rem; background-color: #f3f4f6; border-radius: 0.5rem; border: 1px solid #6b7280;">
                        <p style="font-size: 0.75rem; color: #374151; margin: 0; line-height: 1.5;">
                            <strong>ملاحظة:</strong> سيتم إرسال عرض السعر إلى الأرشيف. يمكنك استرجاعه إذا غير العميل رأيه أو رد.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Convert to Work Order Section -->
    @if(($workOrder->client_response ?? '') === 'موافق' && ($workOrder->status ?? '') !== 'work_order')
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border: 2px solid #2563eb;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #1e40af; margin: 0;">العميل موافق على عرض السعر</h3>
            </div>
            <p style="font-size: 0.875rem; color: #1e3a8a; margin-bottom: 1.5rem;">تم موافقة العميل على عرض السعر. يمكنك الآن طلب بروفا من المصمم أو تحويله إلى أمر شغل للبدء في التنفيذ.</p>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <form action="{{ route('work-orders.request-proof-from-designer', $workOrder) }}" method="POST" id="request-proof-form">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); handleRequestProof(event);" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #8b5cf6; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(139, 92, 246, 0.3);">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        طلب بروفا من المصمم
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Send to Designer Section -->
    @if(($workOrder->status ?? '') === 'work_order')
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%); border: 2px solid #8b5cf6;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #6b21a8; margin: 0;">إرسال إلى المصمم</h3>
            </div>
            @if(($workOrder->sent_to_designer ?? 'no') == 'no')
                <p style="font-size: 0.875rem; color: #7c3aed; margin-bottom: 1.5rem;">تم تحويل عرض السعر إلى أمر شغل. يمكنك الآن إرساله إلى المصمم للبدء في التصميم.</p>
                <form action="{{ route('work-orders.mark-as-sent-to-designer', $workOrder) }}" method="POST" id="mark-as-sent-to-designer-form">
                    @csrf
                    <button type="submit" onclick="event.preventDefault(); handleMarkAsSentToDesigner(event);" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #8b5cf6; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(139, 92, 246, 0.3);">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        إرسال إلى المصمم
                    </button>
                </form>
            @else
                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; background-color: #faf5ff; border-radius: 0.5rem; border: 1px solid #c084fc;">
                    <svg style="width: 24px; height: 24px; color: #8b5cf6; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #6b21a8; margin: 0;">تم إرسال أمر الشغل إلى المصمم</p>
                        <p style="font-size: 0.75rem; color: #7c3aed; margin: 0.25rem 0 0 0;">يمكن للمصمم الآن البدء في العمل على التصميم</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Archive Section -->
    @if(in_array($workOrder->client_response ?? '', ['رفض', 'لم يرد']))
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border: 2px solid #6b7280;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #374151; margin: 0;">
                    @if(($workOrder->client_response ?? '') === 'رفض')
                        العميل رفض عرض السعر
                    @else
                        العميل لم يرد على عرض السعر
                    @endif
                </h3>
            </div>
            <p style="font-size: 0.875rem; color: #4b5563; margin-bottom: 1.5rem;">
                @if(($workOrder->client_response ?? '') === 'رفض')
                    تم رفض عرض السعر من قبل العميل. يمكنك أرشفته لإزالة العرض من القائمة النشطة.
                @else
                    لم يرد العميل على عرض السعر. يمكنك أرشفته لإزالة العرض من القائمة النشطة.
                @endif
            </p>
            <form action="{{ route('work-orders.archive-quote', $workOrder) }}" method="POST" id="archive-quote-form">
                @csrf
                <button type="submit" onclick="event.preventDefault(); handleArchiveQuote(event);" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #6b7280; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3);">
                    <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                    أرشفة عرض السعر
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- معلومات أساسية -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات أساسية</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem 2rem;">
            <!-- Row 1 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">اسم الشغلانة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->job_name ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">أمر الشغل:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 600;">{{ $workOrder->order_number ?? 'بدون رقم' }}</span>
            </div>
            
            <!-- Row 2 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">التاريخ:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->created_at->format('d/m/Y') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">أسم العميل:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">
                    <a href="{{ route('clients.show', $workOrder->client) }}" style="color: #2563eb; text-decoration: none;">
                        {{ $workOrder->client->name }}
                    </a>
                </span>
            </div>
            
            <!-- Row 3 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">العرض:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->width ? number_format($workOrder->width, 1) : '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الطول:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->length ? number_format($workOrder->length, 1) : '-' }}</span>
            </div>
            
            <!-- Row 4 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">نوع الخامة:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->material ?? '-' }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الاضافات:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->additions ?? 'لا يوجد' }}</span>
            </div>
            
            <!-- Row 5 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">الكمية:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ number_format($workOrder->quantity) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #e5e7eb;">
                <span style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">عدد الألوان:</span>
                <span style="font-size: 0.875rem; color: #111827; font-weight: 500;">{{ $workOrder->number_of_colors ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- معلومات المنتج -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات المنتج</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الخامة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 500;">{{ $workOrder->material }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الكمية</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->quantity) }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الألوان</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->number_of_colors }}</dd>
            </div>

            @if($workOrder->rows_count)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->rows_count }}</dd>
            </div>
            @endif

            @if($workOrder->width)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العرض</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->width, 2) }} سم</dd>
            </div>
            @endif

            @if($workOrder->length)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الطول</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->length, 2) }} سم</dd>
            </div>
            @endif

            @if($workOrder->width && $workOrder->length)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الأبعاد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    {{ number_format($workOrder->width, 2) }} × {{ number_format($workOrder->length, 2) }} سم
                </dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">البصمة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->fingerprint ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">✓ موجود</span>
                        @if($workOrder->fingerprint_price)
                            <span style="color: #111827; margin-right: 0.5rem;">- {{ number_format($workOrder->fingerprint_price, 2) }} ج.م</span>
                        @endif
                    @else
                        <span style="color: #6b7280;">✗ لا يوجد</span>
                    @endif
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اتجاه اللف</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @php
                        $windingDirection = $workOrder->winding_direction ?? 'no';
                        if ($windingDirection == 'clockwise') {
                            $windingLabel = 'في اتجاه عقارب الساعة';
                            $windingColor = '#10b981';
                        } elseif ($windingDirection == 'counterclockwise') {
                            $windingLabel = 'عكس عقارب الساعة';
                            $windingColor = '#f59e0b';
                        } elseif ($windingDirection == 'yes') {
                            $windingLabel = 'يوجد';
                            $windingColor = '#2563eb';
                        } else {
                            $windingLabel = 'لا يوجد';
                            $windingColor = '#6b7280';
                        }
                    @endphp
                    <span style="color: {{ $windingColor }}; font-weight: 500;">{{ $windingLabel }}</span>
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">السكينة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->knife_exists ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">✓ موجود</span>
                        @if($workOrder->knife_price)
                            <span style="color: #111827; margin-right: 0.5rem;">- {{ number_format($workOrder->knife_price, 2) }} ج.م</span>
                        @endif
                    @else
                        <span style="color: #6b7280;">✗ لا يوجد</span>
                    @endif
                </dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">التكسير الخارجي</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    @if(($workOrder->external_breaking ?? 'no') == 'yes')
                        <span style="color: #10b981; font-weight: 600;">✓ موجود</span>
                        @if($workOrder->external_breaking_price)
                            <span style="color: #111827; margin-right: 0.5rem;">- {{ number_format($workOrder->external_breaking_price, 2) }} ج.م</span>
                        @endif
                    @else
                        <span style="color: #6b7280;">✗ لا يوجد</span>
                    @endif
                </dd>
            </div>

            @if($workOrder->additions && $workOrder->additions != 'لا يوجد')
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الإضافات المطلوبة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->additions }}</dd>
            </div>
            @endif

            @if($workOrder->addition_price)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر الإضافة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->addition_price, 2) }} ج.م</dd>
            </div>
            @endif

            @if($workOrder->final_product_shape)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">شكل المنتج النهائي</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 500;">{{ $workOrder->final_product_shape }}</dd>
            </div>
            @endif
        </div>
    </div>

    <!-- التجهيزات -->
    @if($workOrder->film_price || $workOrder->film_count || $workOrder->sales_percentage || $workOrder->material_price_per_meter || $workOrder->manufacturing_price_per_meter || $workOrder->waste_per_roll)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">التجهيزات</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->film_price)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر الفيلم الواحد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->film_price, 2) }} ج.م</dd>
            </div>
            @endif

            @if($workOrder->film_count)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العدد</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->film_count) }}</dd>
            </div>
            @endif

            @if($workOrder->sales_percentage)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نسبة المبيعات</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->sales_percentage, 2) }}%</dd>
            </div>
            @endif

            @if($workOrder->material_price_per_meter)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر المتر الخامة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->material_price_per_meter, 2) }} ج.م</dd>
            </div>
            @endif

            @if($workOrder->manufacturing_price_per_meter)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سعر متر التصنيع</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->manufacturing_price_per_meter, 2) }} ج.م</dd>
            </div>
            @endif

            @if($calculations['waste_percentage'] ?? $workOrder->waste_percentage)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نسبة الهالك</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($calculations['waste_percentage'] ?? $workOrder->waste_percentage ?? 0, 2) }}%</dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- بيانات التشغيل -->
    @if($workOrder->has_production || $workOrder->paper_width || $workOrder->paper_weight || $workOrder->waste_percentage || $workOrder->number_of_rolls || $workOrder->core_size || $workOrder->pieces_per_sheet || $workOrder->sheets_per_stack || $workOrder->pieces_per_stack)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #6366f1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">بيانات التشغيل</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->paper_width)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عرض الورق</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->paper_width, 2) }} سم</dd>
            </div>
            @endif

            @if($workOrder->paper_weight)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الوزن</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->paper_weight, 2) }} جرام/م²</dd>
            </div>
            @endif

            @if($workOrder->waste_percentage)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">نسبة الهالك</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->waste_percentage, 2) }}%</dd>
            </div>
            @endif

            @if($workOrder->final_product_shape == 'بكر')
                @if($workOrder->number_of_rolls)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد التكت في البكره</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->number_of_rolls) }}</dd>
                </div>
                @endif

                @if($workOrder->core_size)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">مقاس الكور</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ number_format($workOrder->core_size, 0) }} مم</dd>
                </div>
                @endif
            @elseif($workOrder->final_product_shape == 'شيت')
                @if($workOrder->pieces_per_sheet)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد التكت في الشيت</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->pieces_per_sheet) }}</dd>
                </div>
                @endif

                @if($workOrder->sheets_per_stack)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الشيت في الراكوة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->sheets_per_stack) }}</dd>
                </div>
                @endif

                @if($workOrder->pieces_per_stack)
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد التكت في الراكوة</dt>
                    <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->pieces_per_stack) }}</dd>
                </div>
                @endif
            @endif
        </div>
    </div>
    @endif

    <!-- معلومات التصميم -->
    @if($workOrder->has_design ?? false)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #8b5cf6;">
            <svg style="width: 24px; height: 24px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات التصميم</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            @if($workOrder->design_shape)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشكل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_shape }}</dd>
            </div>
            @endif

            @if($workOrder->design_films)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">أفلام</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_films }}</dd>
            </div>
            @endif

            @if($workOrder->design_knives)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">سكاكين</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_knives }}</dd>
            </div>
            @endif

            @if($workOrder->designKnife)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">السكينة المختارة</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('knives.show', $workOrder->designKnife) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                        {{ $workOrder->designKnife->knife_code }} - {{ $workOrder->designKnife->type ?? 'بدون نوع' }}
                    </a>
                </dd>
            </div>
            @endif

            @if($workOrder->design_rows_count)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الصفوف في التصميم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->design_rows_count }}</dd>
            </div>
            @endif

            @if($workOrder->design_drills)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الدرافيل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_drills }}</dd>
            </div>
            @endif

            @if($workOrder->design_breaking_gear)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ترس التكسير</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_breaking_gear }}</dd>
            </div>
            @endif

            @if($workOrder->design_gab)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الجاب</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_gab }}</dd>
            </div>
            @endif

            @if($workOrder->design_cliches)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الكلاشيهات المعده</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->design_cliches }}</dd>
            </div>
            @endif

            @if($workOrder->design_file)
            <div style="grid-column: 1 / -1;">
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">ملف التصميم</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ asset('storage/designs/' . $workOrder->design_file) }}" target="_blank" style="color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background-color: #eff6ff; border-radius: 0.375rem; border: 1px solid #bfdbfe;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        عرض الملف
                    </a>
                </dd>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- الحسابات الديناميكية -->
    @if(isset($calculations))
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid rgba(255, 255, 255, 0.3);">
            <svg style="width: 24px; height: 24px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: white; margin: 0;">الحسابات</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">عرض الورق</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['paper_width'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">سم</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">المتر الطولي</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['linear_meter'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">م</span>
                </dd>
            </div>

            @if($calculations['waste'] ?? $workOrder->waste || $calculations['waste_percentage'] ?? $workOrder->waste_percentage)
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">الهالك + نسبة الهالك</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format(($calculations['waste'] ?? $workOrder->waste ?? 0) + ($calculations['waste_percentage'] ?? $workOrder->waste_percentage ?? 0), 2) }}
                </dd>
            </div>
            @endif

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">المتر الطولي + الهالك</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['linear_meter_with_waste'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">المتر المربع</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['square_meter'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">م²</span>
                </dd>
            </div>


            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_amount'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            @if($workOrder->sales_percentage && $workOrder->sales_percentage > 0)
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">نسبة المبيعات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['sales_percentage_amount'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
                <small style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.8); margin-top: 0.25rem; display: block;">
                    ({{ number_format($workOrder->sales_percentage, 2) }}% من إجمالي المبلغ)
                </small>
            </div>

            <div style="background: rgba(255, 255, 255, 0.15); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ + نسبة المبيعات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_amount_with_sales'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>
            @endif

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي التجهيزات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_preparations'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.2); padding: 1.25rem; border-radius: 0.5rem; backdrop-filter: blur(10px); border: 2px solid rgba(255, 255, 255, 0.3);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ شامل التجهيزات و نسبة المبيعات</dt>
                <dd style="font-size: 1.5rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_order'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">سعر الألف شامل التجهيزات و نسبة المبيعات</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['price_per_thousand'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>
        </div>
    </div>
    @endif

    <!-- الملاحظات -->
    @if($workOrder->notes)
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">ملاحظات</h3>
        </div>
        <div style="font-size: 0.875rem; color: #111827; line-height: 1.6; white-space: pre-wrap;">{{ $workOrder->notes }}</div>
    </div>
    @endif

    <script>
        // Handle Mark as Sent
        function handleMarkAsSent(event) {
            Swal.fire({
                title: 'تأكيد الإرسال',
                text: 'هل أنت متأكد من أنك أرسلت عرض السعر للعميل؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، تم الإرسال',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mark-as-sent-form').submit();
                }
            });
        }

        // Handle Client Response
        function handleClientResponse(event, response, message) {
            Swal.fire({
                title: 'تأكيد الرد',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: response === 'موافق' ? '#10b981' : response === 'رفض' ? '#dc2626' : '#6b7280',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (response === 'موافق') {
                        document.getElementById('client-response-approved-form').submit();
                    } else if (response === 'رفض') {
                        document.getElementById('client-response-rejected-form').submit();
                    } else {
                        document.getElementById('client-response-no-response-form').submit();
                    }
                }
            });
        }

        // Handle Request Proof from Designer
        function handleRequestProof(event) {
            Swal.fire({
                title: 'طلب البروفا من المصمم',
                text: 'هل أنت متأكد من طلب البروفا من المصمم؟ سيتم تحويل عرض السعر إلى بروفا وإرساله إلى المصمم تلقائياً.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، طلب البروفا',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#8b5cf6',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('request-proof-form').submit();
                }
            });
        }

        // Handle Mark as Sent to Designer
        function handleMarkAsSentToDesigner(event) {
            Swal.fire({
                title: 'إرسال إلى المصمم',
                text: 'هل أنت متأكد من إرسال أمر الشغل إلى المصمم؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، إرسال',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#8b5cf6',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mark-as-sent-to-designer-form').submit();
                }
            });
        }

        // Handle Archive Quote
        function handleArchiveQuote(event) {
            Swal.fire({
                title: 'أرشفة عرض السعر',
                text: 'هل أنت متأكد من أرشفة عرض السعر؟ سيتم تغيير الحالة إلى ملغي.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، أرشفة',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#6b7280',
                cancelButtonColor: '#dc2626',
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('archive-quote-form').submit();
                }
            });
        }
    </script>
</x-app-layout>
