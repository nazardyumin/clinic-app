<x-mail::message>
@inject('carbon', 'Carbon\Carbon')
@php
    [$year, $month, $day, $hour, $minute] = explode('-', $app->date);
    $appDate = $carbon::create($year, $month, $day, $hour, $minute, $app->user()->timezone);
@endphp

# Здравствуйте, {{$app->user()->first_name.' '.$app->user()->patronymic}}!<br>
Завтра <b>{{$appDate->format('d.m.Y')}}</b> в <b>{{$appDate->format('H:i')}}</b> Вы записаны на приём в нашей клинике!
Вас примет врач: {{$app->doctor->name}} - {{Str::lower($app->doctor->speciality->speciality)}}.
Если Вы по каким-либо причинам не сможете подойти на приём, пожалуйста, заранее сообщите нам по телефону: +7(347)222-22-22,
или отмените запись в <a href="{{route('profile')}}">личном кабинете</a>.<br>


Искренне Ваша,<br>
{{ config('app.name') }}

</x-mail::message>
