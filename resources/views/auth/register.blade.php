@extends('default')

@section('content')
    @inject('carbon', 'Carbon\Carbon')

    <x-guest-layout>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mt-4">
                <x-input-label for="lname" :value="__('Фамилия')" />
                <x-text-input id="lname" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                    required autofocus autocomplete="last_name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="fname" :value="__('Имя')" />
                <x-text-input id="fname" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"
                    required autofocus autocomplete="first_name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="pat" :value="__('Отчество')" />
                <x-text-input id="pat" class="block mt-1 w-full" type="text" name="patronymic" :value="old('patronymic')"
                    required autofocus autocomplete="patronymic" />
                <x-input-error :messages="$errors->get('patronymic')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="dat" :value="__('Дата рождения')" />
                <x-text-input id="dat" class="block mt-1 w-full" type="date"
                    min="{{$carbon->now()->subYears(100)->format('Y-m-d')}}"
                    max="{{ $carbon::yesterday()->format('Y-m-d') }}" name="date_of_birth" :value="old('date_of_birth')" required
                    autofocus autocomplete="date_of_birth" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" style="text-transform:lowercase"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Пароль')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Подтверждение пароля')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <input type="hidden" name="timezone" id="timezone">


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-4">
                    {{ __('Зарегистрироваться') }}
                </x-primary-button>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    style="margin-right: 8px" href="{{ route('home') }}">
                    {{ __('На главную') }}
                </a>

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Есть аккаунт?') }}
                </a>
            </div>

        </form>
    </x-guest-layout>
@endsection
