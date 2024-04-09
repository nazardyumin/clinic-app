<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
</head>
<body>
<div style="display: flex; flex-direction:column; align-items:start">
    <img src="https://blotos.ru/wp-content/uploads/f/b/d/fbdb60147c4e1e4b924f6b85991ae9e0.png" alt="App Logo" width="250px">
    <br><br>
    {{-- {{$doctor->name}} --}}
    {{-- {{$password}} --}}
    <h3>Здравствуйте, </h3>
    <p>Вы были зарегистрированы в качестве сотрудника на нашем портале.</p>
    <p>Скопируйте себе сгенерированный автоматически пароль: <b>пароль</b></p>
    <p>используйте его при входе на <a href="#">портал</a>.</p>

    <br><br>
    <footer>© {{ date('Y') }} {{ config('app.name') }}. {{ __('ru.All rights reserved.') }}</footer>
</div>
</body>
</html>
