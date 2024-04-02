@extends('nav.nav')

@section('extra')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
            @foreach ($doctors as $doctor)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset($doctor->photo) }}" class="card-img-top" alt="doctor">
                        <div class="card-body">
                            @php
                                $speciality = $doctor->speciality;
                            @endphp
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="card-text">{{ $speciality->speciality }}</p>
                            <a class="btn btn-secondary"
                                href="{{ route('redirect_from_doctors_page', $doctor->id) }}">Записаться на
                                прием</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
