<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DoctorController extends Controller
{

    public function store(DoctorLoginRequest $request)
    {

        Log::info('Doctor login attempt start', [
            'session_id_before' => session()->getId(),
            'cookie_name' => config('session.cookie'),
        ]);

        $request->authenticate();

        Log::info('Doctor authenticated via guard', [
            'guard_doctor_check_after_auth' => Auth::guard('doctor')->check(),
        ]);

        session()->regenerate();

        Log::info('Doctor session regenerated', [
            'session_id_after' => session()->getId(),
            'guard_doctor_check_after_regen' => Auth::guard('doctor')->check(),
        ]);

        if (Auth::guard('doctor')->check()) {
            $intended = redirect()->intended(route('dashboard.doctor'));
            Log::info('Doctor redirecting to intended', [
                'intended_url' => $intended->getTargetUrl(),
            ]);
            return $intended;
        }

        Log::warning('Doctor login failed post-authentication');
        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed'))]);

    }


    public function destroy(Request $request)
    {
        Auth::guard('doctor')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
