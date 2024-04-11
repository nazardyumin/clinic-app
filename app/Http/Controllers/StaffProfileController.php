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
        $current_date = Carbon::now($timeZone);
        $appointments = Auth::getUser()->appointments->where('date', '>=', $current_date->format('Y-m-d-H-i'))->where('user_id', '!=', null)->sortBy('date');
        $filtered = $appointments->filter(function (Appointment $app) {
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');
            return $app->date < $tomorrow;
        });




        //dd($filtered->all());

        return view('staff.profile', ['appointments' => $filtered->all(),'today' => $current_date]);
    }
}
