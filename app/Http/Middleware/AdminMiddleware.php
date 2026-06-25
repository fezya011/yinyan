<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем авторизацию через guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Пожалуйста, войдите в систему');
        }

        // Используем Gate для проверки прав
        if (!Gate::forUser(Auth::guard('admin')->user())->allows('admin')) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->with('error', 'У вас нет доступа к админ-панели');
        }

        return $next($request);
    }
}
