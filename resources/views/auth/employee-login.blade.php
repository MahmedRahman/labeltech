<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div style="margin-bottom: 1rem; padding: 0.75rem; background-color: #dbeafe; border: 1px solid #93c5fd; color: #1e40af; border-radius: 0.375rem; font-size: 0.875rem;">
            {{ session('status') }}
        </div>
    @endif

    <div>
        <h2 class="title">تسجيل الدخول - موظف مبيعات</h2>
        <p class="subtitle">أدخل بياناتك للوصول إلى النظام</p>
    </div>

    <form method="POST" action="{{ route('employee.login') }}">
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

        <!-- Remember Me -->
        <div class="flex-between">
            <label for="remember_me" class="checkbox-group">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember">
                <span>تذكرني</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary">
            تسجيل الدخول
        </button>
    </form>
</x-guest-layout>





