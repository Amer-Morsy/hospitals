<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function store(AdminLoginRequest $request)
    {

        $request->authenticate();
        $request->session()->regenerate();
        if (Auth::guard('admin')->check())
            return redirect()->intended(route('dashboard.admin'));

        return redirect()->back()->withErrors(['name' => (trans('Dashboard/auth.failed'))]);

    }


    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
