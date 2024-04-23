@extends('nav.nav')

@section('extra')
    @auth('web')
        @if (Auth::user()->role_id == 1)
            <div class="container-fluid- mx-5" style="margin-top: 80px">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('speciality.*') ? 'active' : '' }}"
                            href="{{ route('speciality.index') }}">Специалисты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('doctor.*') ? 'active' : '' }}"
                            href="{{ route('doctor.index') }}">Врачи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('timetable.*') ? 'active' : '' }}"
                            href="{{ route('timetable.index') }}">Расписание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('statistics.*') ? 'active' : '' }}"
                            href="{{ route('statistics.index') }}">Статистика</a>
                    </li>
                </ul>
                <div class="container-fluid" style="margin-top: 45px">
                    @yield('admin-extra')
                </div>
            </div>
        @else
            <div class="form-text text-danger" style="margin-top: 100px">Страница доступна только администраторам</div>
        @endif
    @endauth
@endsection
