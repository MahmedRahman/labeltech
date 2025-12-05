<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmployeeAuthController extends Controller
{
    /**
     * Display the employee login view.
     */
    public function create(): View
    {
        return view('auth.employee-login');
    }

    /**
     * Handle an incoming employee authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::guard('employee')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $employee = Auth::guard('employee')->user();

        // التحقق من أن نوع الحساب هو "مبيعات"
        if ($employee->account_type !== 'مبيعات') {
            Auth::guard('employee')->logout();
            throw ValidationException::withMessages([
                'email' => 'ليس لديك صلاحية للدخول. يجب أن يكون نوع حسابك "مبيعات".',
            ]);
        }

        // التحقق من أن الحالة نشط
        if ($employee->status !== 'نشط') {
            Auth::guard('employee')->logout();
            throw ValidationException::withMessages([
                'email' => 'حسابك غير نشط. يرجى الاتصال بالإدارة.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('employee.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated employee session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
