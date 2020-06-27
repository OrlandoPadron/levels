<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('tittle', 'Levels')</title>
    <link rel="stylesheet" href="{{asset('css/global-settings.css')}}">
    <link href="{{asset('fontawesome/css/all.css')}}" rel="stylesheet" />
    <link href="{{asset('css/navbar.css')}}" rel="stylesheet" />
    <link href="{{asset('css/userbar.css')}}" rel="stylesheet" />
    <link href="{{asset('css/grid.css')}}" rel="stylesheet" />
    <link href="{{asset('css/group-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('css/profile-dashboard.css')}}" rel="stylesheet" />
    <link href="{{asset('css/trainer-dashboard.css')}}" rel="stylesheet" />
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>    
    
    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Theme included stylesheets -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">


    @yield('head')
</head>
<body>
    
    @extends('layouts.navbar')
    @extends('layouts.userbar')
    <div class="page-content">
        @yield('content')
    </div>


    @livewireScripts
</body>
</html>