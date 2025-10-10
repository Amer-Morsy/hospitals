<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CustomSessionGuard
{
    public function handle(Request $request, Closure $next)
    {
        $guard = null;

        if (auth()->guard('patient')->check()) {
            $guard = 'patient';
        } elseif (auth()->guard('doctor')->check()) {
            $guard = 'doctor';
        } elseif (auth()->guard('admin')->check()) {
            $guard = 'admin';
        } elseif (auth()->guard('ray_employee')->check()) {
            $guard = 'ray_employee';
        } elseif (auth()->guard('laboratorie_employee')->check()) {
            $guard = 'laboratorie_employee';
        }

        if ($guard) {
            $prefix = config('session.prefix.' . $guard);
            Config::set('session.name', $prefix . Config::get('session.name'));

            Log::debug('CustomSessionGuard applied', [
                'guard' => $guard,
                'session_id' => $request->session()->getId(),
                'session_cookie' => config('session.cookie'),
                'session_name' => config('session.name'),
                'path' => $request->path(),
            ]);
        }

        return $next($request);
    }
}
