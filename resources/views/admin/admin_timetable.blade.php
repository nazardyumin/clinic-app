@extends('admin.admin_nav')

@section('admin-extra')

    <form class="row" method="POST" action="{{ route('timetable.store') }}">
        @csrf
        <div class="col-12 col-md-12 col-lg-4 mb-3">
            <label for="ChooseDoctor" class="form-label">Выберите врача</label>
            <select id="ChooseDoctor" class="form-select" aria-label="Choose Doctor" name="doctor_id">
                <option value="0" selected>-- Не выбран --</option>
                @foreach ($doctors as $doc)
                    @php
                        $selected = false;
                        if (session('doc_id')) {
                            $selected = session('doc_id') == $doc->id;
                        }
                    @endphp

                    <option value="{{ $doc->id }}" @if (old('doctor_id') == $doc->id) selected @endif
                        @if ($selected) selected @endif>
                        {{ $doc->name }} - {{ $doc->speciality->speciality }}</option>
                @endforeach
            </select>

            <div class="mt-3 form-check-end">
                @php
                    $check = false;
                    if (session('checked')) {
                        $check = session('checked');
                    }
                @endphp
                <label class="form-check-label" for="newDocCheckbox">Новый врач</label>
                <input id="newDocCheckbox" type="checkbox" class="form-check-input mx-1"
                    @if ($check) checked="{{ $check }}" @endif>
            </div>

            <div class="input-group mt-3">
                <span class="input-group-text">Год</span>
                @php
                    if (session('year')) {
                        $year = session('year');
                    }
                @endphp
                <select id="yearSelect" class="form-select col-auto" aria-label="Choose Year" name="year">
                    <option value="{{ $year }}">{{ $year }}</option>
                </select>
                <span class="input-group-text">месяц</span>
                @php
                    if (session('month')) {
                        $month = session('month');
                    }
                @endphp
                <select id="monthSelect" class="form-select col-auto" aria-label="Choose Month" name="month">
                    <option value="{{ $month }}">{{ $month < 10 ? '0' . $month : $month }}</option>
                </select>
            </div>
            @php
                $disabled = false;
                if (session('record_exists')) {
                    $disabled = true;
                }
            @endphp
            <button id="btnTimetableSubmit" type="submit" class="btn btn-secondary mt-3"
                @if ($disabled) disabled @endif>Добавить</button>
            @error('error')
                <div id="TimetableErrorHelp" class="form-text text-danger mt-3">{{ $message }}</div>
            @enderror
            @error('success')
                <div id="TimetableSuccessHelp" class="form-text text-success mt-3">{{ $message }}</div>
            @enderror
            @php
                $message = '';
                if (session('error')) {
                    $message = session('error');
                }
            @endphp
            <div id="TimetableErrorFromAjaxHelp" class="form-text text-danger mt-3">{{ $message }}</div>
        </div>

        <div id="TimetableContainer" class="col-12 col-md-12 col-lg-8 mb-3 overflow-auto" style="height: 80vh">
            @php
                $index = 1;
                if (session('today')) {
                    $index = session('today');
                }
                if (session('daysInMonth')) {
                    $daysInMonth = session('daysInMonth');
                }
            @endphp
            @for ($i = $index; $i <= $daysInMonth; $i++)
                <div class="input-group mb-3">
                    <span class="input-group-text">{{ $i < 10 ? '0' . $i : $i }}&nbsp</span>
                    <span class="input-group-text">c</span>
                    <select class="form-select col-auto" aria-label="Choose Time" name="{{ $i . 'hours_from' }}">
                        @foreach ($hoursFrom as $hour)
                            <option value="{{ $hour }}" @if (old($i . 'hours_from') == $hour) selected @endif>
                                {{ $hour }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">:</span>
                    <select class="form-select col-auto" aria-label="Choose Time" name="{{ $i . 'minutes_from' }}">
                        @foreach ($minutes as $minute)
                            <option value="{{ $minute }}" @if (old($i . 'minutes_from') == $minute) selected @endif>
                                {{ $minute }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">до</span>
                    <select id="{{ 'hoursTo_' . $i }}" class="form-select col-auto" aria-label="Choose Time"
                        name="{{ $i . 'hours_to' }}">
                        @foreach ($hoursTo as $hour)
                            <option value="{{ $hour }}" @if (old($i . 'hours_to') == $hour) selected @endif>
                                {{ $hour }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">:</span>
                    <select id="{{ 'minutesTo_' . $i }}" class="form-select col-auto" aria-label="Choose Time"
                        name="{{ $i . 'minutes_to' }}">
                        @foreach ($minutes as $minute)
                            <option value="{{ $minute }}" @if (old($i . 'minutes_to') == $minute) selected @endif>
                                {{ $minute }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">длительность</span>
                    <select class="form-select col-auto" aria-label="Choose Time" name="{{ $i . 'duration' }}">
                        @foreach ($durations as $duration)
                            @if ($duration == '15')
                                <option value="{{ $duration }}" selected>{{ $duration }}</option>
                            @else
                                <option value="{{ $duration }}" @if (old($i . 'duration') == $duration) selected @endif>
                                    {{ $duration }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @error($i . 'timetableRowError')
                    <div id="{{ 'TimetableRowError' . $i }}" class="form-text text-danger mt-3 mb-3">{{ $message }}</div>
                @enderror
            @endfor
        </div>
    </form>
@endsection
