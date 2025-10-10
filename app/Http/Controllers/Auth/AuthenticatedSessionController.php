<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest as UserLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('dashboard.user.auth.signin');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(UserLoginRequest $request): RedirectResponse
    {
        Log::info('User login attempt start', [
            'session_id_before' => session()->getId(),
            'cookie_name' => config('session.cookie'),
        ]);

        $request->authenticate();

        Log::info('User authenticated via default guard', [
            'guard_web_check_after_auth' => Auth::check(),
        ]);

        session()->regenerate();

        Log::info('User session regenerated', [
            'session_id_after' => session()->getId(),
            'guard_web_check_after_regen' => Auth::check(),
        ]);

        if (Auth::check()) {
            $intended = redirect()->intended(route('dashboard.user', absolute: false));
            Log::info('User redirecting to intended', [
                'intended_url' => $intended->getTargetUrl(),
            ]);
            return $intended;
        }

        Log::warning('User login failed post-authentication');
        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed'))]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
