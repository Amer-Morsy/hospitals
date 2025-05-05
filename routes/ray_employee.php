<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    //################################ dashboard ray_employee ########################################

    Route::get('/dashboard/ray_employee', function () {
        return view('Dashboard.dashboard_RayEmployee.dashboard');
    })->middleware(['auth:ray_employee'])->name('dashboard.ray_employee');


    //################################ end dashboard ray_employee #####################################

    //---------------------------------------------------------------------------------------------------------------


    require __DIR__ . '/auth.php';

});
