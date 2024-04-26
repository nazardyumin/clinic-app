<?php

namespace App\Http\Controllers;

use App\Jobs\ReleaseAppointment;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\AppointmentHelper;
use Illuminate\Support\Facades\Auth;

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
            if ($upd->user_id == null) {
                $upd->user_id = Auth::id();
                $upd->save();
            } else {
                $response = AppointmentHelper::get_doctor_appointments($request->doctor_id);
                $doctors = Doctor::where('speciality_id', '=', $response['doctor']->speciality_id)->get();
                session(['doctor' => $response['doctor'], 'doctors' => $doctors, 'appointments' => $response['appointments'], 'count' => $response['count']]);
                return redirect(route('appointments'))->withErrors(["appointment_id" => "Это время занято."]);
            }
            return redirect(route('profile'));
        } else if (!$request->doctor_id) {
            return redirect(route('appointments'))->withErrors(["appointment_id" => "Врач не выбран."]);
        } else {
            $response = AppointmentHelper::get_doctor_appointments($request->doctor_id);
            $doctors = Doctor::where('speciality_id', '=', $response['doctor']->speciality_id)->get();
            session(['doctor' => $response['doctor'], 'doctors' => $doctors, 'appointments' => $response['appointments'], 'count' => $response['count']]);
            return redirect(route('appointments'))->withErrors(["appointment_id" => "Не выбрано время для записи."]);
        }
    }

    public function delete_user_appointment(string $id)
    {
        $app = Appointment::find($id);
        $app->user_id = null;
        $app->save();
        return redirect(route('profile'));
    }

    public function hold(string $id)
    {
        [$hold_id, $release_id] = explode('-', $id);
        $hold = Appointment::find($hold_id);

        if ($hold_id != $release_id) {
            if (intval($release_id) > 0) {
                $release = Appointment::find($release_id);
                $release->busy = false;
                $release->save();
            }
        }
        if (!$hold->busy) {
            $hold->busy = true;
            $hold->save();
            ReleaseAppointment::dispatch($hold)->delay(now()->addSeconds(30));
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
