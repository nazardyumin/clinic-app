<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Appointment;

class TimetableController extends Controller
{
    public function index()
    {
        $timeZone = Auth::getUser()->timezone;
        date_default_timezone_set($timeZone);

        $year = date('Y');
        $month = date('m');
        $day = date('d');

        $today = strtotime(date($year . '-' . $month . '-' . $day . ' 00:00')); //сегодня 00:00
        $tomorrow = strtotime('+1 day', $today); //завтра 00:00

        $min_date = date("Y-m-d", $tomorrow);

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
            date_default_timezone_set($timeZone);

            $start = strtotime(date($request->date . ' ' . $request->hours_from . ':' . $request->minutes_from));
            $end = strtotime(date($request->date . ' ' . $request->hours_to . ':' . $request->minutes_to));

            if (($end - $start) < 60 * 60) {
                return redirect(route('timetable.index'))->withErrors(['error' => 'Задан некорректный временной интервал']);
            } else {
                do {
                    Appointment::create([
                        'doctor_id' => $request->doctor_id,
                        'date' => $start
                    ]);
                    $start = strtotime('+' . $request->duration . ' minutes', $start);
                } while ($start < $end);
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
