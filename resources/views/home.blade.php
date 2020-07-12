@extends('layouts.base-inside-app')

@section('content')
    @if(Auth::user()->isTrainer)
        @include('trainer-dashboard')
        
    @endif

@endsection
