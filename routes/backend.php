<?php

use App\Http\Controllers\Dashboard\AmbulanceController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\InsuranceController;
use App\Http\Controllers\Dashboard\PaymentAccountController;
use App\Http\Controllers\Dashboard\RayEmployeeController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


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


    Route::middleware('auth:admin')->group(function () {


        Route::resource('Sections', SectionController::class);


        Route::resource('Doctors', DoctorController::class);
        Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
        Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');


        Route::resource('Service', SingleServiceController::class);

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/custom/livewire/update', $handle);
        });

        Route::view('Add_GroupServices', 'livewire.GroupServices.include_create')
            ->name('Add_GroupServices');


        Route::resource('insurance', InsuranceController::class);



        Route::resource('Ambulance', AmbulanceController::class);



        Route::resource('Patients', PatientController::class);



        Route::view('single_invoices', 'livewire.single_invoices.index')->name('single_invoices');

        Route::view('Print_single_invoices', 'livewire.single_invoices.print')->name('Print_single_invoices');



        Route::resource('Receipt', ReceiptAccountController::class);



        Route::resource('Payment', PaymentAccountController::class);

        Route::resource('ray_employee', RayEmployeeController::class);

        Route::view('group_invoices', 'livewire.Group_invoices.index')->name('group_invoices');

        Route::view('group_Print_single_invoices', 'livewire.Group_invoices.print')->name('group_Print_single_invoices');

        //############################# end Group_invoices route ######################################


    });



});
