<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard-admin', [DashboardController::class, 'index']);

Route::get('/dashboard/user', function () {
    return view('dashboard.user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard.user');

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/dashboard/admin', function () {
    return view('dashboard.admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard.admin');


require __DIR__.'/auth.php';
