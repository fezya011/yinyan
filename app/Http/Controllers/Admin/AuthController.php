<?php
// app/Http/Controllers/Admin/AuthController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Показать форму входа.
     */
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Обработка входа.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        // Попытка авторизации через guard admin
        if (Auth::guard('admin')->attempt(
            ['email' => $credentials['email'], 'password' => $credentials['password']],
            $request->boolean('remember')
        )) {
            $admin = Auth::guard('admin')->user();

            // Проверка активности
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()
                    ->with('error', 'Ваш аккаунт деактивирован')
                    ->onlyInput('email');
            }

            // Обновляем данные последнего входа
            $admin->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Добро пожаловать в админ-панель!');
        }

        return back()
            ->with('error', 'Неверный email или пароль')
            ->onlyInput('email');
    }

    /**
     * Выход из админки.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Вы вышли из системы');
    }
}
