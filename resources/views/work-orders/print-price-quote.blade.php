<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض السعر - {{ $workOrder->order_number ?? 'بدون رقم' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        @page {
            size: A4;
            margin: 10px;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            .print-container {
                border: none;
                padding: 10px;
                box-shadow: none;
                max-width: 100%;
                min-height: 100vh;
            }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', 'Arial', 'Tahoma', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .print-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }
        
        .print-header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .print-header .logo {
            max-width: 120px;
            height: auto;
            margin: 0 auto 10px;
            display: block;
        }
        
        .print-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #2563eb;
            margin: 0;
        }
        
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .info-section {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 10px;
        }
        
        .info-section h2 {
            font-size: 17px;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 10px;
            background: #f9f9f9;
            border-radius: 4px;
            border-right: 3px solid #2563eb;
        }
        
        .info-label {
            font-weight: 700;
            color: #374151;
            font-size: 13px;
        }
        
        .info-value {
            font-weight: 600;
            color: #111827;
            font-size: 14px;
            text-align: left;
        }
        
        .price-section {
            background: #2563eb;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        
        .price-section h2 {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
            border-bottom: 2px solid rgba(255, 255, 255, 0.4);
            padding-bottom: 10px;
            text-align: center;
        }
        
        .price-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .price-item {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .price-label {
            font-size: 13px;
            margin-bottom: 10px;
            font-weight: 700;
            opacity: 1;
        }
        
        .price-value {
            font-size: 20px;
            font-weight: 700;
        }
        
        .total-price {
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-top: 10px;
        }
        
        .total-price .price-label {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 800;
        }
        
        .total-price .price-value {
            font-size: 32px;
            font-weight: 800;
        }
        
        .footer {
            margin-top: auto;
            padding-top: 10px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        
        .footer p {
            margin: 6px 0;
        }
        
        .footer p:first-child {
            font-weight: 600;
            color: #333;
            font-size: 13px;
        }
        
        .print-button, .download-button {
            position: fixed;
            top: 20px;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            z-index: 1000;
            font-family: 'Cairo', 'Arial', 'Tahoma', sans-serif;
        }
        
        .print-button {
            left: 20px;
        }
        
        .download-button {
            left: 150px;
            background: #10b981;
        }
        
        .print-button:hover {
            background: #1e40af;
        }
        
        .download-button:hover {
            background: #059669;
        }
        
        @media print {
            .print-button, .download-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ طباعة</button>
    <button class="download-button no-print" onclick="downloadAsPNG()">📥 تحميل PNG</button>
    
    <div class="print-container" id="quote-container">
        <div class="print-header">
            <img src="{{ asset('images/logo.png') }}" alt="Label Tech Logo" class="logo">
            <h1>عرض السعر</h1>
        </div>
        
        <div class="content-wrapper">
            <!-- معلومات أساسية -->
            <div class="info-section">
                <h2>المعلومات الأساسية</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">التاريخ:</span>
                        <span class="info-value">{{ $workOrder->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">رقم عرض السعر:</span>
                        <span class="info-value">{{ $workOrder->order_number ?? 'بدون رقم' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">اسم العميل:</span>
                        <span class="info-value">{{ $workOrder->client->name ?? 'غير محدد' }}</span>
                    </div>
                    @if($workOrder->client->company)
                    <div class="info-item">
                        <span class="info-label">الشركة:</span>
                        <span class="info-value">{{ $workOrder->client->company }}</span>
                    </div>
                    @endif
                    @if($workOrder->created_by)
                    <div class="info-item">
                        <span class="info-label">موظف المبيعات:</span>
                        <span class="info-value">{{ $workOrder->created_by }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- معلومات المنتج -->
            <div class="info-section">
                <h2>معلومات المنتج</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">عدد الألوان:</span>
                        <span class="info-value">{{ $workOrder->number_of_colors ?? 0 }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">نوع الخامة:</span>
                        <span class="info-value">
                            {{ $workOrder->material ?? 'غير محدد' }}
                            @if($workOrder->additions && $workOrder->additions !== 'لا يوجد')
                                <span style="margin-right: 10px; color: #2563eb;">|</span>
                                <span style="color: #2563eb;">{{ $workOrder->additions }}</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">الكمية:</span>
                        <span class="info-value">{{ number_format($workOrder->quantity ?? 0) }}</span>
                    </div>
                    <div class="info-item" style="grid-column: 1 / -1; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span class="info-label">العرض (سم):</span>
                            <span class="info-value">{{ number_format($workOrder->width ?? 0, 2) }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <span class="info-label">الطول (سم):</span>
                            <span class="info-value">{{ number_format($workOrder->length ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- الأسعار -->
            <div class="price-section">
                <h2>التفاصيل المالية</h2>
                <div class="price-grid">
                    <div class="price-item">
                        <div class="price-label">سعر الألف</div>
                        <div class="price-value">{{ number_format($calculations['price_per_thousand'] ?? 0, 2) }} ج.م</div>
                    </div>
                    <div class="price-item">
                        <div class="price-label">سعر التجهيزات</div>
                        <div class="price-value">{{ number_format($calculations['total_preparations'] ?? 0, 2) }} ج.م</div>
                    </div>
                    <div class="total-price">
                        <div class="price-label">إجمالي المبلغ</div>
                        <div class="price-value">{{ number_format($calculations['total_order'] ?? 0, 2) }} ج.م</div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>شكراً لاختياركم خدماتنا</p>
                <p>تم إنشاء هذا العرض في: {{ $workOrder->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    </div>
    
    <script>
        // Auto print on load (optional - commented out)
        // window.onload = function() {
        //     window.print();
        // }
        
        // Download as PNG function
        function downloadAsPNG() {
            const container = document.getElementById('quote-container');
            const orderNumber = '{{ $workOrder->order_number ?? "quote" }}';
            
            // Show loading state
            const downloadBtn = document.querySelector('.download-button');
            const originalText = downloadBtn.innerHTML;
            downloadBtn.innerHTML = '⏳ جاري التحميل...';
            downloadBtn.disabled = true;
            
            html2canvas(container, {
                scale: 2,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff',
                width: container.scrollWidth,
                height: container.scrollHeight
            }).then(function(canvas) {
                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create download link
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `عرض_السعر_${orderNumber}_${new Date().getTime()}.png`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                    
                    // Reset button
                    downloadBtn.innerHTML = originalText;
                    downloadBtn.disabled = false;
                }, 'image/png');
            }).catch(function(error) {
                console.error('Error generating PNG:', error);
                alert('حدث خطأ أثناء تحميل الصورة. يرجى المحاولة مرة أخرى.');
                downloadBtn.innerHTML = originalText;
                downloadBtn.disabled = false;
            });
        }
    </script>
</body>
</html>
