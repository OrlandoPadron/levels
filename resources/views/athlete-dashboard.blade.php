<div class="content-profile-dashboard">
    <div class="container-dashboard">
        <div class="userinfo" x-data="{openShowProfileData: false}">
            <img src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard">
                <p id="user_name_dashboard">{{$user->name .' '. $user->surname}}</p>
                <label id="user_type">{{$user->isTrainer == 0 ? 'Deportista' : 'Entrenador'}}</label>
                <button class="btn-purple-basic"
                @click="openShowProfileData=!openShowProfileData" 
                @keydown.escape.window="openShowProfileData=false"
                >Información adicional</button>
                @if(currentlyTrainingAthlete($user->id))
                    <form action="{{route('stopTrainingThisAthlete')}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn-basic train-button">Dejar de entrenar</button>
                    </form>
                @else
                    <form action="{{route('trainUser')}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn-basic train-button">Entrenar</button>
                    </form>
                @endif
                
                
            </div>
                <!-- 'Información adicional' modal-->
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
                <!-- End 'Ver datos personales' modal-->
        </div>

    </div>
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul>
                    <li class="active-dashboard"><a href="?tab=general">Detalles generales</a></li>
                    <li class=""><a href="?tab=training_plan">Plan entrenamiento</a></li>
                </ul>
            </div>
        </div>

    </div>
    
    <div class="content-dashboard">
        <div class="container-dashboard" x-data="{open1: false}">
            <button class="btn-purple-basic"
                @click="open1=!open1" 
                @keydown.escape.window="open1=false"
                
            >Abrir modal</button>
            {{-- @if (Request::get('a')==1)
                <p>Detalles generales</p>  
            @else
                <p>Planes entrenamiento</p>  
            @endif --}}
            
            <!-- Modals -->
            <div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="open1">

                <!-- Modal content -->
                <div class="modal-content" @click.away="open1=false">
                    <div class="modal-header">
                        <span class="close" @click="open=!open">&times;</span>
                        <h2>Modal Header</h2>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the Modal Body</p>
                        <p>Some other text...</p>
                        

                    </div>
                    <div class="modal-footer">
                        <h3>Modal Footer</h3>
                    </div>
                </div>
            
            </div>

        </div>
    </div>

</div>


