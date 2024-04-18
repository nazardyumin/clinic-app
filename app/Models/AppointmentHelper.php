<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentHelper
{
    public static function get_doctor_appointments(string $id)
    {
        $months = ['', ' января', ' февраля', ' марта', ' апреля', ' мая', ' июня', ' июля', ' августа', ' сентября', ' октября', ' ноября', ' декабря'];
        $days = ['Вс ', 'Пн ', 'Вт ', 'Ср ', 'Чт ', 'Пт ', 'Сб '];
        $timeZone = Auth::getUser()->timezone;

        $current_date = Carbon::now($timeZone)->addMinutes(15)->format('Y-m-d-H-i');

        $doctor = Doctor::find($id);
        $appointments = $doctor->appointments;
        $filtered = $appointments->where('date', '>', $current_date)->sortBy('date');

        $appointments_to_view = [];
        $count = 0;

        if (count($filtered) > 0) {

            $key_memory = '';
            $key_count = 0;
            $key_concat = '';

            foreach ($filtered as $item) {
                [$year, $month, $day, $hour, $minute] = explode('-', $item->date);
                $itemDate = Carbon::create($year, $month, $day, $hour, $minute, $timeZone);

                $day_key = $days[$itemDate->dayOfWeek] . $itemDate->day . $months[$itemDate->month];

                if ($key_memory != $day_key) {
                    $key_count++;
                    $key_memory = $day_key;
                }
                $key_concat = ($key_count < 10 ? '0' . $key_count : $key_count) . '|' . $day_key;
                $appointments_to_view[$key_concat][] = ['id' => $item->id, 'user_id' => $item->user_id, 'time' => $itemDate->format('H:i')];
            }

            foreach ($appointments_to_view as $key => $value) {
                if (count($value) > $count) {
                    $count = count($value);
                }
            }
        }

        return ['doctor' => $doctor, 'appointments' => $appointments_to_view, 'count' => $count];
    }
}
