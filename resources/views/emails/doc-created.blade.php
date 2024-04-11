<x-mail::message>

# Здравствуйте, {{mb_substr($doctor->name, mb_strpos($doctor->name, ' ') + 1)}}!<br>
Вы были зарегистрированы в качестве сотрудника на нашем портале.
Скопируйте себе сгенерированный автоматически пароль: <b>{{$password}}</b>
и используйте его при входе на <a href="{{route('staff.profile')}}">портал</a>.<br>



Искренне Ваша,<br>
{{ config('app.name') }}

</x-mail::message>
