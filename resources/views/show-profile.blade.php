@extends('layouts.base-inside-app')
@section('content')
    <p>Ahora deberías ver un perfil</p>
    <p>El id es {{$user->id}}</p>
    <p>Estás en el perfil de {{$user->name}}</p>
    @if($user->id == Auth::user()->id)
        <form action="{{route('profile.update_avatar')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <label> Cambiar imagen perfil </label>
            <input type="file" name="avatar">
            <button type="submit">Actualizar</button>
        </form>
    @endif
    
@endsection