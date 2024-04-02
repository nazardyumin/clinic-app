@extends('default')

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
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                                href="{{ route('about') }}">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctors') ? 'active' : '' }}"
                                href="{{ route('doctors') }}">Специалисты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('comments') ? 'active' : '' }}"
                                href="{{ route('comments') }}">Отзывы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointments') ? 'active' : '' }}"
                                href="{{ route('appointments') }}">Записаться на прием</a>
                        </li>
                        @auth('web')
                            @if (Auth::user()->role_id == 1)
                                @php
                                    $active = '';
                                    if (
                                        request()->routeIs('speciality.*') ||
                                        request()->routeIs('doctor.*') ||
                                        request()->routeIs('timetable.*')
                                    ) {
                                        $active = 'active';
                                    }
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link {{ $active }}"
                                        href="{{ route('speciality.index') }}">Администратор</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <div class="d-flex">
                        @auth('web')
                            <div class="btn-group">
                                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                    data-bs-display="static" aria-expanded="false">
                                    {{ Auth::user()->first_name }}
                                    @php
                                        $count = Auth::getUser()->getAppointmentsCount();
                                    @endphp
                                    @if ($count > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $count }}
                                        </span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" href="{{ route('account') }}">Личный кабинет</a></li>
                                    {{-- <li><a class="dropdown-item" href="{{ route('logout') }}">Выйти</a></li> --}}
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <a class="dropdown-item" href="route('logout')"
                                                onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                                Выйти
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-light">Войти</a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container-fluid" style="margin-top: 75px">
        @yield('extra')
    </div>
@endsection
