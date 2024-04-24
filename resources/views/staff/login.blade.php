@extends('default')
@section('content')
    <x-guest-layout>
        {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

        <form method="POST" action="{{ route('staff.login') }}">
            @csrf
            <div class="flex items-center justify-center">
                <h3><b>ПОРТАЛ ДЛЯ СОТРУДНИКОВ</b></h3>
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Пароль')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-3">
                    {{ __('Войти') }}
                </x-primary-button>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    style="margin-right: 8px" href="{{ route('home') }}">
                    {{ __('На главную') }}
                </a>

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    style="margin-right: 8px" href="{{ route('login') }}">
                    {{ __('Вход на основной портал') }}
                </a>
            </div>

            <input type="hidden" name="timezone" id="timezone">
        </form>
    </x-guest-layout>
@endsection
