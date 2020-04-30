@extends('layouts.base-inside-app')
@section('head')
<link href="{{asset('css/profile-dashboard.css')}}" rel="stylesheet" />
@endsection
@section('content')

@if($user->isTrainer == 1)
    <p>Es un entrenador</p>
@else
    @include('athlete-dashboard')
@endif





    {{-- <p>Ahora deberías ver un perfil</p>
    <p>El id es {{$user->id}}</p>
    <p>{{$user->trainer}}</p>
    <p>Estás en el perfil de {{$user->name}}</p>
    <strong>El id de {{$user->name}} como usuario es {{$user->id}}</strong>
    @if($user->trainer==0)
        <p>Dicho usuario está asociado al id de atleta {{$user->athlete->id}} </p>
        @if($user->id == Auth::user()->id)
            <form action="{{route('profile.update_avatar')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <label> Cambiar imagen perfil </label>
                <input type="file" name="avatar">
                <button type="submit">Actualizar</button>
            </form>
        @endif
        @if(Auth::user()->trainer == 1)
            <h2>Probemos a crear un nuevo plan de entrenamiento</h2>
            <form action="{{route('trainingPlan.store')}}" method="POST">
                @csrf
                <label for="title">Título</label>
                <input type="text" name="title">
                <label for="description">Descripción</label>
                <input type="text" name="description"><br>
                <input type="text" hidden name="athlete_associated" value="{{$user->athlete->id}}">
                
                <label for="">Nº macrociclos</label>
                <input type="number" min="1" name="num_macrocycles"><br>
                
                <label for="">Nº mesociclos</label>
                <input type="number"  min="1" name="num_mesocycles"><br>
                
                <label for="">Nº microciclos por cada mesociclo (semanas)</label>
                <input type="number"  min="1" name="num_microcycles"><br>

                <label for="">Nº sesiones por semana</label>
                <input type="number"  min="1" name="num_sessions"><br>


                <button type="submit">Crear</button>
            </form>
            
            @endif
    @endif
    <h2>Barra de navegación </h2>
    <ul>
        <li>
        <a href="{{route('profile.show', $user->id)}}">Descripción general</a>
        </li>
        
        <li>
            <a href="">Plan temporada</a>
        </li>
        
        <li>
            <a href="">Logros</a>
        </li>
    </ul> --}}
    
@endsection