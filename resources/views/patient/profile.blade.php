@extends('nav.nav')
@inject('carbon', 'Carbon\Carbon')
@php
    $timeZone = Auth::getUser()->timezone;
    $greetingText =
        Auth::getUser()->patronymic != ''
            ? $greeting . Auth::getUser()->first_name . ' ' . Auth::getUser()->patronymic
            : $greeting . Auth::getUser()->first_name;
@endphp
@section('extra')
    <div class="container-fluid- mx-5" style="margin-top: 100px">
        <h4>{{ $greetingText }}!</h4>
        <div class="row mt-5">
            <h6>Ваши записи:</h6>
            <hr>
            @if (count($appointments) > 0)
                @foreach ($appointments as $app)
                    <div class="col-12 col-md-12 col-lg-6 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Врач: <strong>{{ $app->doctor->name }}</strong>
                                    ({{ $app->doctor->speciality->speciality }})
                                </h5>
                                @php
                                    [$year, $month, $day, $hour, $minute] = explode('-', $app->date);
                                    $appDate = $carbon::create($year, $month, $day, $hour, $minute, $timeZone);
                                    $str_date = $appDate->format('Y-m-d H:i:s');
                                @endphp
                                <p class="card-text">Дата: {{ $appDate->format('d.m.Y') }} время:
                                    {{ $appDate->format('H:i') }}
                                </p>
                                <input type="hidden" name="appointment_id" value="{{ $app->id }}">

                                @if ($app->closed)
                                    <form id="{{ 'form' . $app->id }}" method="POST" action="{{ route('show.pdf') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $app->id }}">
                                        <a href="{{ route('show.pdf') }}" class="btn btn-secondary"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">Открыть результат
                                        </a>
                                    </form>
                                @else
                                    <a id="a{{ $str_date }}"
                                        href="{{ route('delete_appointment', $app->id) }}"><button
                                            id="but{{ $str_date }}" class="btn btn-danger">Отменить запись</button></a>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h6>Вы пока не записаны ни к одному врачу</h6>
            @endif
        </div>
    </div>
@endsection