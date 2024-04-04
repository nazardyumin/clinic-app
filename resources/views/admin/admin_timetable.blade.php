@extends('admin.admin_nav')

@section('admin-extra')
    <div class="row">
        <form method="POST" action="{{ route('timetable.store') }}">
            @csrf
            <div class="col-12 col-md-12 col-lg-3 mb-3">
                <label for="ChooseDoctor" class="form-label">Выберите врача</label>
                <select id="ChooseDoctor" class="form-select" aria-label="Choose Doctor" name="doctor_id">
                    <option value="0" selected>-- Не выбран --</option>
                    @foreach ($doctors as $doc)
                        <option value="{{ $doc->id }}">
                            {{ $doc->name }} - {{ $doc->speciality->speciality }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-12 col-lg-1 mb-3">
                <label for="ChooseDate" class="form-label">Выберите дату</label>
                <input id="ChooseDate" type="date" name="date" min="{{ $min_date }}" class="form-control">
            </div>

            <div class="col-12 col-md-12 col-lg-5 mb-3">
                <label for="ChooseHoursFrom" class="form-label col-auto">Выберите время</label>

                <div class="input-group mb-3">
                    <span class="input-group-text">С</span>
                    <select id="ChooseHoursFrom" class="form-select col-auto" aria-label="Choose Time" name="hours_from">
                        @foreach ($hoursFrom as $hour)
                            <option value="{{ $hour }}">{{ $hour }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">:</span>
                    <select id="ChooseMinutesFrom" class="form-select col-auto" aria-label="Choose Time"
                        name="minutes_from">
                        @foreach ($minutes as $minute)
                            <option value="{{ $minute }}">{{ $minute }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">по</span>
                    <select id="ChooseHoursTo" class="form-select col-auto" aria-label="Choose Time" name="hours_to">
                        @foreach ($hoursTo as $hour)
                            <option value="{{ $hour }}">{{ $hour }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">:</span>
                    <select id="ChooseMinutesTo" class="form-select col-auto" aria-label="Choose Time" name="minutes_to">
                        @foreach ($minutes as $minute)
                            <option value="{{ $minute }}">{{ $minute }}</option>
                        @endforeach
                    </select>
                    <span class="input-group-text">длительность</span>
                    <select id="ChooseDuration" class="form-select col-auto" aria-label="Choose Time" name="duration">
                        @foreach ($durations as $duration)
                            <option value="{{ $duration }}">{{ $duration }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-secondary mt-3">Добавить</button>
            @error('error')
                <div id="TimetableErrorHelp" class="form-text text-danger mt-3">{{ $message }}</div>
            @enderror
            @error('success')
                <div id="TimetableSuccessHelp" class="form-text text-success mt-3">{{ $message }}</div>
            @enderror
        </form>
    </div>
@endsection
