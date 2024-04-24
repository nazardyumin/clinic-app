@extends('default')

@section('content')
<x-app-layout>
    <div class="flex lg:flex-row md:flex-col sm:flex-col py-12 justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mx-8">
                <div class="max-w-xl">
                    @include('patient.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('patient.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('patient.partials.delete-user-form')
                </div>
            </div>

            <div class="flex items-center justify-center mt-3">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    style="margin-right: 8px" href="{{ route('profile') }}">
                    {{ __('Назад') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
