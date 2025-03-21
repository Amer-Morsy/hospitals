<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

######################## dashboard user ###############################################
    Route::get('/dashboard/user', function () {
        return view('dashboard.user.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard.user');

    Route::middleware('auth')->prefix('user')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';

    #################### dashboard admin ###############################################
    Route::get('/dashboard-admin', [DashboardController::class, 'index']);

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin.dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard.admin');


    Route::middleware('auth:admin')->group(function (){
        #################### Sections ###############################################
        Route::resource('Sections', SectionController::class);
        #################### Doctors ###############################################
        Route::resource('Doctors', DoctorController::class);
        Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
        Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
        #################### Service ###############################################
        Route::resource('Service', SingleServiceController::class);
    });




});
