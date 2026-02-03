<x-guest-layout>
    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 1.5rem; display: flex; justify-content: center; align-items: center;">
        <img src="{{ asset('images/logo.png') }}" alt="Label Tech Logo" style="max-width: 200px; width: 100%; height: auto; display: block; margin: 0 auto;">
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div style="margin-bottom: 1rem; padding: 0.75rem; background-color: #dbeafe; border: 1px solid #93c5fd; color: #1e40af; border-radius: 0.375rem; font-size: 0.875rem;">
            {{ session('status') }}
        </div>
    @endif

    <div>
        <h2 class="title">تسجيل الدخول</h2>
        <p class="subtitle">أدخل بياناتك للوصول إلى النظام</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input 
                id="email" 
                class="form-input" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="example@labeltech.com" />
            @error('email')
                <div style="margin-top: 0.375rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">كلمة المرور</label>
            <input 
                id="password" 
                class="form-input"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
                placeholder="••••••••" />
            @error('password')
                <div style="margin-top: 0.375rem; font-size: 0.875rem; color: #dc2626;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex-between">
            <label for="remember_me" class="checkbox-group">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember">
                <span>تذكرني</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">
                    نسيت كلمة المرور؟
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary">
            تسجيل الدخول
        </button>
    </form>

    <!-- Test Accounts Cards (تظهر في كل البيئات بما فيها الإنتاج) -->
    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
        <h3 style="font-size: 1rem; font-weight: 600; color: #374151; margin-bottom: 1rem; text-align: center;">حسابات التجربة</h3>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem; margin-bottom: 0.75rem;">
            <!-- Admin Card -->
            <div class="test-account-card" data-email="admin@admin.com" data-password="admin" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span style="font-weight: 600; color: white; font-size: 0.875rem;">Admin</span>
                </div>
                <div style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.9);">
                    <div>admin@admin.com</div>
                    <div>admin</div>
                </div>
            </div>

            <!-- Sales Card -->
            <div class="test-account-card" data-email="sales@labeltech.com" data-password="password" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span style="font-weight: 600; color: white; font-size: 0.875rem;">مبيعات</span>
                </div>
                <div style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.9);">
                    <div>sales@labeltech.com</div>
                    <div>password</div>
                </div>
            </div>

            <!-- Designer Card -->
            <div class="test-account-card" data-email="designer@labeltech.com" data-password="password" style="background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    <span style="font-weight: 600; color: white; font-size: 0.875rem;">تصميم</span>
                </div>
                <div style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.9);">
                    <div>designer@labeltech.com</div>
                    <div>password</div>
                </div>
            </div>

            <!-- Production Card -->
            <div class="test-account-card" data-email="production@labeltech.com" data-password="password" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                    <span style="font-weight: 600; color: white; font-size: 0.875rem;">تشغيل</span>
                </div>
                <div style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.9);">
                    <div>production@labeltech.com</div>
                    <div>password</div>
                </div>
            </div>

            <!-- Accountant Card -->
            <div class="test-account-card" data-email="accountant@labeltech.com" data-password="password" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-5m-6 5v-5m6 5h-3m-3 0h3m-3-5h3m-3-5h3M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M9 7h6m-6 10h6"></path>
                    </svg>
                    <span style="font-weight: 600; color: white; font-size: 0.875rem;">حسابات</span>
                </div>
                <div style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.9);">
                    <div>accountant@labeltech.com</div>
                    <div>password</div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .test-account-card {
            padding: 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .test-account-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .test-account-card:active {
            transform: translateY(0);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.test-account-card');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    const email = this.getAttribute('data-email');
                    const password = this.getAttribute('data-password');
                    
                    if (emailInput && passwordInput) {
                        emailInput.value = email;
                        passwordInput.value = password;
                        emailInput.focus();
                    }
                });
            });
        });
    </script>
</x-guest-layout>
