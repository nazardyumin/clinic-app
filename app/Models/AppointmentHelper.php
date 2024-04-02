<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class AppointmentHelper
{
    public static function get_doctor_appointments(string $id)
    {
        $months = ['', ' января', ' февраля', ' марта', ' апреля', ' мая', ' июня', ' июля', ' августа', ' сентября', ' октября', ' ноября', ' декабря'];
        $days = ['Вс ', 'Пн ', 'Вт ', 'Ср ', 'Чт ', 'Пт ', 'Сб '];
        $timeZone = Auth::getUser()->timezone;

        date_default_timezone_set($timeZone);

        $current_date = strtotime('now');
        $current_date = strtotime('+15 minutes', $current_date);

        $doctor = Doctor::find($id);
        $appointments = $doctor->appointments;
        $filtered = $appointments->where('date', '>', $current_date)->where('day_off', '!=', 'true')->sortBy('date');

        $appointments_to_view = [];
        $count = 0;

        if (count($filtered) > 0) {

            $key_memory = '';
            $key_count = 0;
            $key_concat = '';

            foreach ($filtered as $item) {
                $n = date('n', $item->date);
                $j = date('j', $item->date);
                $w = date('w', $item->date);
                $day_key = $days[$w] . $j . $months[$n];

                if ($key_memory != $day_key) {
                    $key_count++;
                    $key_memory = $day_key;
                }
                $key_concat = ($key_count < 10 ? '0' . $key_count : $key_count) . '|' . $day_key;
                $appointments_to_view[$key_concat][] = ['id' => $item->id, 'user_id' => $item->user_id, 'time' => date('H:i', $item->date), 'day_off' => $item->day_off];
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
