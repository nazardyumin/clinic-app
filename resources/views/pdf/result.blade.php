<!DOCTYPE html>
<html>
@inject('carbon', 'Carbon\Carbon')
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заключение</title>
</head>
<style type="text/css">
    h2 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 50px;
    }
    .contacts {
        text-align: right;
        font-size: 10px;
        margin-right: 50px;
    }
    .fields{
        text-align: left;
        font-size: 12px;
        margin-left: 50px;
        margin-right: 50px;
    }
    .section {
        margin-top: 30px;
        padding: 50px;
        background: #fff;
    }
    .imgContainer {
        margin-left: 26%;
        margin-bottom: 5px
    }
</style>

<body>
    <div class="container">
        <div class="imgContainer">
            <img src="images/logo.png" alt="Клиника Долголетия" width="300px">
        </div>
        <div>
            <p class="contacts">г.Уфа, ул.Шафиева, 2</p>
            <p class="contacts">тел: +7(347)286-15-46</p>
            <p class="contacts">e-mail: clinic.laravel@yandex.ru</p>
        </div>

        <h2>Заключение</h2>

        @php
            [$y, $m, $d, $h, $i] = explode('-', $app->date);
            $app_date = $carbon::create($y, $m, $d, $h, $i, Auth::getUser()->timezone);
        @endphp
        <p class="fields">Дата приема: <b>{{ $app_date->format('d.m.Y, H:i') }}</b></p>
        <p class="fields">Пациент: <b>{{ $app->user()->last_name . ' ' . $app->user()->first_name . ' ' . $app->user()->patronymic }}</b></p>
        <p class="fields">Возраст: <b>{{ $carbon::parse($app->user()->date_of_birth)->age }}</b></p>
        <p class="fields">Врач: <b>{{ $app->doctor->name }}, {{Str::lower($app->doctor->speciality->speciality)}}</b></p>


        <div style="height: 15vh; margin-top:40px">
            <p class="fields">Жалобы: <b>{{ $app->complaints }}</b></p>
        </div>

        <div style="height: 9vh">
            <p class="fields">Диагноз: <b>{{ $app->diagnosis }}</b></p>
        </div>

        <div style="height: 15vh">
            <p class="fields">Назначения: <b>{{ $app->recommendations }}</b></p>
        </div>
        <br>
        <br>
        <br>
        <br>
        <p class="fields">Врач: ________________/{{$app->doctor->name}}</b></p>
        <br>
        <br>
        <p class="contacts">М.П.</p>
        <p style="text-align:center; position:absolute; top: 97%; left: 5%; " >НЕ ЯВЛЯЕТСЯ МЕДИЦИНСКИМ ДОКУМЕНТОМ. СОЗДАНО В УЧЕБНЫХ ЦЕЛЯХ.</p>
    </div>
</body>
</html>
