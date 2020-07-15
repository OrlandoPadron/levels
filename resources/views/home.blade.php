@extends('layouts.base-inside-app')

@section('content')
    @if(Auth::user()->isTrainer)
        @include('trainer-dashboard')
    @else 
        <p>Esto es una prueba</p>
    @endif

@endsection
