<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/panel', function () {
    //return view('docPanel.panel');
    return view('custom.doc-user-added');
})->name('panel');
