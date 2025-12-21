<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض السعر - {{ $workOrder->order_number ?? 'بدون رقم' }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
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
                padding: 15mm;
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
            font-family: 'Arial', 'Tahoma', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .print-container {
            width: 210mm;
            min-height: 297mm;
            max-height: 297mm;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 15mm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        .print-header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        
        .print-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .print-header .subtitle {
            font-size: 14px;
            color: #666;
        }
        
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .info-section {
            margin-bottom: 15px;
        }
        
        .info-section h2 {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 0;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px;
            background: #f9fafb;
            border-radius: 4px;
            border-right: 3px solid #2563eb;
        }
        
        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 11px;
        }
        
        .info-value {
            font-weight: 700;
            color: #111827;
            font-size: 12px;
        }
        
        .price-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px;
            border-radius: 8px;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        
        .price-section h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 12px;
            color: white;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 8px;
        }
        
        .price-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        
        .price-item {
            background: rgba(255, 255, 255, 0.15);
            padding: 12px;
            border-radius: 6px;
            backdrop-filter: blur(10px);
            text-align: center;
        }
        
        .price-label {
            font-size: 11px;
            opacity: 0.9;
            margin-bottom: 6px;
        }
        
        .price-value {
            font-size: 16px;
            font-weight: bold;
        }
        
        .total-price {
            grid-column: 1 / -1;
            background: rgba(255, 255, 255, 0.25);
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.4);
            margin-top: 10px;
        }
        
        .total-price .price-label {
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .total-price .price-value {
            font-size: 26px;
        }
        
        .footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #1d4ed8;
        }
        
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ طباعة</button>
    
    <div class="print-container">
        <div class="print-header">
            <h1>عرض السعر</h1>
            <div class="subtitle">Price Quote</div>
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
                        <span class="info-value">{{ $workOrder->material ?? 'غير محدد' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">الكمية:</span>
                        <span class="info-value">{{ number_format($workOrder->quantity ?? 0) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">العرض (سم):</span>
                        <span class="info-value">{{ number_format($workOrder->width ?? 0, 2) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">الطول (سم):</span>
                        <span class="info-value">{{ number_format($workOrder->length ?? 0, 2) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">البكر به كام تكيت:</span>
                        <span class="info-value">{{ number_format($calculations['pieces_per_roll'] ?? 0, 0) }}</span>
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
                        <div class="price-label">سعر التكيت</div>
                        <div class="price-value">{{ number_format($calculations['price_per_unit'] ?? 0, 2) }} ج.م</div>
                    </div>
                    <div class="price-item">
                        <div class="price-label">الكمية</div>
                        <div class="price-value">{{ number_format($workOrder->quantity ?? 0) }}</div>
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
    </script>
</body>
</html>

