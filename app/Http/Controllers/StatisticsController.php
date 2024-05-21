<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class StatisticsController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        $this_year = Carbon::now()->year;
        $last_year = $this_year - 1;

        return view('admin.admin_statistics', ['doctors' => $doctors, 'years' => [$last_year, $this_year]]);
    }

    public function show(string $id)
    {
        [$doc_id, $year] = explode('_', $id);
        $expected_time = [];
        $fact_time = [];

        for ($i = 1; $i <= 12; $i++) {
            $y = intval($year);
            $m = $i;
            if ($m == 12) {
                $y += 1;
                $m = 1;
            } else {
                $m += 1;
            }
            $expected_apps = Appointment::where('doctor_id', $doc_id)->where('date', '>', Carbon::createFromDate($year, $i, 1)->format('Y-m-d'))->get();
            $fact_apps = Appointment::where('doctor_id', $doc_id)->where('closed', true)->where('date', '>', Carbon::createFromDate($year, $i, 1)->format('Y-m-d'))->get();

            $filtered_expected = $expected_apps->where('date', '<', Carbon::createFromDate($y, $m, 1)->format('Y-m-d'));
            $filtered_fact = $fact_apps->where('date', '<', Carbon::createFromDate($y, $m, 1)->format('Y-m-d'));

            $interval_expected = CarbonInterval::seconds(0);
            $interval_fact = CarbonInterval::seconds(0);

            foreach ($filtered_expected as $a) {
                $interval_expected->addMinutes(intval($a->duration));
            }
            foreach ($filtered_fact as $a) {
                $interval_fact->addMinutes(intval($a->duration));
            }

            $expected_time[$i] = $interval_expected->totalHours;
            $fact_time[$i] = $interval_fact->totalHours;
        }

        return response()->json(['expected_time' => $expected_time, 'fact_time' => $fact_time]);
    }
}
