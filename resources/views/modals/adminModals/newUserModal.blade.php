<!-- Create New Training Plan Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addNewUser">
 <!-- Modal content -->
    <div class="modal-content create-plan-modal" @click.away="addNewUser=false">
        <div class="modal-header">
            <span class="close" @click="addNewUser=!addNewUser">&times;</span>
            <h2>Crear nuevo usuario</h2>
        </div>
        <div class="modal-body">
            @php
                $newpass = 'Levels*' . time();
            @endphp
            <div class="modal-body-container">
                <div class="item-with-select">
                    <p>Tipo de usuario</p>
                    <select name="userType">
                        <option selected value="athlete"> Deportista </option>
                        <option value="trainer"> Entrenador </option>
                    </select>
                </div>
                <div class="item-with-input">
                    <p>Nombre</p>
                    <input type="text" name="name" value="" required>
                </div>
                <div class="item-with-input">
                    <p>Apellidos</p>
                    <input type="text" name="surname" value="" required>
                </div>
                <div class="item-with-input">
                    <p>Email</p>
                    <input type="email" name="email" value="" required>
                </div>
                <div class="item-with-input">
                    <p>Contraseña</p>
                    <input type="text" name="password" value="{{$newpass}}" readonly required>
                </div>
                <div class="modal-buttons">
                    <div class="principal-button">
                        <button class="btn-add-basic" onclick="createNewUser()">Crear usuario</button>
                    </div>
                </div>
                
            </div>


        </div>
    </div>
</div>

<script>

    function createNewUser(){
        var name = $("input[name='name']").val();
        var surname =$("input[name='surname']").val();
        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();
        var userType = $("select[name='userType'] option:selected").val();

        console.log(name);
        console.log(surname);
        console.log(email);
        console.log(password);
        console.log(userType);


        $.ajax({
            url: "{{route("admin.createNewUser")}}",
            type: "POST",
            data: {
                name: name,
                surname: surname,
                email: email,
                password: password,
                userType: userType, 
                _token: "{{csrf_token()}}",
            },
            success: function(){
              alert('Se ha creado el usuario con éxito');
              location.reload();
                
            },
            error: function(callback){
                console.log('Error on ajax call "createNewUser" function');
                var emailError = callback.responseJSON.errors.email[0];
                if (emailError != undefined){
                    alert('Se ha producido un error. ' + emailError);

                }
            }
        });


    }


</script>