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
                <div class="modal-body-container">
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
                            <a onclick="submitForm('togglePlanStatus', );"><i class="fas fa-key"></i>Restablecer contraseña </a>
                            @if($user->account_activated)
                                <a onclick="if (confirm('¿Deseas desactivar la cuenta del usuario \'{{getName($user->id)}}\'?')) {
                                    adminMethods('toggleAccountStatus', {{$user->id}})
                                };"><i class="fas fa-ban"></i>Desactivar cuenta </a>
                            @else
                                <a onclick="if (confirm('¿Deseas activar la cuenta del usuario \'{{getName($user->id)}}\'?')) {
                                    adminMethods('toggleAccountStatus', {{$user->id}})
                                };"><i class="fas fa-user-check"></i>Activar cuenta </a>
                            @endif
                            <a onclick="
                                if (confirm('¿Deseas eliminar la cuenta del usuario \'{{getName($user->id)}}\'?')) {
                                
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


        </div>
    </div>
    <form action="{{route('trainingPlan.destroy')}}" method="POST" >
        @csrf
        <input type="text" value="" name="id_plan" hidden>
        <input type="text" value="" name="user_id" hidden>
    </form>
    <form action="{{route('trainingPlan.update')}}" method="POST">
        @csrf
        <input type="text" value="" name="id_plan" hidden>
        <input type="text" name="method" value="togglePlanStatus" hidden>
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


    function submitForm(method, planId, userId=0, filesAssociated=[]){
        switch(method){
            case 'destroyPlan':
                data = [userId , planId, method];
                console.log(filesAssociated);
                filesAssociated.forEach(removeEachFileFromFirebase, data);
                $('#destroyPlanForm'.concat(planId)).submit();
                
                break;
            case 'togglePlanStatus':
                $('#togglePlanStatusForm'.concat(planId)).submit();
                break;

        }
    }

    function removeEachFileFromFirebase(fileName){
        var userId = parseInt(this[0], 10); 
        var planId = parseInt(this[1], 10); 
        var method = String(this[2]); 

        deleteUserFile(userId,fileName, null, method, {planId:planId});
    }

</script>