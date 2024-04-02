<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/panel', function () {
    return view('docPanel.panel');
})->name('panel');
