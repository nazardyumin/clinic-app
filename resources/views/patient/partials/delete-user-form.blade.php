<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Удаление профиля') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('После удаления профиля, все Ваши данные, записи к врачу и заключения будут удалены.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Удалить профиль') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Вы уверены, что хотите удалить профиль?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('После удаления профиля все Ваши данные будут навсегда удалены.') }}
            </p>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Пожалуйста, введите пароль для подтверждения.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Пароль') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Пароль') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Отмена') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Удалить профиль') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
