@extends('layouts.base')
@section('head')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="login-container">
      <div class="form">
        <form action="{{route('login')}}" method="POST">
          @csrf
          <h1 class="login-tittle">Iniciar sesión</h1>
          <div class="email-login">
            <span>Email</span>
            <input
              id = "email"
              class="input-login"
              type="email"
              name="email"
              placeholder="ejemplo@levels.com"
              value="{{ old('email') }}"
              required autocomplete="email"
              autofocus
            />
            {!! $errors->first('email', '<small class="error-message"><i class="fas fa-exclamation-circle"></i> :message</small><br>') !!}
            
          </div>
          <div class="password-login">
            <span>Contraseña</span>
            <input
            id="password"
              class="input-login"
              name="password"
              type="password"
              required autocomplete="current-password"
              placeholder="****************"
            />
            {!! $errors->first('password', '<small class="error-message"><i class="fas fa-exclamation-circle"></i> :message</small><br>') !!}
          </div>
          <div class="last-buttons">
            <div class="remember-me-login">
              <input class="checkbox-input" 
              name="remember"

              id="remember"
              {{ old('remember') ? 'checked' : '' }}
              type="checkbox" />
              <label for="remember">Recuérdame</la>
            </div>
            <div class="forgot-psswd-login">
              <a href="{{route('password.request')}}">He olvidado la contraseña</a>
            </div>
          </div>
          <div class="button-submit">
            <button type="submit">Entrar</button>
          </div>
          <div class="signup-login">
            <a href="{{route('register')}}">No tengo cuenta, registrarse</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
