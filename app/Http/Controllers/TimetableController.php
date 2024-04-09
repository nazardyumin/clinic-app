<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\TimetableLog;
use Carbon\Carbon;

class TimetableController extends Controller
{
    public function index()
    {
        $timeZone = Auth::getUser()->timezone;
        $now = Carbon::now($timeZone);
        $year = $now->year;
        $month = $now->month;
        if ($month == 12) {
            $month = 1;
            $year++;
        } else {
            $month++;
        }
        $nextMonth = Carbon::createFromDate($year, $month, 1);

        $hoursFrom = ['-'];
        $hoursTo = ['-'];
        $minutes = ['-'];
        $durations = [];

        for ($i = 8; $i <= 20; $i++) {
            if ($i == 8) {
                $hoursFrom[] = $i < 10 ? '0' . "$i" : "$i";
                continue;
            }
            $hoursTo[] = $i < 10 ? '0' . "$i" : "$i";
            if ($i == 20) break;
            $hoursFrom[] = $i < 10 ? '0' . "$i" : "$i";
        }

        for ($i = 0; $i <= 55; $i += 5) {
            $minutes[] = $i < 10 ? '0' . "$i" : "$i";
        }

        for ($i = 10; $i <= 30; $i += 5) {
            $durations[] = "$i";
        }
        $doctors = Doctor::all();
        return view('admin.admin_timetable', ['doctors' => $doctors, 'hoursFrom' => $hoursFrom, 'hoursTo' => $hoursTo, 'minutes' => $minutes, 'daysInMonth' => $nextMonth->daysInMonth, 'durations' => $durations]);
    }

    public function create()
    {
        return redirect(route('home'));
    }

    public function store(Request $request)
    {
        $emptyRowCount = 0;
        if ($request->doctor_id > 0 && $request->year && $request->month) {
            $timeZone = Auth::getUser()->timezone;
            $nextMonth = Carbon::createFromDate($request->year, $request->month, 1);
            for ($i = 1; $i <= $nextMonth->daysInMonth; $i++) {
                if ($request[$i . 'hours_from'] != '-' && $request[$i . 'minutes_from'] != '-' && $request[$i . 'hours_to'] != '-' && $request[$i . 'minutes_to'] != '-') {
                    $start = Carbon::Create($request->year, $request->month, $i, $request[$i . 'hours_from'], $request[$i . 'minutes_from'], $timeZone);
                    $end = Carbon::Create($request->year, $request->month, $i, $request[$i . 'hours_to'], $request[$i . 'minutes_to'], $timeZone);
                    if ($start->diffInMinutes($end) < 60 ) {
                        return redirect()->back()->withErrors([$i . 'timetableRowError' => "Задан некорректный временной интервал"])->withInput();
                    } else {
                        do {
                            Appointment::create([
                                'doctor_id' => $request->doctor_id,
                                'date' => $start->format('Y-m-d-H-i')
                            ]);
                            $start->addMinutes(intval($request[$i . 'duration']));
                        } while ($start->diffInMinutes($end) >= intval($request[$i . 'duration']));
                    }
                } else if ($request[$i . 'hours_from'] == '-' && $request[$i . 'minutes_from'] == '-' && $request[$i . 'hours_to'] == '-' && $request[$i . 'minutes_to'] == '-') {
                    $emptyRowCount++;
                    continue;
                } else {
                    return redirect()->back()->withErrors([$i . 'timetableRowError' => "Некорректный ввод времени"])->withInput();
                }
            }
            if ($emptyRowCount == $nextMonth->daysInMonth) {
                return redirect()->back()->withErrors(['error' => 'Незаполненное расписание не было добавлено'])->withInput();
            }
            TimetableLog::create([
                'year' => $request->year,
                'month' => $request->month,
                'doctor_id' => $request->doctor_id,
                'admin_id' => Auth::id()
            ]);
            return redirect(route('timetable.index'))->withErrors(['success' => 'Расписание добавлено']);
        } else {
            return redirect()->back()->withErrors(['error' => 'Не все значения выбраны'])->withInput();
        }
    }

    public function show(string $id)
    {
        $timeZone = Auth::getUser()->timezone;
        $now = Carbon::now($timeZone);
        $year = $now->year;
        $month = $now->month;
        if ($month == 12) {
            $month = 1;
            $year++;
        } else {
            $month++;
        }
        $log = TimetableLog::where('doctor_id', $id)->where('year', $year)->where('month', $month)->first();
        $status = $log ? true : false;
        return response()->json(['status' => $status]);
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
