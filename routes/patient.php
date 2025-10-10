<?php

use App\Http\Controllers\Dashboard_Patient\PatientController;
use App\Livewire\Chat\Createchat;
use App\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;





Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {


        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/custom/livewire/update', $handle)->middleware(['web', 'auth:patient']);
        });


        //################################ dashboard patient ########################################

        Route::get('/dashboard/patient', function () {
            return view('Dashboard.dashboard_patient.dashboard');
        })->middleware(['auth:patient'])->name('dashboard.patient');
        //################################ end dashboard patient #####################################

        Route::middleware(['auth:patient'])->group(function () {



            //############################# patients route ##########################################
            Route::get('invoices', [PatientController::class, 'invoices'])->name('invoices.patient');
            Route::get('laboratories', [PatientController::class, 'laboratories'])->name('laboratories.patient');
            Route::get('view_laboratories/{id}', [PatientController::class, 'viewLaboratories'])->name('laboratories.view');
            Route::get('rays', [PatientController::class, 'rays'])->name('rays.patient');
            Route::get('view_rays/{id}', [PatientController::class, 'viewRays'])->name('rays.view');
            Route::get('payments', [PatientController::class, 'payments'])->name('payments.patient');
            //############################# end patients route ######################################

            //############################# Chat route ##########################################

            Route::get('list/doctors', Createchat::class)->name('list.doctors');

            Route::get('chat/doctors',Main::class)->name('chat.doctors');



            //############################# end Chat route ######################################

        });

    }
);
