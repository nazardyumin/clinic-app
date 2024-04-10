<?php

use App\Http\Controllers\Auth\StaffAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest:staff')->group(function () {

    Route::get('/login', function () {
        return view('staff.login');
    })->name('login');

    Route::post('login', [StaffAuthController::class, 'login']);

    // Route::get('register', [RegisteredUserController::class, 'create'])
    //             ->name('register');

    // Route::post('register', [RegisteredUserController::class, 'store']);

    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //             ->name('login');

    //

    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //             ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //             ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //             ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //             ->name('password.store');
});



Route::middleware('auth:staff')->group(function () {

    Route::get('/profile', function () {
        return view('staff.profile');
    })->name('profile');


    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // /////////////////////////////////////




    // Route::get('/appointments', [AppointmentController::class, 'show'])->name('appointments');
    // Route::get('/get_doctors/{id}', [AppointmentController::class, 'get_doctors'])->name('get_doctors');
    // Route::get('/get_appointments/{id}', [AppointmentController::class, 'get_appointments'])->name('get_appointments');
    // Route::get('/redirect_from_doctors_page/{id}', [AppointmentController::class, 'redirect_from_doctors_page'])->name('redirect_from_doctors_page');
    // Route::post('/save_appointment', [AppointmentController::class, 'save_appointment'])->name('save_appointment');

    // Route::get('/account', [AppointmentController::class, 'show_user_appointments'])->name('account');
    // Route::get('/delete_appointment/{id}', [AppointmentController::class, 'delete_user_appointment'])->name('delete_appointment');

    // Route::get('/admin/speciality', [SpecialityController::class, 'index'])->name('speciality.index');
    // Route::post('/admin/speciality', [SpecialityController::class, 'store'])->name('speciality.store');
    // Route::get('/admin/delete_speciality/{id}', [SpecialityController::class, 'destroy'])->name('speciality.destroy');
    // Route::post('/admin/update_speciality/{id}', [SpecialityController::class, 'update'])->name('speciality.update');

    // Route::get('/admin/doctor', [DoctorController::class, 'index'])->name('doctor.index');
    // Route::post('/admin/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    // Route::get('/admin/delete_doctor/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    // Route::post('/admin/update_doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
    // Route::resource('/admin/timetable', TimetableController::class);
});





