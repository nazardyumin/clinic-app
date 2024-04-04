@extends('default')

@section('content')
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Забыли пароль? Не беда! Введите адрес электронной почты, указанный при регистрации, и мы отправим Вам ссылку для восстановления пароля.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    style="margin-right: 20px" href="{{ route('login') }}">
                    {{ __('Назад') }}
                </a>
            <x-primary-button>
                {{ __('Отправить ссылку') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection
