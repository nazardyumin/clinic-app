@extends('nav.nav')

@section('extra')
    <picture>
        <source media="(min-width: 1200px)" srcset="{{ asset('images/doctors.jpg') }}">
        <source media="(min-width: 768px)" srcset="{{ asset('images/doctors-md.jpg') }}">
        <source media="(min-width: 100px)" srcset="{{ asset('images/doctors-sm.jpg') }}">
        <img class="img-fluid" src="{{ asset('images/doctors.jpg') }}" alt="">
    </picture>
@endsection
<div class="fixed-bottom text-center">
    <p style="font-size: 12px">© {{ date('Y') }} {{ config('app.name') }}. {{ __('ru.All rights reserved.') }}</p>
</div>
