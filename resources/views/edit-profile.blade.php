@extends('layouts.base-inside-app')
@section('head')
<link href="{{asset('css/profile_settings.css')}}" rel="stylesheet" />
<script>
  function submit(){
    document.getElementById("myForm").submit();
  }
</script>
@endsection
@section('content')
<div class="settings-profile-container">
  <div class="settings-navbar">
    <div class="navbar-container">
      <ul>
        <li class="active">
          General
        </li>
        <li>
          Avatar
        </li>
      </ul>
    </div>
  </div>
  <div class="settings-content">
    <h2 class="primary-blue-color heading-text-container">Configuración General</h2>
    <div class="settings-content-section">
      <h3 class="primary-blue-color settings-sub-heading">
        Datos generales
      </h3>
      <ul>
        <li class="item-with-input">
          <p>Nombre</p>
          <input type="text" value="Nombre">
        </li>
        <li class="item-with-input">
          <p>Apellidos</p>
          <input type="text" value="Apellidos">
        </li>
      </ul>

    </div>
    <div class="settings-content-section">
      <h3 class="primary-blue-color settings-sub-heading">Cuentas asociadas
      </h3>
      <p>Levels te permite añadir enlaces a tus perfiles de aplicaciones de terceros. 
        Para ello, añade la dirección a tu perfil en los campos correspondientes.
      </p>
      <ul>
        <li class="item-with-input">
          <p>Strava</p>
          <input type="text" value="" placeholder="https://www.strava.com/athletes/tu-id">
        </li>
        <li class="item-with-input">
          <p>Garmin Connect</p>
          <input type="text" value="" placeholder="Tu perfil de Garmin Connect">
        </li>
        <li class="item-with-input">
          <p>TrainingPeaks</p>
          <input type="text" value="" placeholder="Tu perfil de TrainingPeaks">
        </li>
      </ul>

    </div>
  </div>
</div>
@endsection
