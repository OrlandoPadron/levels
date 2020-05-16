<div class="heading-plan">
    <button class="btn-add-basic button-position"
                    @click="openNewPlan=!openNewPlan" 
                    @keydown.escape.window="openNewPlan=false"
                    
                ><i class="fas fa-plus"></i>Nuevo plan
    </button>
    <h1 class="primary-blue-color">Planes de entrenamiento</h1>

</div>

@include('modals.newPlanModal')
@if($trainingPlans->isNotEmpty() && currentlyTrainingAthlete($user->athlete->id))
    <!-- Box training details -->
    @foreach ($trainingPlans as $key => $plan)
        <div class="trainingPlan-container shadow-container ">
            <div class="trainingPlan-status">
                <div class="info-trainingPlan-status">
                    <p class="title-plan bold">'{{$plan->title}}'</p>
                    <p class="duration-plan">Marzo 2020 — Diciembre 2020</p>
                    <p class="status-plan"><i class="fas fa-check-circle"></i>Estado: <span class="status-plan-active">{{$plan->status == 'active' ? 'Activo' : 'Finalizado'}}</span></p>
                </div>
                
            </div>
            <div class="trainingPlan-description">
                <div class="separation-plan"></div>
                <div class="trainingPlan-text">
                    <p class="title-description bold">Descripción del entrenamiento</p>
                    <p>{{$plan->description}}</p>

                </div>
            </div>
            <div class="trainingPlan-options">
                <button class="btn-purple-basic">Ver más detalles</button>
                <form action="{{route('trainingPlan.destroy')}}" method="POST">
                    @csrf
                    <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
                    <input type="text" value="{{$user->id}}" name="user_id" hidden>
                    <button class="btn-gray-basic">Eliminar</button>
                </form>
            </div>
        </div>
    @endforeach
    <!-- Ends Box training details -->
@else
    <p>Actualmente este usuario no dispone de planes de entrenamiento.</p>         
@endif
            {{-- @if($trainingPlans->isNotEmpty() && currentlyTrainingAthlete($user->athlete->id))
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

            @endif --}}