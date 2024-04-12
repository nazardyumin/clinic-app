<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffProfileController extends Controller
{
    public function index()
    {
        $timeZone = Auth::getUser()->timezone;
        $today = Carbon::now($timeZone);
        $yesterday = Carbon::yesterday($timeZone)->addDays(1)->format('Y-m-d-H-i');
        //dd($yesterday);

        $appointments = Auth::getUser()->appointments->where('date', '>', $yesterday)->sortBy('date');
        $filtered = $appointments->filter(function (Appointment $app) {
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');
            return $app->date < $tomorrow;
        });




        //dd($filtered->all());

        return view('staff.profile', ['appointments' => $filtered->all(),'today' => $today]);
    }
}
