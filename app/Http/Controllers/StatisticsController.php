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
        $work_time = [];

        for ($i = 1; $i <= 12; $i++) {
            $y = intval($year);
            $m = $i;
            if($m == 12){
                $y += 1;
                $m = 1;
            }else{
                $m +=1;
            }
            $apps = Appointment::where('doctor_id', $doc_id)->where('closed', true)->where('date', '>', Carbon::createFromDate($year, $i, 1)->format('Y-m-d'))->get();

            $filtered = $apps->where('date', '<', Carbon::createFromDate($y, $m, 1)->format('Y-m-d'));

            CarbonInterval::setLocale('ru');
            $interval = CarbonInterval::seconds(0);

            foreach($filtered as $a){
                $interval->addMinutes(intval($a->duration));
            }

            $work_time[$i] = $interval->totalHours;
        }

        return response()->json(['work_time' => $work_time]);
    }
}
