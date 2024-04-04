<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index()
    {
        $timeZone = Auth::getUser()->timezone;

        $min_date = Carbon::tomorrow($timeZone)->format('Y-m-d');

        $hoursFrom = [];
        $hoursTo = [];
        $minutes = [];
        $durations = [];
        for ($i = 8; $i <= 20; $i++) {
            if ($i < 20) {
                $hoursFrom[] = $i < 10 ? '0' . "$i" : "$i";
            }
            $hoursTo[] = $i < 10 ? '0' . "$i" : "$i";
        }
        for ($i = 0; $i <= 59; $i++) {
            $minutes[] = $i < 10 ? '0' . "$i" : "$i";
        }
        for ($i = 10; $i <= 30; $i += 5) {
            $durations[] = "$i";
        }
        $doctors = Doctor::all();
        return view('admin.admin_timetable', ['doctors' => $doctors, 'hoursFrom' => $hoursFrom, 'hoursTo' => $hoursTo, 'minutes' => $minutes, 'min_date' => $min_date, 'durations' => $durations]);
    }

    public function create()
    {
        return redirect(route('home'));
    }

    public function store(Request $request)
    {
        if ($request->doctor_id > 0 && $request->date) {

            $timeZone = Auth::getUser()->timezone;
            list($year, $month, $day) = explode("-", $request->date);

            $start = Carbon::Create($year, $month, $day, $request->hours_from, $request->minutes_from, $timeZone);
            $end = Carbon::Create($year, $month, $day, $request->hours_to, $request->minutes_to, $timeZone);

            if ($start->diffInMinutes($end) < 60) {
                return redirect(route('timetable.index'))->withErrors(['error' => 'Задан некорректный временной интервал']);
            } else {
                do {
                    Appointment::create([
                        'doctor_id' => $request->doctor_id,
                        'date' => $start->format('Y-m-d-H-i')
                    ]);
                    $start->addMinutes(intval($request->duration));
                } while ($start->diffInMinutes($end) >= intval($request->duration));
                return redirect(route('timetable.index'))->withErrors(['success' => 'Расписание добавлено']);
            }
        } else {
            return redirect(route('timetable.index'))->withErrors(['error' => 'Не все значения выбраны']);
        }
    }

    public function show(string $id)
    {
        return redirect(route('home'));
    }

    public function edit(string $id)
    {
        return redirect(route('home'));
    }

    public function update(Request $request, string $id)
    {
        return redirect(route('home'));
    }

    public function destroy(string $id)
    {
        return redirect(route('home'));
    }
}
