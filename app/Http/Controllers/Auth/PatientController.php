<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PatientLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function store(PatientLoginRequest $request){
        $request->authenticate();
        $request->session()->regenerate();
        if (Auth::guard('patient')->check())
            return redirect()->intended(route('dashboard.patient'));

        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed'))]);

    }

    public function destroy(Request $request)
    {
        Auth::guard('patient')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
