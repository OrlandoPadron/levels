@extends('layouts.base-inside-app')

@section('content')
    @if(Auth::user()->isTrainer)
        @include('trainer-dashboard')
    @else 
        @include('athlete_home.athleteHome', ['tab' => $tab])
    @endif

@endsection
