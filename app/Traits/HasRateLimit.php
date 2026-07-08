<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

trait HasRateLimit
{
    /**
     * Проверка rate limit по IP
     */
    protected function checkIpLimit(Request $request, int $maxAttempts = 3, int $decayMinutes = 60): ?JsonResponse
    {
        $key = 'lead_submit_ip_' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return $this->rateLimitResponse('IP', $seconds);
        }

        RateLimiter::hit($key, $decayMinutes * 60);
        return null;
    }

    /**
     * Проверка rate limit по email
     */
    protected function checkEmailLimit(Request $request, int $maxAttempts = 2, int $decayMinutes = 1440): ?JsonResponse
    {
        if (!$request->filled('email')) {
            return null;
        }

        $key = 'lead_submit_email_' . $request->email;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return $this->rateLimitResponse('email', $seconds);
        }

        RateLimiter::hit($key, $decayMinutes * 60);
        return null;
    }

    /**
     * Проверка rate limit по телефону
     */
    protected function checkPhoneLimit(Request $request, int $maxAttempts = 2, int $decayMinutes = 1440): ?JsonResponse
    {
        if (!$request->filled('phone')) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        $key = 'lead_submit_phone_' . $phone;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return $this->rateLimitResponse('телефону', $seconds);
        }

        RateLimiter::hit($key, $decayMinutes * 60);
        return null;
    }

    /**
     * Ответ при превышении лимита
     */
    protected function rateLimitResponse(string $type, int $seconds): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => "Слишком много заявок по {$type}. Попробуйте через " . ceil($seconds / 60) . " минут.",
            'retry_after' => $seconds,
            'error_code' => 'rate_limit_' . $type,
        ], 429);
    }
}
