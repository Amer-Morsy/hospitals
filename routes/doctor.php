<?php


use App\Http\Controllers\Dashboard_Doctor\DiagnosticController;
use App\Http\Controllers\Dashboard_Doctor\LaboratorieController;
use App\Http\Controllers\Dashboard_Doctor\PatientDetailsController;
use App\Http\Controllers\Dashboard_Doctor\RayController;
use App\Http\Controllers\doctor\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| doctor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    //################################ dashboard doctor ########################################

    Route::get('/dashboard/doctor', function () {
        return view('Dashboard.doctor.dashboard');
    })->middleware(['auth:doctor'])->name('dashboard.doctor');

    //################################ end dashboard doctor #####################################


    //---------------------------------------------------------------------------------------------------------------


    Route::middleware(['auth:doctor'])->group(function () {

        Route::prefix('doctor')->group(function () {

            Route::get('completed_invoices', [InvoiceController::class, 'completedInvoices'])->name('completedInvoices');

            Route::get('review_invoices', [InvoiceController::class, 'reviewInvoices'])->name('reviewInvoices');

            Route::resource('invoices', InvoiceController::class);

            Route::post('add_review', [DiagnosticController::class, 'addReview'])->name('add_review');

            Route::resource('Diagnostics', DiagnosticController::class);

            Route::resource('rays', RayController::class);

            Route::resource('Laboratories', LaboratorieController::class);

            Route::get('show_laboratorie/{id}', [InvoiceController::class,'showLaboratorie'])->name('show.laboratorie');

            Route::get('patient_details/{id}', [PatientDetailsController::class, 'index'])->name('patient_details');


            Route::get('/404', function () {
                return view('Dashboard.404');
            })->name('404');

        });
    });
    require __DIR__ . '/auth.php';


});
