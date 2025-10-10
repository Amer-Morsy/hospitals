<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RayEmployeeLoginRequest;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RayEmployeeController extends Controller
{
    public function store(RayEmployeeLoginRequest $request){
        Log::info('RayEmployee login attempt start', [
            'session_id_before' => session()->getId(),
            'cookie_name' => config('session.cookie'),
        ]);

        $request->authenticate();

        Log::info('RayEmployee authenticated via guard', [
            'guard_ray_check_after_auth' => Auth::guard('ray_employee')->check(),
        ]);

        session()->regenerate();

        Log::info('RayEmployee session regenerated', [
            'session_id_after' => session()->getId(),
            'guard_ray_check_after_regen' => Auth::guard('ray_employee')->check(),
        ]);

        if (Auth::guard('ray_employee')->check()) {
            $intended = redirect()->intended(route('dashboard.ray_employee'));
            Log::info('RayEmployee redirecting to intended', [
                'intended_url' => $intended->getTargetUrl(),
            ]);
            return $intended;
        }

        Log::warning('RayEmployee login failed post-authentication');
        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed'))]);


    }

    public function destroy(Request $request)
    {
        Auth::guard('ray_employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
