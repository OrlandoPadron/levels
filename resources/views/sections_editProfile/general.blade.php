<h2 class="primary-blue-color heading-text-container">Datos Personales</h2>
<div class="settings-content-section">
  <ul>
    <li class="item-with-input">
      <p>Nombre</p>
      @php
        $userName = Auth::user()->name . ' ' . Auth::user()->name2;
        trim($userName);
        $userSurnames = Auth::user()->surname . ' ' . Auth::user()->surname2;
        trim($userSurnames);
      @endphp
      <input type="text" value="{{$userName}}" required>
    </li>
    <li class="item-with-input">
      <p>Apellidos</p>
      <input type="text" value="{{$userSurnames}}" required>
    </li>
    <li class="item-with-input">
      <p>Fecha de nacimiento</p>
      <input type="date" value="">
    </li>
    <li class="item-with-input">
      <p>DNI</p>
      <input type="text" value="" pattern="[0-9]{8}[A-Za-z]{1}" placeholder="Escriba aquí su DNI">
    </li>
    <li class="item-with-input">
      <p>Dirección actual</p>
      <input type="text" value="" placeholder="Escriba aquí su dirección">
    </li>
    {{-- <li class="item-with-input">
      <p>Dirección email</p>
      <input type="mail" value="{{Auth::user()->email}}" required>
    </li> --}}
    <li class="item-with-input">
      <p>Teléfono de contacto</p>
      <input type="text" value="" placeholder="Escriba aquí su teléfono">
    </li>
    <li class="item-with-input">
      <p>Profesión</p>
      <input type="text" value="" placeholder="¿A qué se dedica?">
    </li>
  </ul>

</div>
<div class="settings-save-changes">
  <button class="btn-add-basic">Guardar cambios</button>
</div>