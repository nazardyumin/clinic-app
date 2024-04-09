<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\AppointmentHelper;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function show(string $id = null)
    {
        $specialities = Speciality::all();
        return view('appointments.appointments', compact('specialities'));
    }

    public function redirect_from_doctors_page(string $id)
    {
        $response = AppointmentHelper::get_doctor_appointments($id);
        $doctors = Doctor::where('speciality_id', '=', $response['doctor']->speciality_id)->get();
        session(['doctor' => $response['doctor'], 'doctors' => $doctors, 'appointments' => $response['appointments'], 'count' => $response['count']]);
        return redirect(route('appointments'));
    }

    public function get_doctors(string $id)
    {
        $doctors = Doctor::where('speciality_id', $id)->get();
        return response()->json($doctors);
    }

    public function get_appointments(string $id)
    {
        $response = AppointmentHelper::get_doctor_appointments($id);
        return response()->json(['appointments' => $response['appointments'], 'count' => $response['count']]);
    }

    public function save_appointment(Request $request)
    {
        if ($request->appointment_id && $request->doctor_id) {
            $upd = Appointment::find($request->appointment_id);
            $upd->user_id = Auth::id();
            $upd->save();
            return redirect(route('account'));
        } else if (!$request->doctor_id) {
            return redirect(route('appointments'))->withErrors(["appointment_id" => "Врач не выбран"]);
        } else {
            $response = AppointmentHelper::get_doctor_appointments($request->doctor_id);
            $doctors = Doctor::where('speciality_id', '=', $response['doctor']->speciality_id)->get();
            session(['doctor' => $response['doctor'], 'doctors' => $doctors, 'appointments' => $response['appointments'], 'count' => $response['count']]);
            return redirect(route('appointments'))->withErrors(["appointment_id" => "Не выбрано время для записи"]);
        }
    }

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
        return view('account.account', ['appointments' => $appointments, 'greeting' => $greetings[$index]]);
    }

    public function delete_user_appointment(string $id)
    {
        $app = Appointment::find($id);
        $app->user_id = null;
        $app->save();
        return redirect(route('account'));
    }
}
