<h2 class="primary-blue-color heading-text-container">Configurar cuenta</h2>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">
  Correo electrónico
  </h3>
  <p>Levels usa tu correo electrónico como forma de inicio de sesión.
  </p>
  <div id="email-update-error" style="display: none;" class="item-with-error edit-profile">
    <p><i class="fas fa-exclamation-circle"></i> Error</p>
    <p id="email-error-message">El correo electrónico introducido ya está en uso por otro usuario. Por favor, introduzca otro email válido. </p>
  </div>    
  <ul>
      <li class="item-with-input">
        <p>Dirección email</p>
        <input type="email" value="{{Auth::user()->email}}" name="email" required>
      </li>
  </ul>
  <div class="settings-save-changes no-bottom-margin">
    <button class="btn-add-basic" type="submit" onclick="updateEmail()">Actualizar email</button>
  </div>
</div>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">
  Cambiar contraseña
  </h3>
  <div id="password-update-error" style="display: none;" class="item-with-error edit-profile">
    <p><i class="fas fa-exclamation-circle"></i> Error</p>
    <p id="password-error-message"></p>
  </div>  
  <ul>
    <li class="item-with-input">
      <p>Contraseña actual</p>
      <input type="password" value="" name="oldPassword" required>
    </li>
    <li class="item-with-input">
      <p>Nueva contraseña</p>
      <input type="password" value="" name="newPassword" required>
    </li>
    <li class="item-with-input">
      <p>Confirma tu nueva contraseña</p>
      <input type="password" value="" name="newPasswordConfirmation" required>
    </li>
  </ul>
</div>

<div class="settings-save-changes">
  <button class="btn-add-basic" onclick="updatePassword()">Actualizar contraseña</button>
</div>

<script>
  function updateEmail(){
    $('#email-update-error').hide();
    var email = $("input[name=email]").val();

    if (email.length > 0){
      $.ajax({
            url: "{{route("email.update")}}",
            type: "POST",
            data: {
                email: email,
                _token: "{{csrf_token()}}",
            },
            success: function(){
              alert('Email actualizado con éxito');
              location.reload();
                
            },
            error: function(callback){
              console.log('Error on ajax call "updateEmail" function');
              var code = callback.responseJSON.code;
              if (code == 2300){
                //Email currently in used
                $('#email-update-error').fadeIn();

              }else{
                //Not valid email 
                $('#email-update-error').children('#email-error-message')
                .text('Introduzca un email válido.');
                $('#email-update-error').fadeIn();
              } 
            }
        });
    }else{
      $('#email-update-error').children('#email-error-message')
        .text('Introduzca un email válido.');
        $('#email-update-error').fadeIn();
    }

    
  }

  function updatePassword(){
    $('#password-update-error').hide();
    var oldPassword = $("input[name=oldPassword]").val();
    var newPassword = $("input[name=newPassword]").val();
    var newPasswordConfirmation = $("input[name=newPasswordConfirmation]").val();

    if (oldPassword.length === 0 || newPassword.length === 0 || newPasswordConfirmation.length === 0){
      $('#password-update-error').children('#password-error-message')
        .text('Quedan campos sin rellenar.');
        $('#password-update-error').fadeIn();
        return;
    }

    $.ajax({
            url: "{{route("password.update")}}",
            type: "POST",
            data: {
                oldPassword: oldPassword,
                newPassword: newPassword,
                newPassword_confirmation: newPasswordConfirmation,
                _token: "{{csrf_token()}}",
            },
            success: function(){
              alert('Contraseña cambiada con éxito');
              location.reload();
                
            },
            error: function(callback){
              console.log('Error on ajax call "updatePassword" function');
              var code = callback.status; 
              if (code == 401){
                $('#password-update-error').children('#password-error-message')
                .text('La contraseña actual introducida es errónea.');
                $('#password-update-error').fadeIn();
              }else if(code == 422){
                if (newPassword.length < 8){
                  $('#password-update-error').children('#password-error-message')
                  .text('La nueva contraseña introducida no cumple con las reglas de formato. Tiene que tener un tamaño mínimo de 8 caracteres.');

                }else{
                  $('#password-update-error').children('#password-error-message')
                  .text('La confirmación de la contraseña no coincide.');

                }
                $('#password-update-error').fadeIn();
              }
              console.log(callback);
            }
        });
  }


</script>