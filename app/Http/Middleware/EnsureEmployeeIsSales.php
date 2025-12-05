<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeIsSales
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('login');
        }

        $employee = Auth::guard('employee')->user();

        if ($employee->account_type !== 'مبيعات') {
            Auth::guard('employee')->logout();
            return redirect()->route('employee.login')
                ->withErrors(['email' => 'ليس لديك صلاحية للوصول إلى هذه الصفحة.']);
        }

        if ($employee->status !== 'نشط') {
            Auth::guard('employee')->logout();
            return redirect()->route('employee.login')
                ->withErrors(['email' => 'حسابك غير نشط. يرجى الاتصال بالإدارة.']);
        }

        return $next($request);
    }
}
