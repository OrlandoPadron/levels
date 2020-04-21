<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('tittle', 'Levels')</title>
    <link rel="stylesheet" href="{{asset('css/global-settings.css')}}">
    <link href="{{asset('fontawesome/css/all.css')}}" rel="stylesheet" />
    @yield('head')
</head>
<body>
    @yield('content')
    
</body>
</html>