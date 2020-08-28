<h2 class="primary-blue-color heading-text-container">Servicios de terceros</h2>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">Cuentas asociadas
  </h3>
  <p>Levels te permite añadir enlaces a tus perfiles de aplicaciones de terceros. 
    Para ello, añade la dirección a tu perfil en los campos correspondientes.
  </p>
  <ul>
    <form action="{{route('profile.thirdparties')}}" method="POST" id="profile-thirdparties-form">
      @csrf
      <li class="item-with-input">
        <p>Strava</p>
        <input type="url" value="{{$strava != null ? $strava : ''}}" name="strava" placeholder="https://www.strava.com/athletes/tu-id">
      </li>
    {{-- <li class="item-with-input">
      <p>Garmin Connect</p>
      <input type="text" value="" placeholder="Tu perfil de Garmin Connect">
    </li>
    <li class="item-with-input">
      <p>TrainingPeaks</p>
      <input type="text" value="" placeholder="Tu perfil de TrainingPeaks">
    </li> --}}
    </form>
  </ul>

</div>
<div class="settings-save-changes">
  <button class="btn-add-basic" type="submit" form="profile-thirdparties-form">Guardar cambios</button>
</div>