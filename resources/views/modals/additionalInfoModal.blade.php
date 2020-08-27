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
                            trim($fullUserName);
                            $gender = $user->gender; 
                            
                            //Additional info
                            $additionalInfo = null;
                            if($user->additional_info != '{}'){
                                $decrypt = Crypt::decryptString($user->additional_info);
                                $additionalInfo = json_decode($decrypt, true);
                            }else{
                                $additionalInfo = json_decode($user->additional_info, true);
                            }
                            $birthday = isset($additionalInfo['additionalInfo']['birthday']) ? $additionalInfo['additionalInfo']['birthday'] : null;
                            $age = null;
                            if ($birthday != null){
                                $birthdayDateTime = new DateTime($birthday);
                                $age = $birthdayDateTime->diff(new DateTime())->y;
                            }
                            $dni = isset($additionalInfo['additionalInfo']['dni']) ? $additionalInfo['additionalInfo']['dni'] : 'Sin especificar';
                            $address = isset($additionalInfo['additionalInfo']['address']) ? $additionalInfo['additionalInfo']['address'] : 'Sin especificar';
                            $phone = isset($additionalInfo['additionalInfo']['phone']) ? $additionalInfo['additionalInfo']['phone'] : 'Sin especificar';
                            $occupation = isset($additionalInfo['additionalInfo']['occupation']) ? $additionalInfo['additionalInfo']['occupation'] : 'Sin especificar';
                                            
                        
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
                                    <p>{{
                                        $birthday != null ? 
                                            date("d/m/Y", strtotime($birthday))
                                            :
                                            'Sin especificar'
                                        }}
                                        @if($age != null)
                                        <span class="dot-separation low-emphasis">·</span><span  class="low-emphasis"> {{$age}} años</span>
                                        @endif 
                                    </p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Sexo</span>
                                    @switch($gender)
                                        @case('male')
                                            <p>Hombre</p>
                                            @break
                                        @case('female')
                                            <p>Mujer</p>
                                            @break
                                        @default
                                            <p>Sin especificar</p>
                                            @break
                                    @endswitch
                                </li>
                                <li>
                                    <span class="text-container-content-section">DNI</span> 
                                    <p>{{$dni}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Dirección actual</span> 
                                    <p>{{$address}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Teléfono de contacto</span> 
                                    <p>{{$phone}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Correo electrónico</span> 
                                    <p>{{$user->email}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Profesión</span> 
                                    <p>{{$occupation}}</p>
                                </li>
                                <li>
                                    <span class="text-container-content-section">Cuenta creada</span> 
                                    <p>{{$user->created_at->format("d/m/Y")}} <span class="dot-separation low-emphasis">·</span> <span class="low-emphasis">{{$user->created_at->diffForHumans()}}</span></p>
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