@extends('nav.nav')

@section('extra')
    <div class="container-fluid- mx-5" style="margin-top: 100px">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-3">
                <h3>Запись на прием</h3>
                <form method="POST" action="{{ route('save_appointment') }}">
                    @csrf
                    <div class="mb-3 mt-3">
                        <label for="SpecialitySelection" class="form-label">Выберите специалиста</label>
                        <select id="SpecialitySelection" class="form-select" aria-label="Speciality selection">
                            @if (session()->has('doctor'))
                                @php
                                    $doctor = session('doctor');
                                    $spec = $doctor->speciality;
                                @endphp
                                <option value="0">-- Не выбран --</option>
                                @foreach ($specialities as $speciality)
                                    <option value="{{ $speciality->id }}"
                                        {{ $speciality->speciality == $spec->speciality ? 'selected' : '' }}>
                                        {{ $speciality->speciality }}</option>
                                @endforeach
                            @else
                                <option selected value="0">-- Не выбран --</option>
                                @foreach ($specialities as $speciality)
                                    <option value="{{ $speciality->id }}">{{ $speciality->speciality }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div id="SpecialitySelectionHelp" class="form-text text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="DoctorSelection" class="form-label">Врач</label>
                        <select id="DoctorSelection" class="form-select" aria-label="Doctor Selection">
                            @if (session()->has('doctors'))
                                @php
                                    $doctors = session('doctors');
                                    session()->forget('doctors');
                                @endphp
                                <option value="0">-- Не выбран --</option>
                                @foreach ($doctors as $doc)
                                    <option value="{{ $doc->id }}" {{ $doc->id == $doctor->id ? 'selected' : '' }}>
                                        {{ $doc->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div id="DoctorSelectionHelp" class="form-text" style="color:white">Врач не выбран</div>
                    </div>
                    @if (session()->has('doctor'))
                        <input id="doctor_id" type="hidden" name="doctor_id" value="{{ session('doctor')->id }}">
                        @php
                            session()->forget('doctor');
                        @endphp
                    @else
                        <input id="doctor_id" type="hidden" name="doctor_id">
                    @endif

                    <input id="appointmentId" type="hidden" name="appointment_id">
                    <button type="submit" class="btn btn-secondary">Записаться</button>

                    @error('appointment_id')
                        <div id="SubmitHelp" class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </form>

            </div>
            <div class="col-12 col-md-12 col-lg-9 overflow-auto mt-3" style="height: 75vh;">
                <div class="mb-3">
                    @if (session()->has('appointments') && session()->has('count'))
                        @if (session('count') == 0)
                            <h4 id="TableHelp" class="form-text text-danger">Расписание не заполнено</h4>
                        @else
                            <h4 id="TableHelp" class="form-text text-danger"></h4>
                        @endif
                    @else
                        <h4 id="TableHelp" class="form-text text-danger"></h4>
                    @endif
                    <table id="DoctorsTimeTable" class="table table-sm">
                        @if (session()->has('appointments') && session()->has('count'))
                            @php
                                $appointments = session('appointments');
                                $count = session('count');
                                session()->forget('appointments', 'count');
                            @endphp
                            <thead class="sticky-md-top" style="background-color: white">
                                <tr>
                                    @foreach ($appointments as $key => $value)
                                        <td>{{ mb_substr($key, mb_strpos($key, '|') + 1) }}</td>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < $count; $i++)
                                    <tr>
                                        @foreach ($appointments as $key => $value)
                                            @if (array_key_exists($i, $value))
                                                <td>
                                                    <button id={{ $value[$i]['id'] }}
                                                        class='btn {{ $value[$i]['user_id'] ? ' btn-danger' : 'btn-light availableTd' }}'
                                                        {{ $value[$i]['user_id'] ? 'disabled' : '' }}>{{ $value[$i]['time'] }}
                                                    </button>
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endfor
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
