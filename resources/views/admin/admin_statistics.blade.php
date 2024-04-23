@extends('admin.admin_nav')

@section('admin-extra')
@inject('carbon', 'Carbon\Carbon')
<div class="row">
    <div class="col-12 col-md-12 col-lg-4 mb-3">
        <label for="doctor" class="form-label">Врач</label>
        <select id="doctor" class="form-select" aria-label="Choose Doctor" name="doctor_id">
            <option value="0" selected>-- Не выбран --</option>
            @foreach ($doctors as $doc)
                <option value="{{ $doc->id }}">
                    {{ $doc->name }} - {{ $doc->speciality->speciality }}</option>
            @endforeach
        </select>

        <label for="year" class="form-label mt-3">Год</label>
        <select id="year" class="form-select col-auto" aria-label="Choose Year">
            @foreach ($years as $year)
                <option value="{{ $year }}" @if($year == $carbon::now()->year) selected @endif>{{ $year }} </option>
            @endforeach
        </select>

        <button id="ShowStatBtn" class="btn btn-secondary mt-5" disabled>Показать отчет</button>
        <div id="StatError" class="form-text text-danger mt-3"></div>
    </div>

    <div class="col-12 col-md-12 col-lg-8 mb-3">
        <div id="chart" style="height: 60vh"></div>
    </div>

</div>
@endsection
