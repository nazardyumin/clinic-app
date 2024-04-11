<x-mail::message>

# Здравствуйте, {{mb_substr($doctor->name, mb_strpos($doctor->name, ' ') + 1)}}!<br>
Ваша электронная почта была изменена.
В связи с этим был сгенерирован новый пароль: <b>{{$password}}</b><br>
Используйте его при входе на <a href="{{route('staff.profile')}}">портал</a>.<br>



Искренне Ваша,<br>
{{ config('app.name') }}

</x-mail::message>
