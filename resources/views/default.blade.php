<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>{{ env('APP_NAME', 'Клиника Долголетия') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('images/icon.png') }}">
</head>

<body>
    <div class="container-fluid-">
        <main>
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data-1970-2030.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $('#timezone').val(moment.tz.guess())
        });
    </script>
    <script src="{{ asset('js/appointments.js') }}"></script>
    <script src="{{ asset('js/admin_specialities.js') }}"></script>
    <script src="{{ asset('js/admin_doctors.js') }}"></script>
    <script src="{{ asset('js/admin_timetable.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>
    <script src="{{ asset('js/comments.js') }}"></script>
</body>

</html>
