<h2 class="primary-blue-color heading-text-container">Datos Personales</h2>
<div class="settings-content-section">
  <div class="item-with-info">
    <p><i class="fas fa-info-circle"></i>Información</p>
    <p>Para añadir nombres compuestos o ambos apellidos, use la coma ( , ) como separador.</p>
    <p class="item-with-info-subsection">Por ejemplo:</p>
    <p><span class="bold">Nombre:</span> José, Juan | <span class="bold">Apellidos:</span> Pérez, Rodríguez</p>
  </div>
  <ul>
    <form action="{{route('profile.edit')}}" method="POST" id="profile-edit-form">
      @csrf
      <li class="item-with-input">
        <p>Nombre</p>
        <input type="text" name="name" value="{{$userName}}" required>
      </li>
      <li class="item-with-input">
        <p>Apellidos</p>
        <input type="text" name="surname" value="{{$userSurnames}}" required>
      </li>
      @if(!Auth::user()->isTrainer)
      
      <div class="edit-profile-subsection">
        <p><i class="fas fa-info-circle"></i> Los datos que te pediremos a continuación solo serán accesibles por tu entrenador.</p>
      </div>
      @endif

      <li class="item-with-select">
        <p>Sexo</p>
        <select name="gender">
          <option value="man" {{$gender == 'male' ? 'selected' : ''}}>Hombre</option> 
          <option value="woman" {{$gender == 'female' ? 'selected' : ''}}>Mujer</option>
          <option value="no_specified" {{$gender == null ? 'selected' : ''}}>Prefiero no decirlo</option>
        </select>
      </li>

      @if(!Auth::user()->isTrainer)
        <li class="item-with-input">
          <p>Fecha de nacimiento</p>
          <input type="date" name="birthday" value="{{$birthday != null ? $birthday : ''}}">
        </li>
        <li class="item-with-input">
          <p>DNI</p>
          <input type="text" value="{{$dni != null ? $dni : ''}}" name="dni" pattern="[0-9]{8}[A-Za-z]{1}" placeholder="Escriba aquí su DNI">
        </li>
        <li class="item-with-input">
          <p>Dirección actual</p>
          <input type="text" value="{{$address != null ? $address : ''}}" name="address" placeholder="Escriba aquí su dirección">
        </li>
        <li class="item-with-input">
          <p>Teléfono de contacto <span class="low-emphasis">| Formato: XXX XXX XXX</span> </p>
          <input type="tel" value="{{$phone != null ? $phone : ''}}" name="phone_number" 
          pattern="[0-9]{3} [0-9]{3} [0-9]{3}" placeholder="Escriba aquí su teléfono">
        </li>
        <li class="item-with-input">
          <p>Profesión</p>
          <input type="text" value="{{$occupation != null ? $occupation : ''}}" name="occupation" placeholder="¿A qué se dedica?">
        </li>
      @endif
  </form>

  </ul>

</div>
<div class="settings-save-changes">
  <button class="btn-add-basic" type="submit" form="profile-edit-form">Guardar cambios</button>
</div>