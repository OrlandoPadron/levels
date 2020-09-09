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
    <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--DataTables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>    
    
    <!-- MarkJS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>

    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>

    <!-- Theme included stylesheets -->
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

    <!-- Global App JS-->
    @include('scripts.genericScripts')
    @yield('head')
    <!-- CSS Responsive -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}"/>

</head>
<body>   
    @extends('layouts.navbar')
    @extends('layouts.userbar')
    <div class="page-content">
        @yield('content')
    </div>


    @livewireScripts
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-storage.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-analytics.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-auth.js"></script>

    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyA78SiccN2Ja0DvcBvJQpcBYjhl9h08Bmc",
        authDomain: "levels-11f76.firebaseapp.com",
        databaseURL: "https://levels-11f76.firebaseio.com",
        projectId: "levels-11f76",
        storageBucket: "levels-11f76.appspot.com",
        messagingSenderId: "295655081196",
        appId: "1:295655081196:web:676fb218bc2539496551c9",
        measurementId: "G-41719VQ8YE"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    firebase.analytics();
    // Get a reference to the storage service, which is used to create references in your storage bucket
    var storage = firebase.storage();
    </script>
</body>
</html>