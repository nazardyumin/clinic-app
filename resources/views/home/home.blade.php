@extends('nav.nav')

@section('extra')
    <picture>
        <source media="(min-width: 768px)" srcset="{{ asset('images/doctors.jpg') }}">
        <source media="(min-width: 100px)" srcset="{{ asset('images/doctors-sm.jpg') }}">
        <img class="img-fluid" src="{{ asset('images/doctors.jpg') }}" alt="">
    </picture>
@endsection
