<?php

use App\Http\Controllers\Dashboard_Ray_Employee\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::get('/dashboard/ray_employee', function () {
        return view('Dashboard.dashboard_RayEmployee.dashboard');
    })->middleware(['auth:ray_employee'])->name('dashboard.ray_employee');

    Route::middleware(['auth:ray_employee'])->group(function () {

        //############################# invoices route ##########################################
        Route::resource('invoices_ray_employee', InvoiceController::class);
        Route::get('completed_invoices', [InvoiceController::class, 'completed_invoices'])->name('completed_invoices');
        //############################# end invoices route ######################################


    });


});
