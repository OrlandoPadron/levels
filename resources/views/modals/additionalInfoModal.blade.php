<!-- 'Additional Info' modal-->
<div class="modal" x-show.transition.duration.250ms.opacity="openShowProfileData">

    <!-- Modal content -->
    <div class="modal-content" @click.away="openShowProfileData=false">
        <div class="modal-header">
            <span class="close" @click="openShowProfileData=!openShowProfileData">&times;</span>
        <h2>Información adicional — <label class="light">{{$user->name . ' ' . $user->surname}}</label></h2>
        </div>
        <div class="modal-body">
            <h2 class="underlined">Datos personales</h2>
            <ul>
                <li>
                    <span class="bold">Nombre: </span>{{$user->name . " " . $user->surname}}
                </li>
                <li>
                    <span class="bold">Entrenado por: </span>{!! $user->trainer_id == "null" ? '<span class="italic light">Actualmente sin entrenador</span>' : $user->athlete->trainer_id !!}
                </li>
            </ul>
            <h2 class="underlined">Sobre la cuenta</h2>
            <ul>
                <li>
                    <span class="bold">ID: </span>{{$user->id}}
                </li>
                <li>
                    <span class="bold">Email asociado: </span>{{$user->email}}
                </li>
                <li>
                    <span class="bold">Tipo de perfil: </span>{{$user->isTrainer == 1 ? 'Entrenador' : 'Deportista'}}
                </li>
                <li>
                    <span class="bold">ID de {{$user->isTrainer == 1 ? 'entrenador' : 'deportista'}} asociado: </span>{{$user->isTrainer == 1 ? $user->trainer->id : $user->athlete->id}}
                </li>
                <li>
                    <span class="bold">Cuenta creada: </span>{{date("d-m-Y", strtotime($user->created_at))}}
                </li>

                
            </ul>
            

        </div>
        <div class="modal-footer">
            <h3>Modal Footer</h3>
        </div>
    </div>

</div>
<!-- End 'Additional Info' modal-->