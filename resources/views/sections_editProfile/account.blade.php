@php
    $password = Auth::user()->password;

    if (password_verify("12345678" , Auth::user()->password)){
        echo 'Si';
    }else{
        echo 'No';
    }

@endphp
<h2 class="primary-blue-color heading-text-container">Configurar cuenta</h2>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">
  Correo electrónico
  </h3>
  <p>Levels usa tu correo electrónico como forma de inicio de sesión.
  </p>
  <div id="upload-error-" class="item-with-error edit-profile">
    <p><i class="fas fa-exclamation-circle"></i> Error</p>
    <p>El correo electrónico introducido ya está en uso por otro usuario. Por favor, introduzca otro email válido. </p>
  </div>    
  <ul>
    <form action="{{route('email.update')}}" method="POST" id="email-update-form">
      @csrf
      <li class="item-with-input">
        <p>Dirección email</p>
        <input type="email" value="{{Auth::user()->email}}" name="email" required>
      </li>
    </form>
  </ul>
  <div class="settings-save-changes no-bottom-margin">
    <button class="btn-add-basic" type="submit" form="email-update-form">Actualizar email</button>
  </div>
</div>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">
  Cambiar contraseña
  </h3>
  <ul>
    <li class="item-with-input">
      <p>Contraseña antigua</p>
      <input type="password" value="" required>
    </li>
    <li class="item-with-input">
      <p>Nueva contraseña</p>
      <input type="password" value="" required>
    </li>
    <li class="item-with-input">
      <p>Confirma tu nueva contraseña</p>
      <input type="password" value="" required>
    </li>
  </ul>
</div>

<div class="settings-save-changes">
  <button class="btn-add-basic">Actualizar contraseña</button>
</div>