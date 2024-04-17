<?php

use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\StaffProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:staff')->group(function () {

    Route::get('/login', function () {
        return view('staff.login');
    })->name('login');
    Route::post('login', [StaffAuthController::class, 'login']);

});



Route::middleware('auth:staff')->group(function () {

    Route::get('/profile', [StaffProfileController::class, 'index'])->name('profile');
    Route::get('/{id}', [StaffProfileController::class, 'open'])->name('open');
    Route::post('/update/{id}', [StaffProfileController::class, 'update'])->name('update');

    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('logout');
});





