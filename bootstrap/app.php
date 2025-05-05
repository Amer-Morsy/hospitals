<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function ()
{
    Route::middleware('web')
        ->group(base_path('routes/backend.php'));

    Route::middleware('web')
        ->group(base_path('routes/doctor.php'));

    Route::middleware('web')
        ->group(base_path('routes/ray_employee.php'));

},
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        /**** OTHER MIDDLEWARE ALIASES ****/
        'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ]);

//    $middleware->redirectUsersTo(function (Request $request) {
////        $locale = app()->getLocale();
//
//        if (Auth::guard('admin')->check()) {
//            return route('dashboard.admin', [], false);
//        }
//
//        if (Auth::guard('doctor')->check()) {
//            return route('dashboard.doctor', [], false);
//        }
//
//        if (Auth::guard('web')->check()) {
//            return route('dashboard.user', [], false);
//        }
//
//        // Default fallback
////        return $request->is("{$locale}/admin*")
////            ? route('admin.dashboard', [], false)
////            : route('home', [], false);
//    });
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
