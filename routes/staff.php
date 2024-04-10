<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('staff.login');
})->name('login');
