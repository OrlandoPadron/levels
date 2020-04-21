@extends('layouts.base')
@section('head')
@section('tittle', 'Levels | Registro')
<link rel="stylesheet" href="{{ asset('css/signup.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="signup-container">
      <div class="form">
        <form action="{{ route('register') }}" method="POST">
            @csrf
          <h1 class="signup-tittle">Registro</h1>
          <div class="signup-field">
            <span>Nombre</span>
            <input class="input-signup form-control @error('name') is-invalid @enderror" type="text" id="name" name="name" value="{{old('name') }}" required autocomplete="name" autofocus />
            @error('name')
                <small class="error-message">
                    <strong><i class="fas fa-exclamation-circle"></i>{{ $message }}</strong>
                </small>
            @enderror
           
        </div>
          <div class="signup-field">
            <span>Apellidos</span>
            <input id="surname" class="input-signup form-control @error('surname') is-invalid @enderror" type="text" name="surname"value="{{ old('surname') }}" required autocomplete="surname" placeholder="" />
            @error('surname')
            <small class="error-message">
                <strong><i class="fas fa-exclamation-circle"></i>{{ $message }}</strong>
            </small>
            @enderror
        </div>
          <div class="signup-field">
            <span>Email</span>
            <input id="email" class="input-signup form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"/>
            @error('email')
            <small class="error-message">
                <strong><i class="fas fa-exclamation-circle"></i>{{ $message }}</strong>
            </small>
            @enderror
        </div>
          <div class="signup-field">
            <span>Contraseña</span>
            <input id="password" type="password" class="input-signup form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"/>
            @error('password')
            <small class="error-message">
                <strong><i class="fas fa-exclamation-circle"></i>{{ $message }}</strong>
            </small>
            @enderror
        </div>
          <div class="signup-field">
            <span>Repetir contraseña</span>
            <input id="password-confirm" type="password" class="input-signup form-control" name="password_confirmation" required autocomplete="new-password"/>
          </div>
          <div class="last-buttons">
            <div class="usertype-signup">
              <input id="checktrainer" name="trainer" type="checkbox" value="1"/>
              <div class="tooltip">
                <label for="checktrainer">Soy entrenador</label>
                <span class="tooltiptext"
                  >No podrás cambiar esta opción posteriormente.
                </span>
              </div>
            </div>
          </div>
          <div class="button-submit">
            <button type="submit">Registrarse</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection