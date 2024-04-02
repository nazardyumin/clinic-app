<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\CommentController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    /////////////////////////////////////




    Route::get('/appointments', [AppointmentController::class, 'show'])->name('appointments');
    Route::get('/get_doctors/{id}', [AppointmentController::class, 'get_doctors'])->name('get_doctors');
    Route::get('/get_appointments/{id}', [AppointmentController::class, 'get_appointments'])->name('get_appointments');
    Route::get('/redirect_from_doctors_page/{id}', [AppointmentController::class, 'redirect_from_doctors_page'])->name('redirect_from_doctors_page');
    Route::post('/save_appointment', [AppointmentController::class, 'save_appointment'])->name('save_appointment');

    Route::get('/account', [AppointmentController::class, 'show_user_appointments'])->name('account');
    Route::get('/delete_appointment/{id}', [AppointmentController::class, 'delete_user_appointment'])->name('delete_appointment');

    Route::get('/admin/speciality', [SpecialityController::class, 'index'])->name('speciality.index');
    Route::post('/admin/speciality', [SpecialityController::class, 'store'])->name('speciality.store');
    Route::get('/admin/delete_speciality/{id}', [SpecialityController::class, 'destroy'])->name('speciality.destroy');
    Route::post('/admin/update_speciality/{id}', [SpecialityController::class, 'update'])->name('speciality.update');

    Route::get('/admin/doctor', [DoctorController::class, 'index'])->name('doctor.index');
    Route::post('/admin/doctor', [DoctorController::class, 'store'])->name('doctor.store');
    Route::get('/admin/delete_doctor/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
    Route::post('/admin/update_doctor/{id}', [DoctorController::class, 'update'])->name('doctor.update');
    Route::resource('/admin/timetable', TimetableController::class);
});


Route::get('/', function () {
    return redirect(route('home'));
});

Route::get('/about', function () {
    return view('home.about');
})->name('about');

Route::get('/comments', [CommentController::class, 'show'])->name('comments');
Route::post('/comments', [CommentController::class, 'add'])->name('comments.add');

Route::get('/home', function () {
    return view('home.home');
})->name('home');
Route::get('/doctors', [DoctorController::class, 'show_doctors'])->name('doctors');




require __DIR__ . '/auth.php';
