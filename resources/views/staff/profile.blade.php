@extends('nav.nav-staff')
@inject('carbon', 'Carbon\Carbon')
@section('extra')
    <div class="container-fluid- mx-3" style="margin-top: 100px">
        <div class="row mt-5">
            <h6>Ваши пациенты на {{ $today->format('d.m.Y') }}:</h6>
            <hr>
            <div class="col-12 col-md-12 col-lg-1 mt-3 overflow-auto" style="height: 82vh">
                @if (count($appointments) > 0)
                    <div class="d-grid gap-2 d-md-block">
                        @foreach ($appointments as $app)
                            @php
                                [$y, $m, $d, $h, $i] = explode('-', $app->date);
                                $app_date = $carbon::create($y, $m, $d, $h, $i, Auth::getUser()->timezone);
                            @endphp
                            @if ($app->user())
                                <button type="button"
                                    @if ($app->date < $today->subMinutes(15)->format('Y-m-d-H-i')) disabled
                            class="btn btn-sm btn-secondary mb-3"
                            @else
                            @php
                                $selectedId = 0;
                                if (session('selectedApp')) $selectedId = session('selectedApp')->id;
                            @endphp
                            id="{{ 'btnPatient_' . $app->id }}"
                            class="btn btn-sm btn-primary mb-3 @if ($app->id == $selectedId) active @endif"
                                    @endif>
                                    {{ $app_date->format('H:i') . ' - ' . $app->user()->last_name . ' ' . mb_substr($app->user()->first_name, 0, 1) . '.' . mb_substr($app->user()->patronymic, 0, 1) . '.' }}
                                </button>
                            @else
                                <button type="button"
                                    @if ($app->date < $today->format('Y-m-d-H-i')) disabled
                            class="btn btn-sm btn-outline-secondary mb-3"
                            @else
                            class="btn btn-sm btn-outline-primary mb-3" @endif>
                                    {{ $app_date->format('H:i') . ' - нет записи' }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                @else
                    <h6>У вас на сегодня нет пациентов</h6>
                @endif
            </div>

            <div class="col-11 col-md-12 col-lg-10 mt-3 mx-3 mb-3">
                @php
                    $patient = '';
                    $age = '';
                    $appId = '';
                    $complaints = '';
                    $diagnosis = '';
                    $recommendations = '';
                    $closed = false;
                    if (session('selectedApp')) {
                        $patient =
                            session('selectedApp')->user()->last_name .
                            ' ' .
                            session('selectedApp')->user()->first_name .
                            ' ' .
                            session('selectedApp')->user()->patronymic;
                        $age = $carbon::parse(session('selectedApp')->user()->date_of_birth)->age;
                        $appId = session('selectedApp')->id;
                        $complaints = session('selectedApp')->complaints;
                        $diagnosis = session('selectedApp')->diagnosis;
                        $recommendations = session('selectedApp')->recommendations;
                        $closed = session('selectedApp')->closed;
                    }
                @endphp
                <h5 class="text-center mb-3">Протокол осмотра</h5>
                <form id="appForm" action="{{ route('staff.update', $appId) }}" method="POST">
                    @csrf
                    <h6 class="mb-3">Пациент: &nbsp <b>{{ $patient }}</b></h6>
                    <h6 class="mb-3">Возраст: &nbsp <b>{{ $age }}</b></h6>
                    <h6>Жалобы: </h6>
                    <textarea rows="6" class="form-control" name="complaints" required>{{ $complaints }}</textarea>
                    <h6 class="mt-3">Диагноз: </h6>
                    <textarea rows="6" class="form-control" name="diagnosis" required>{{ $diagnosis }}</textarea>
                    <h6 class="mt-3">Назначения: </h6>
                    <textarea rows="6" class="form-control" name="recommendations" required>{{ $recommendations }}</textarea>
                </form>

                <div class="d-flex flex-row-reverse">
                    <button class="btn btn-secondary mt-3" @if (!session('selectedApp') || $closed) disabled @endif
                        onclick="
                    event.preventDefault();
                    $('form#appForm').submit();
                    ">Завершить
                        прием</button>

                    @if ($closed)
                        <form id="pdfForm" method="POST" action="{{ route('staff.show.pdf') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $appId }}">
                            <a href="{{ route('staff.show.pdf') }}" class="btn btn-secondary mt-3 mx-3"
                                onclick="event.preventDefault();
                            $('form#pdfForm').submit();">Открыть
                                заключение
                            </a>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endsection
