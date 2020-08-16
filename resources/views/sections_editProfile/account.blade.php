<h2 class="primary-blue-color heading-text-container">Configurar cuenta</h2>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">
  Correo electrónico
  </h3>
  <p>Levels usa tu correo electrónico como forma de inicio de sesión.
  </p>
  <ul>
    <li class="item-with-input">
      <p>Dirección email</p>
      <input type="mail" value="{{Auth::user()->email}}" required>
    </li>
  </ul>
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
  <button class="btn-add-basic">Guardar cambios</button>
</div>