<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $appointments = Auth::getUser()->appointments->where('date', '>', $yesterday)->sortBy('date');
        $filtered = $appointments->filter(function (Appointment $app) {
            $tomorrow = Carbon::tomorrow()->format('Y-m-d');
            return $app->date < $tomorrow;
        });
        return view('staff.profile', ['appointments' => $filtered->all(), 'today' => $today]);
    }

    public function open(string $id)
    {
        $selectedApp = Appointment::find($id);
        return redirect(route('staff.profile'))->with(['selectedApp' => $selectedApp]);
    }

    public function update(Request $request, string $id)
    {
        $app = Appointment::find($id);
        $app->complaints = $request->complaints;
        $app->diagnosis = $request->diagnosis;
        $app->recommendations = $request->recommendations;
        $app->closed = true;
        $app->save();
        return redirect(route('staff.profile'))->with(['selectedApp' => $app]);
    }
}
