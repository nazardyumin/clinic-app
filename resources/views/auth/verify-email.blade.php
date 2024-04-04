@extends('default')

@section('content')
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Благодарим за регистрацию! Для активации учетной записи необходимо подтвердить адрес электронной почты по ссылке в письме, которое мы Вам отправили. Если Вы не получили письмо, нажмите на кнопку ниже.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Новая ссылка была отправлена на адрес, указанный при регистрации.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Повторить отправку') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Выйти') }}
            </button>
        </form>
    </div>
</x-guest-layout>
@endsection
