@extends('default-staff')

@section('content')
    <header>
        <nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
            <div class="container-fluid mx-3">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" height="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                    <div class="d-flex">
                        @auth('staff')
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                    data-bs-display="static" aria-expanded="false">
                                    {{ Auth::user()->name}}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end">
                                    <li>
                                        <form id="logoutForm" method="POST" action="{{ route('staff.logout') }}">
                                            @csrf
                                            <a class="dropdown-item" href="{{route('staff.logout')}}"
                                                onclick="event.preventDefault();
                                                        $('form#logoutForm').submit();">
                                                Выйти
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid" style="margin-top: 75px">
        @yield('extra')
    </div>
@endsection
