<!-- Create New Training Plan Modal -->
<div id="editUser{{$user->id}}" class="modal" style="display:none;" onkeypress="checkKeyPress('{{$user->id}}')">
 <!-- Modal content -->
    <div class="modal-content edit-plan-modal">
        <div class="modal-header">
            <span class="close" onclick="$('#editUser{{$user->id}}').fadeOut();">&times;</span>
            <div class="flex-title-and-subtitle">
                <h2>Editar usuario</h2>
                <span class="light">{{getName($user->id)}}</span>
                @if (!$user->account_activated)
                <span class="status-alert"><i class="fas fa-exclamation-circle"></i>Cuenta desactivada</span>
                @endif
            </div>
        </div>
        @php
            $userName = null;
            $userSurnames = null;

            if ($user->name2 != null){
                $userName = $user->name . ', ' . $user->name2;
            }else{
                $userName = $user->name;

            }
            if ($user->surname2 != null){
                $userSurnames = $user->surname . ', ' .$user->surname2;
                
            }else{
                $userSurnames = $user->surname;

            }
            trim($userName);
            trim($userSurnames);

        @endphp
        <div class="modal-body">
            <form class="form-edituser" action="{{route('admin.management')}}" method="POST">
                @csrf
                <div class="modal-body-container" id="modal-body-container{{$user->id}}">
                    <div class="item-with-info">
                        <p><i class="fas fa-info-circle"></i>Información</p>
                        <p>Para añadir nombres compuestos o ambos apellidos, use la coma ( , ) como separador.</p>
                        <p class="item-with-info-subsection">Por ejemplo:</p>
                        <p><span class="bold">Nombre:</span> José, Juan | <span class="bold">Apellidos:</span> Pérez, Rodríguez</p>
                    </div>
                    <div class="item-with-input">
                        <p>Nombre</p>
                        <input type="text" name="name" value="{{$userName}}" required>
                    </div>
                    <div class="item-with-input" style="margin-bottom: 20px">
                        <p>Apellidos</p>
                        <input type="text" name="surname" value="{{$userSurnames}}" required>
                    </div>
                                        
                    <div class="modal-buttons">
                        <div class="alternative-buttons">
                            @if($user->isTrainer)
                                <a onclick="
                                if (confirm('¿Deseas cambiar los privilegios del usuario \'{{getName($user->id)}}\'?')) {
                                        adminMethods('toggleAdminStatus', {{$user->id}})
                                    };"><i class="fas fa-user-cog"></i>{{$user->admin ? 'Quitar rol de administrador' : 'Convertir en administrador'}}</a>
                            @endif
                            <a onclick="toggleResetPasswordView({{$user->id}});"><i class="fas fa-key"></i>Restablecer contraseña </a>
                            @if($user->account_activated)
                                <a onclick="if (confirm('¿Deseas desactivar la cuenta del usuario \'{{getName($user->id)}}\'?')) {
                                    adminMethods('toggleAccountStatus', {{$user->id}})
                                };"><i class="fas fa-ban"></i>Desactivar cuenta </a>
                            @else
                                <a onclick="if (confirm('¿Deseas activar la cuenta del usuario \'{{getName($user->id)}}\'?')) {
                                    adminMethods('toggleAccountStatus', {{$user->id}})
                                };"><i class="fas fa-user-check"></i>Activar cuenta </a>
                            @endif
                            @php
                            $userFilesArray = prepareAllFilesAssociatedWithUserIntoArray($user);
                            // dump($userFilesArray);
                            @endphp
                            <a onclick="
                                if (confirm('¿Deseas eliminar la cuenta del usuario \'{{getName($user->id)}}\'?')) {
                                    deleteUser({{json_encode($userFilesArray, true)}}, {{$user->id}})
                                }"><i class="fas fa-user-slash"></i>Eliminar usuario</a>
                        </div>
                        <div class="principal-button">
                            <button class="btn-add-basic" type="submit">Guardar cambios</button>
                        </div>

                    </div>
                    
                </div>
                <input type="text" name="method" value="editUserProfile" hidden>
                <input type="text" name="userId" value="{{$user->id}}" hidden>
            </form>
            <div class="modal-body-container" id="change-password-section{{$user->id}}" style="display: none;">
                <div class="change-password">
                    <h3>Restablecer contraseña</h3>
                    <div class="item-with-info">
                        <p><i class="fas fa-info-circle"></i>Información</p>
                        <p>La contraseña del usuario se restablecerá y se sustituirá por la clave 
                            mostrada a continuación. Dicha clave será la nueva contraseña para acceder 
                            a la cuenta del usuario. Es de suma importancia que el usuario cambie la 
                            contraseña una vez acceda a su cuenta.</p>
                    </div>
                    <div class="password-reset-container">
                        <p>Nueva contraseña</p>
                        <div class="password-block">
                            @php
                                $newpass = 'Levels*' . time();
                            @endphp
                            <p>{{$newpass}}</p>

                        </div>
                    </div>
                    <div class="modal-buttons">
                        <div class="principal-button align-center-items">
                            <button onclick="toggleResetPasswordView({{$user->id}})" class="btn-gray-basic">Cancelar</button>
                            <button onclick="resetPassword({{$user->id}}, '{{$newpass}}')" class="btn-add-basic">Cambiar contraseña</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <form action="{{route('admin.destroyUser')}}" method="POST" id="destroy-user-form-{{$user->id}}">
        @csrf
        <input type="text" value="{{$user->id}}" name="userId" hidden>
    </form>
</div>


<script>
    /*
    * Modal visibility efects. 
    */
    //On Escape modal disappears 
    $(document).keyup(function(e) {
        if (e.key === "Escape"){
            $("#editUser{{$user->id}}").fadeOut();
        }
    });

    // Clicking away modal disappears. 
    $("#editUser{{$user->id}}").click(function() {
        $("#editUser{{$user->id}}").fadeOut();
    });

    $("#editUser{{$user->id}}").children(".modal-content").click(function(event) {
        event.stopPropagation();
    });


    function toggleResetPasswordView(userId){
        if ($('#change-password-section'.concat(userId)).is(':visible')){
            $('#modal-body-container'.concat(userId)).fadeIn();
            $('#change-password-section'.concat(userId)).hide();

        }else{
            $('#modal-body-container'.concat(userId)).hide();
            $('#change-password-section'.concat(userId)).fadeIn();

        }

    }

    function resetPassword(userId, newPassword){
        console.log(newPassword);
    }

    function adminMethods(method, userId){
        $.ajax({
                url: "{{route("admin.management")}}",
                type: "POST",
                data: {
                    method: method,
                    userId: userId,
                    _token: "{{csrf_token()}}",
                },
                success: function(callback){
                    switch(method){
                        case 'toggleAdminStatus':
                            alert('Privilegios cambiados');
                            location.reload();
                            break; 
                        
                        case 'toggleAccountStatus':
                            alert('Estado de la cuenta actualizado');
                            location.reload();
                            break;
                    }
                },
                error: function(){
                    console.log('Error on ajax call "adminMethods" function');
                }  
            });
    }
    

    function deleteUser(userFilesArray, userId){
            alert('Eliminando usuario...');
            userFilesArray.forEach(removeEachFileFromFirebase, userId);
            //$('#destroy-user-form-'.concat(userId)).submit(); 
            console.log('Se ha eliminado todo...');


        
    }

    function removeEachFileFromFirebase(userFile){
        var userId = parseInt(this, 10); 
        var filename =  userFile['filename'];

        if(userFile.hasOwnProperty('planId')){
            var planId =  userFile['planId'];
            deleteUserFile(userId,filename, null, 'destroyPlan', {planId:planId});

        }else{
            deleteUserFile(userId,filename, null, 'destroyUserFile');

        }

    }

</script>