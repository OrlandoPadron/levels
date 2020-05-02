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
                @if(currentlyTrainingAthlete($user->athlete->id))
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
        <div class="container-dashboard" x-data="{openNewPlan: false}">
            <button class="btn-purple-basic"
                @click="openNewPlan=!openNewPlan" 
                @keydown.escape.window="openNewPlan=false"
                
            >Nuevo plan</button>
            {{-- @if (Request::get('a')==1)
                <p>Detalles generales</p>  
            @else
                <p>Planes entrenamiento</p>  
            @endif --}}
            
            @include('modals.newPlanModal')
            @if($trainingPlans->isNotEmpty() && currentlyTrainingAthlete($user->athlete->id))
                @foreach ($trainingPlans as $key => $plan)
                    <h1 class="underlined">{{$key+1 . ') \''}}{{$plan->title .'\''}}</h1>
                    <h3>Asociado a: {{$user->name . ' ' . $user->surname}}</h3>
                    <h3>Entrenado por: {{getTrainersName($user->id)}}</h3>
                    <h3>Descripción:</h3>
                    <p>{{$plan->description}}</p>
                    
                    <p>Formado por {{count($plan->macrocycles)}} macrociclos.</p>
                    <ul>
                        @foreach ($plan->macrocycles as $keyMacro => $macrocycle)
                            <li>{{$macrocycle->title}} -> el cual consta los siguientes mesociclos:
                                <ul>
                                    @foreach ($macrocycle->mesocycles as $keyMes=>$mesocycle)
                                        <li>Mesociclo #{{$keyMes + 1}} -> formado por los siguientes microciclos (semanas): 
                                            <ul>
                                                @foreach($mesocycle->microcycles as $microcycle)
                                                    <li>
                                                        {{$microcycle->title}} -> Número de sesiones = {{count($microcycle->sessions)}}
                                                    </li>
                                                @endforeach

                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            
                            </li>
                        @endforeach

                    </ul>


                @endforeach

            @endif
        </div>
    </div>

</div>


