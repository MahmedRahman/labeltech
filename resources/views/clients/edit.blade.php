<x-app-layout>
    @php
        $title = 'تعديل بيانات العميل';
    @endphp

    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-card {
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            padding: 2rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin: 0 0 0.5rem 0;
        }
        
        .form-header p {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-label.required::after {
            content: " *";
            color: #dc2626;
        }
        
        .form-input {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-textarea {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-family: 'Cairo', sans-serif;
            resize: vertical;
            min-height: 80px;
            transition: all 0.2s;
        }
        
        .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .error-message {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #dc2626;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.625rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Cairo', sans-serif;
        }
        
        .btn-secondary {
            background-color: #f3f4f6;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background-color: #e5e7eb;
        }
        
        .btn-primary {
            background-color: #10b981;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #059669;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-card {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="form-container">
        <div class="form-card">
            <div class="form-header">
                <h2>تعديل بيانات العميل</h2>
                <p>تحديث معلومات العميل: {{ $client->name }}</p>
            </div>

            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label required">الاسم</label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $client->name) }}" 
                           required
                           class="form-input"
                           placeholder="أدخل اسم العميل">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email and Phone -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $client->email) }}"
                               class="form-input"
                               placeholder="example@email.com">
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">الهاتف</label>
                        <input type="text" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone', $client->phone) }}"
                               class="form-input"
                               placeholder="01234567890">
                        @error('phone')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Company -->
                <div class="form-group">
                    <label for="company" class="form-label">الشركة</label>
                    <input type="text" 
                           name="company" 
                           id="company" 
                           value="{{ old('company', $client->company) }}"
                           class="form-input"
                           placeholder="اسم الشركة">
                    @error('company')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address" class="form-label">العنوان</label>
                    <textarea name="address" 
                              id="address" 
                              rows="3"
                              class="form-textarea"
                              placeholder="أدخل عنوان العميل">{{ old('address', $client->address) }}</textarea>
                    @error('address')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Opening Balance -->
                <div class="form-group">
                    <label for="opening_balance" class="form-label">رصيد أول المدة</label>
                    <input type="number" 
                           name="opening_balance" 
                           id="opening_balance" 
                           value="{{ old('opening_balance', $client->opening_balance ?? 0) }}"
                           step="0.01"
                           min="0"
                           class="form-input"
                           placeholder="0.00">
                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.5rem;">الرصيد الابتدائي للعميل عند بداية الفترة</p>
                    @error('opening_balance')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">ملاحظات</label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3"
                              class="form-textarea"
                              placeholder="أي ملاحظات إضافية عن العميل">{{ old('notes', $client->notes) }}</textarea>
                    @error('notes')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        تحديث البيانات
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
