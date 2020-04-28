@extends('layouts.base-inside-app')
@section('content')
    <p>Ahora deberías ver un perfil</p>
    <p>El id es {{$user->id}}</p>
    <p>Estás en el perfil de {{$user->name}}</p>
    <strong>El id de {{$user->name}} como usuario es {{$user->id}}</strong>
    <p>Dicho usuario está asociado al id de atleta {{$user->athlete->id}} </p>
    @if($user->id == Auth::user()->id)
        <form action="{{route('profile.update_avatar')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <label> Cambiar imagen perfil </label>
            <input type="file" name="avatar">
            <button type="submit">Actualizar</button>
        </form>
    @endif
    <h2>Probemos a crear un nuevo plan de entrenamiento</h2>
    <form action="{{route('trainingPlan.store')}}" method="POST">
        @csrf
        <label for="title">Título</label>
        <input type="text" name="title">
        <label for="description">Descripción</label>
        <input type="text" name="description">
        <input type="text" hidden name="athlete_associated" value="{{$user->athlete->id}}">

        <button type="submit">Crear</button>
    </form>

    
@endsection