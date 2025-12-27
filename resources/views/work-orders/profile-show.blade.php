<x-app-layout>
    @php
        $title = 'تفاصيل البروفا';
    @endphp

    <!-- Header Actions -->
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.75rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem 0;">تفاصيل البروفا</h2>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">{{ $workOrder->order_number ?? 'بدون رقم' }}</p>
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('work-orders.list') }}" style="display: inline-flex; align-items: center; padding: 0.625rem 1rem; background-color: #6b7280; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">
                العودة للقائمة
            </a>
        </div>
    </div>

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
                <p style="font-size: 0.875rem; color: #7c3aed; margin-bottom: 1.5rem;">يمكنك الآن إرسال البروفا إلى المصمم للبدء في التصميم.</p>
                <form action="{{ route('work-orders.mark-as-sent-to-designer', $workOrder) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('هل أنت متأكد من إرسال البروفا إلى المصمم؟')" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #8b5cf6; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(139, 92, 246, 0.3);">
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
                        <p style="font-size: 0.875rem; font-weight: 600; color: #6b21a8; margin: 0;">تم إرسال البروفا إلى المصمم</p>
                        <p style="font-size: 0.75rem; color: #7c3aed; margin: 0.25rem 0 0 0;">يمكن للمصمم الآن البدء في العمل على التصميم</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Client Design Approval Section -->
    @if(($workOrder->sent_to_designer ?? 'no') == 'yes')
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 2px solid #10b981;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #065f46; margin: 0;">موافقة العميل على التصميم</h3>
            </div>
            @php
                $currentApproval = $workOrder->client_design_approval ?? 'لم يرد';
                $isApproved = $currentApproval === 'موافق';
            @endphp
            <form action="{{ route('work-orders.client-design-approval.update', $workOrder) }}" method="POST" id="client-design-approval-form">
                @csrf
                <div style="display: flex; gap: 0.75rem; margin-top: 0.5rem; flex-wrap: wrap;">
                    <label class="client-design-approval-card" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.875rem 1.5rem; border: 2px solid {{ $isApproved ? '#10b981' : '#d1d5db' }}; border-radius: 0.5rem; transition: all 0.2s; background-color: {{ $isApproved ? '#10b98120' : 'white' }};">
                        <input type="radio" 
                               name="client_design_approval" 
                               value="موافق" 
                               id="client_design_approval_approved"
                               {{ $isApproved ? 'checked' : '' }}
                               onchange="document.getElementById('client-design-approval-form').submit();"
                               style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;">
                        <span style="font-size: 0.875rem; font-weight: 500; color: {{ $isApproved ? '#10b981' : '#111827' }};">
                            <svg style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-left: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            موافق
                        </span>
                    </label>
                </div>
            </form>
            
            @if($isApproved)
            <div style="margin-top: 1rem; padding: 0.75rem; background-color: #ecfdf5; border-radius: 0.5rem; border: 1px solid #10b981;">
                <p style="font-size: 0.75rem; color: #065f46; margin: 0; line-height: 1.5;">
                    <strong>ملاحظة:</strong> سيتم طلب التجهيزات من المصمم عند موافقة العميل على التصميم.
                </p>
            </div>
            @endif
            
            @if($isApproved && !$workOrder->final_product_shape)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #10b981;">
                <p style="font-size: 0.875rem; color: #065f46; margin-bottom: 1rem; font-weight: 600;">تم موافقة العميل على التصميم. يرجى استكمال باقي البيانات:</p>
                
                <!-- Complete Production Data Form -->
                <form action="{{ route('work-orders.complete-production-data', $workOrder) }}" method="POST" id="complete-production-data-form" style="margin-top: 1.5rem;">
                    @csrf
                    
                    <!-- Final Product Shape -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #065f46; margin-bottom: 0.75rem;">شكل المنتج النهائي</label>
                        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.875rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; background-color: white;" id="final_product_shape_roll_label">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="بكر" 
                                       id="final_product_shape_roll"
                                       {{ old('final_product_shape', 'بكر') == 'بكر' ? 'checked' : '' }}
                                       onchange="toggleProductionFields()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">بكر</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: 0.875rem 1.5rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; background-color: white;" id="final_product_shape_sheet_label">
                                <input type="radio" 
                                       name="final_product_shape" 
                                       value="شيت" 
                                       id="final_product_shape_sheet"
                                       {{ old('final_product_shape') == 'شيت' ? 'checked' : '' }}
                                       onchange="toggleProductionFields()"
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">شيت</span>
                            </label>
                        </div>
                        @error('final_product_shape')
                            <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Production Method Data -->
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="font-size: 0.875rem; font-weight: 600; color: #065f46; margin-bottom: 1rem;">بيانات طريقة التشغيل</h4>
                        
                        <!-- Roll Fields (بكر) -->
                        <div id="roll-production-fields" style="display: {{ old('final_product_shape', 'بكر') == 'بكر' ? 'block' : 'none' }};">
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                                <div>
                                    <label for="number_of_rolls" style="display: block; font-size: 0.875rem; font-weight: 500; color: #065f46; margin-bottom: 0.5rem;">عدد التكت في البكره</label>
                                    <input type="number"
                                           name="number_of_rolls"
                                           id="number_of_rolls"
                                           value="{{ old('number_of_rolls', 1000) }}"
                                           min="1"
                                           style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;"
                                           placeholder="أدخل عدد التكت في البكره">
                                    @error('number_of_rolls')
                                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #065f46; margin-bottom: 0.5rem;">مقاس الكور</label>
                                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                                        @php
                                            $coreSizes = [76, 40, 25];
                                            $selectedCoreSize = old('core_size', 76);
                                        @endphp
                                        @foreach($coreSizes as $size)
                                            <label style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; padding: 0.875rem 1.25rem; border: 2px solid #d1d5db; border-radius: 0.5rem; transition: all 0.2s; min-width: 60px; text-align: center; background-color: white;" id="core_size_{{ $size }}_label">
                                                <input type="radio" 
                                                       name="core_size" 
                                                       value="{{ $size }}" 
                                                       id="core_size_{{ $size }}"
                                                       {{ $selectedCoreSize == $size ? 'checked' : '' }}
                                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #10b981;">
                                                <span style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ $size }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('core_size')
                                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sheet Fields (شيت) -->
                        <div id="sheet-production-fields" style="display: {{ old('final_product_shape') == 'شيت' ? 'block' : 'none' }};">
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                                <div>
                                    <label for="pieces_per_sheet" style="display: block; font-size: 0.875rem; font-weight: 500; color: #065f46; margin-bottom: 0.5rem;">عدد التكت في الشيت</label>
                                    <input type="number"
                                           name="pieces_per_sheet"
                                           id="pieces_per_sheet"
                                           value="{{ old('pieces_per_sheet') }}"
                                           min="1"
                                           style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;"
                                           placeholder="أدخل عدد التكت في الشيت">
                                    @error('pieces_per_sheet')
                                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sheets_per_stack" style="display: block; font-size: 0.875rem; font-weight: 500; color: #065f46; margin-bottom: 0.5rem;">عدد الشيت في الراكوة</label>
                                    <input type="number"
                                           name="sheets_per_stack"
                                           id="sheets_per_stack"
                                           value="{{ old('sheets_per_stack') }}"
                                           min="1"
                                           style="width: 100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;"
                                           placeholder="أدخل عدد الشيت في الراكوة">
                                    @error('sheets_per_stack')
                                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
                        <button type="submit" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);">
                            <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            حفظ البيانات
                        </button>
                    </div>
                </form>
            </div>
            @elseif($isApproved && $workOrder->final_product_shape)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #10b981;">
                <p style="font-size: 0.875rem; color: #065f46; margin-bottom: 1rem;">تم موافقة العميل على التصميم وتم استكمال البيانات. يمكنك الآن نقل البروفا إلى التجهيزات.</p>
                <form action="{{ route('work-orders.move-to-preparations', $workOrder) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('هل أنت متأكد من نقل البروفا إلى التجهيزات؟')" style="display: inline-flex; align-items: center; padding: 0.875rem 1.5rem; background-color: #f59e0b; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.3);">
                        <svg style="width: 20px; height: 20px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                        نقل إلى التجهيزات
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- تغيير رد العميل على عرض السعر -->
    @if(($workOrder->status ?? '') !== 'cancelled' && ($workOrder->status ?? '') !== 'completed' && ($workOrder->status ?? '') !== 'in_progress')
    <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #f59e0b;">
        <div style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                <svg style="width: 24px; height: 24px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #78350f; margin: 0;">
                    @if($workOrder->client_response)
                        تغيير رد العميل على عرض السعر
                    @else
                        رد العميل على عرض السعر
                    @endif
                </h3>
            </div>
            @if($workOrder->client_response)
                <p style="font-size: 0.875rem; color: #78350f; margin-bottom: 1rem;">
                    رد العميل الحالي: <strong>{{ $workOrder->client_response }}</strong>
                </p>
            @else
                <p style="font-size: 0.875rem; color: #78350f; margin-bottom: 1.5rem;">يرجى تحديد رد العميل:</p>
            @endif
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
                            <strong>ملاحظة:</strong> سيتم قبول عرض السعر وستتم إرساله إلى المصمم لطلب البروفا.
                        </p>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <form action="{{ route('work-orders.client-response.update', $workOrder) }}" method="POST" id="client-response-rejected-form">
                        @csrf
                        <input type="hidden" name="client_response" value="رفض">
                        <button type="submit" onclick="event.preventDefault(); handleClientResponse(event, 'رفض', 'هل أنت متأكد أن العميل رفض عرض السعر؟ سيتم إرسال العرض إلى الأرشيف.');" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.25rem; background-color: #dc2626; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);">
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
                        <button type="submit" onclick="event.preventDefault(); handleClientResponse(event, 'لم يرد', 'هل تريد تحديد أن العميل لم يرد على عرض السعر؟ سيتم إرسال العرض إلى الأرشيف.');" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3);">
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

    <!-- معلومات أساسية -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <svg style="width: 24px; height: 24px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">معلومات أساسية</h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">العميل</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">
                    <a href="{{ route('clients.show', $workOrder->client) }}" style="color: #2563eb; text-decoration: none; font-weight: 500;">
                        {{ $workOrder->client->name }}
                    </a>
                </dd>
            </div>

            @if($workOrder->order_number)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رقم البروفا</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ $workOrder->order_number }}</dd>
            </div>
            @endif

            @if($workOrder->job_name)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">اسم الشغلانه</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->job_name }}</dd>
            </div>
            @endif

            @if($workOrder->created_by)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الشخص المسؤول</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->created_by }}</dd>
            </div>
            @endif

            @if($workOrder->client_response)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">رد العميل على عرض السعر</dt>
                <dd style="margin: 0;">
                    @php
                        $clientResponseColors = [
                            'موافق' => '#10b981',
                            'رفض' => '#dc2626',
                            'لم يرد' => '#6b7280'
                        ];
                        $responseColor = $clientResponseColors[$workOrder->client_response] ?? '#6b7280';
                    @endphp
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $responseColor }}20; color: {{ $responseColor }};">
                        {{ $workOrder->client_response }}
                    </span>
                </dd>
            </div>
            @endif

            @if(($workOrder->status ?? '') === 'work_order')
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">إرسال إلى المصمم</dt>
                <dd style="margin: 0;">
                    @if(($workOrder->sent_to_designer ?? 'no') == 'yes')
                        <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: #8b5cf620; color: #8b5cf6;">
                            تم الإرسال
                        </span>
                    @else
                        <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: #6b728020; color: #6b7280;">
                            لم يتم الإرسال
                        </span>
                    @endif
                </dd>
            </div>
            @endif


            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">الحالة</dt>
                <dd style="margin: 0;">
                    @php
                        $statusColors = [
                            'draft' => '#6b7280',
                            'pending' => '#f59e0b',
                            'in_progress' => '#2563eb',
                            'completed' => '#10b981',
                            'cancelled' => '#dc2626',
                            'work_order' => '#2563eb'
                        ];
                        $statusLabels = [
                            'draft' => 'مسودة',
                            'pending' => 'قيد الانتظار',
                            'in_progress' => 'قيد التنفيذ',
                            'completed' => 'مكتمل',
                            'cancelled' => 'ملغي',
                            'work_order' => 'بروفا'
                        ];
                        $color = $statusColors[$workOrder->status] ?? '#6b7280';
                        $label = $statusLabels[$workOrder->status] ?? $workOrder->status;
                    @endphp
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $color }}20; color: {{ $color }};">
                        {{ $label }}
                    </span>
                </dd>
            </div>

            @if($workOrder->production_status)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">حالة الإنتاج</dt>
                <dd style="margin: 0;">
                    @php
                        $productionStatusColors = [
                            'بدون حالة' => '#6b7280',
                            'طباعة' => '#2563eb',
                            'قص' => '#f59e0b',
                            'تقفيل' => '#10b981',
                            'أرشيف' => '#9ca3af'
                        ];
                        $prodStatus = $workOrder->production_status ?? 'بدون حالة';
                        $prodColor = $productionStatusColors[$prodStatus] ?? '#6b7280';
                    @endphp
                    <span style="display: inline-block; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $prodColor }}20; color: {{ $prodColor }};">
                        {{ $prodStatus }}
                    </span>
                </dd>
            </div>
            @endif

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">تاريخ الإنشاء</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->created_at->format('Y-m-d H:i') }}</dd>
            </div>

            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">آخر تحديث</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0;">{{ $workOrder->updated_at->format('Y-m-d H:i') }}</dd>
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

            @if($workOrder->waste_per_roll)
            <div>
                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">عدد الهالك للبكره</dt>
                <dd style="font-size: 0.875rem; color: #111827; margin: 0; font-weight: 600;">{{ number_format($workOrder->waste_per_roll, 0) }}</dd>
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

            @if($workOrder->waste_per_roll)
            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">عدد الهالك للبكره</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($workOrder->waste_per_roll, 0) }}
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
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي المبلغ (الأسعار)</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_prices_sum'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
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
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">إجمالي الطلب</dt>
                <dd style="font-size: 1.5rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['total_order'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>

            <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 0.5rem; backdrop-filter: blur(10px);">
                <dt style="font-size: 0.875rem; font-weight: 500; color: rgba(255, 255, 255, 0.9); margin-bottom: 0.5rem;">سعر الف</dt>
                <dd style="font-size: 1.25rem; color: white; margin: 0; font-weight: 700;">
                    {{ number_format($calculations['price_per_thousand'], 2) }} <span style="font-size: 0.875rem; opacity: 0.8;">ج.م</span>
                </dd>
            </div>
        </div>
    </div>
    @endif

    <!-- الملاحظات -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 24px; height: 24px; color: #6b7280;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0;">ملاحظات</h3>
            </div>
            <button type="button" onclick="toggleNotesEdit()" id="edit-notes-btn" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #10b981; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; font-size: 0.875rem;">
                <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                تعديل الملاحظات
            </button>
        </div>
        <div id="notes-display" style="font-size: 0.875rem; color: #111827; line-height: 1.6; white-space: pre-wrap; min-height: 2rem;">
            {{ $workOrder->notes ?? 'لا توجد ملاحظات' }}
        </div>
        <div id="notes-edit" style="display: none;">
            <form action="{{ route('work-orders-list.update-notes', $workOrder) }}" method="POST" id="notes-form">
                @csrf
                <textarea name="notes" id="notes-textarea" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; font-family: inherit; resize: vertical;" placeholder="أدخل الملاحظات هنا...">{{ $workOrder->notes ?? '' }}</textarea>
                <div style="display: flex; gap: 0.75rem; margin-top: 1rem;">
                    <button type="submit" style="display: inline-flex; align-items: center; padding: 0.625rem 1.25rem; background-color: #10b981; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                        حفظ
                    </button>
                    <button type="button" onclick="cancelNotesEdit()" style="display: inline-flex; align-items: center; padding: 0.625rem 1.25rem; background-color: #6b7280; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer;">
                        إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle production fields based on final product shape
        function toggleProductionFields() {
            const rollRadio = document.getElementById('final_product_shape_roll');
            const sheetRadio = document.getElementById('final_product_shape_sheet');
            const rollFields = document.getElementById('roll-production-fields');
            const sheetFields = document.getElementById('sheet-production-fields');
            const rollLabel = document.getElementById('final_product_shape_roll_label');
            const sheetLabel = document.getElementById('final_product_shape_sheet_label');
            
            if (rollRadio && rollRadio.checked) {
                if (rollFields) rollFields.style.display = 'block';
                if (sheetFields) sheetFields.style.display = 'none';
                if (rollLabel) {
                    rollLabel.style.borderColor = '#10b981';
                    rollLabel.style.backgroundColor = '#10b98120';
                }
                if (sheetLabel) {
                    sheetLabel.style.borderColor = '#d1d5db';
                    sheetLabel.style.backgroundColor = 'white';
                }
            } else if (sheetRadio && sheetRadio.checked) {
                if (rollFields) rollFields.style.display = 'none';
                if (sheetFields) sheetFields.style.display = 'block';
                if (rollLabel) {
                    rollLabel.style.borderColor = '#d1d5db';
                    rollLabel.style.backgroundColor = 'white';
                }
                if (sheetLabel) {
                    sheetLabel.style.borderColor = '#10b981';
                    sheetLabel.style.backgroundColor = '#10b98120';
                }
            }
        }
        
        // Update core size label styles
        function updateCoreSizeStyles() {
            document.querySelectorAll('input[name="core_size"]').forEach(radio => {
                const label = document.getElementById('core_size_' + radio.value + '_label');
                if (label) {
                    if (radio.checked) {
                        label.style.borderColor = '#10b981';
                        label.style.backgroundColor = '#10b98120';
                    } else {
                        label.style.borderColor = '#d1d5db';
                        label.style.backgroundColor = 'white';
                    }
                }
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleProductionFields();
            updateCoreSizeStyles();
            
            // Listen for core size changes
            document.querySelectorAll('input[name="core_size"]').forEach(radio => {
                radio.addEventListener('change', updateCoreSizeStyles);
            });
        });
        
        function toggleNotesEdit() {
            const display = document.getElementById('notes-display');
            const edit = document.getElementById('notes-edit');
            const btn = document.getElementById('edit-notes-btn');
            
            if (display.style.display === 'none') {
                // Cancel edit mode
                display.style.display = 'block';
                edit.style.display = 'none';
                btn.innerHTML = `
                    <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    تعديل الملاحظات
                `;
            } else {
                // Enter edit mode
                display.style.display = 'none';
                edit.style.display = 'block';
                btn.innerHTML = `
                    <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    إلغاء التعديل
                `;
                document.getElementById('notes-textarea').focus();
            }
        }
        
        function cancelNotesEdit() {
            const display = document.getElementById('notes-display');
            const edit = document.getElementById('notes-edit');
            const btn = document.getElementById('edit-notes-btn');
            const textarea = document.getElementById('notes-textarea');
            
            // Reset textarea to original value
            textarea.value = `{{ $workOrder->notes ?? '' }}`;
            
            display.style.display = 'block';
            edit.style.display = 'none';
            btn.innerHTML = `
                <svg style="width: 16px; height: 16px; margin-left: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                تعديل الملاحظات
            `;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Update client design approval card styles
            function updateClientDesignApprovalStyle() {
                const designApprovalColors = {
                    'موافق': '#10b981',
                    'رفض': '#dc2626',
                    'لم يرد': '#6b7280'
                };
                
                document.querySelectorAll('input[name="client_design_approval"]').forEach(radio => {
                    const label = radio.closest('label.client-design-approval-card');
                    if (label) {
                        const value = radio.value;
                        const color = designApprovalColors[value] || '#6b7280';
                        
                        if (radio.checked) {
                            label.style.borderColor = color;
                            label.style.backgroundColor = color + '20';
                            label.style.borderWidth = '2px';
                            const span = label.querySelector('span');
                            if (span) {
                                span.style.color = color;
                            }
                        } else {
                            label.style.borderColor = '#d1d5db';
                            label.style.backgroundColor = 'transparent';
                            label.style.borderWidth = '2px';
                            const span = label.querySelector('span');
                            if (span) {
                                span.style.color = '#111827';
                            }
                        }
                    }
                });
            }
            
            // Initialize styles on page load
            updateClientDesignApprovalStyle();
            
            // Update styles when radio buttons change
            document.querySelectorAll('input[name="client_design_approval"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    updateClientDesignApprovalStyle();
                });
                
                // Also listen to click on the label
                const label = radio.closest('label.client-design-approval-card');
                if (label) {
                    label.addEventListener('click', function(e) {
                        // Prevent double triggering
                        if (e.target !== radio) {
                            setTimeout(function() {
                                updateClientDesignApprovalStyle();
                            }, 10);
                        }
                    });
                }
            });
        });
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Function to handle client response with SweetAlert2
        function handleClientResponse(event, response, message) {
            const form = event.target.closest('form');
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: response === 'موافق' ? '#10b981' : (response === 'رفض' ? '#dc2626' : '#6b7280'),
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'نعم، متأكد',
                cancelButtonText: 'إلغاء',
                reverseButtons: true,
                customClass: {
                    popup: 'rtl-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    
    <style>
        /* RTL Support for SweetAlert2 */
        .rtl-popup {
            direction: rtl;
            text-align: right;
        }
        
        .rtl-popup .swal2-title {
            text-align: right;
        }
        
        .rtl-popup .swal2-content {
            text-align: right;
        }
        
        .rtl-popup .swal2-actions {
            justify-content: flex-start;
        }
    </style>
</x-app-layout>
