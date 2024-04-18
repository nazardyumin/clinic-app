<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function show_user_appointments()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get()->sortBy('date');
        $now = Carbon::now(Auth::getUser()->timezone);
        $now->hour;
        $greetings = ['Доброе утро, ', 'Добрый день, ', 'Добрый вечер, ', 'Доброй ночи, '];
        $index = 0;
        if ($now->hour >= 12 && $now->hour < 18) $index = 1;
        else if ($now->hour >= 18 && $now->hour < 24) $index = 2;
        else if ($now->hour >= 0 && $now->hour < 6) $index = 3;
        return view('patient.profile', ['appointments' => $appointments, 'greeting' => $greetings[$index]]);
    }
}
