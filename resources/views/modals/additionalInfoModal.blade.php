<!-- 'Additional Info' modal-->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openShowProfileData">

    <!-- Modal content -->
    <div class="modal-content additional-info-modal" @click.away="openShowProfileData=false">
        <div class="modal-header">
            <span class="close" @click="openShowProfileData=!openShowProfileData">&times;</span>
        <h2>Información adicional</h2>
        </div>
        <div class="modal-body">
            <div class="modal-body-container">
                <div class="text-container">
                    <div class="text-container-content">
                        @php
                            $fullUserName = $user->name . ' ' . $user->name2 . ' ' . $user->surname  . ' ' . $user->surname2 ;
                        @endphp
                        <ul>
                            @if($user->isTrainer)
                                <li>
                                    <span class="text-container-content-section">Nombre y Apellidos</span>
                                    <p>{{$fullUserName}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Correo electrónico</span> 
                                    <p>{{$user->email}}</p>
                                </li>
                            @else
                                <li>
                                    <span class="text-container-content-section">Nombre y Apellidos</span>
                                    <p>{{$fullUserName}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Fecha de nacimiento</span>
                                    <p>13/03/1997</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Sexo</span>
                                    <p>Hombre</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">DNI</span> 
                                    <p>46378291W</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Dirección actual</span> 
                                    <p>c/ Prueba de Texto, Nº 22</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Teléfono de contacto</span> 
                                    <p>663 345 312</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Correo electrónico</span> 
                                    <p>{{$user->email}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Profesión</span> 
                                    <p>Ingeniero Informático</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Cuenta creada</span> 
                                    <p>{{$user->created_at->format("d/m/Y")}} <span class="dot-separation">·</span> {{$user->created_at->diffForHumans()}}</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->id == $user->id)
        <div class="modal-footer">
            <h3>Opciones avanzadas</h3>
            <button class="btn-gray-basic" type="submit"  
                onclick="window.location='{{route('profileEdit.show')}}'">
                Editar datos
            </button>
        </div>
        @endif
    </div>
</div>
<!-- End 'Additional Info' modal-->