<!-- 'Additional Info' modal-->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openShowProfileData">

    <!-- Modal content -->
    <div class="modal-content" @click.away="openShowProfileData=false">
        <div class="modal-header">
            <span class="close" @click="openShowProfileData=!openShowProfileData">&times;</span>
        <h2>Información adicional — <label class="light">{{$user->name . ' ' . $user->surname}}</label></h2>
        </div>
        <div class="modal-body">
            <div class="modal-body-container">
                <div class="text-container">
                    <div class="text-container-content">
                        <ul>
                            <li>
                                <span class="text-container-content-section">Nombre:</span>
                                <p>{{$user->name}}</p>
                            </li>
                            <li>
                                <span class="text-container-content-section">Apellidos:</span> 
                                <p>{{$user->surname}}</p>
                            </li>
                            <li>
                                <span class="text-container-content-section">Email:</span> 
                                <p>{{$user->email}}</p>
                            </li>
                            <li>
                                <span class="text-container-content-section">Administrador:</span> 
                                <p>{{$user->admin == 0 ? 'No' : 'Sí'}}</p>
                            </li>
                            <li>
                                <span class="text-container-content-section">Cuenta creada:</span> 
                                <p>{{$user->created_at->format("d/m/Y")}} <span class="dot-separation">·</span> {{$user->created_at->diffForHumans()}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <h2 class="underlined">Datos personales</h2>
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

                
            </ul> --}}
            

        </div>
        <div class="modal-footer">
            <h3>Modal Footer</h3>
        </div>
    </div>

</div>
<!-- End 'Additional Info' modal-->