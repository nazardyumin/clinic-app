<?php

use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:staff')->group(function () {
    Route::get('/login', function () {
        return view('staff.login');
    })->name('login');
    Route::post('login', [StaffAuthController::class, 'login']);
});

Route::middleware('auth:staff')->group(function () {
    Route::get('/profile', [StaffProfileController::class, 'index'])->name('profile');
    Route::post('/profile/result', [PdfController::class, 'show_pdf'])->name('show.pdf');
    Route::get('/profile/result', function(){
        abort(404);
    });
    Route::get('/{id}', [StaffProfileController::class, 'open'])->name('open');
    Route::post('/update/{id}', [StaffProfileController::class, 'update'])->name('update');
    Route::get('/update/{id}', function(){
        abort(404);
    });
    Route::post('/logout', [StaffAuthController::class, 'logout'])->name('logout');
    Route::get('/logout', function(){
        abort(404);
    });
});
