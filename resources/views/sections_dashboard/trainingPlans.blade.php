<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                    @click="openNewPlan=!openNewPlan" 
                    @keydown.escape.window="openNewPlan=false"
                    
                ><i class="fas fa-plus"></i>Nuevo plan
    </button>
    @endif
    <h1 class="primary-blue-color">Planes de entrenamiento</h1>
    @if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
    
    @endif
</div>

@include('modals.newPlanModal')
{{-- && currentlyTrainingAthlete($user->athlete->id) --}}
@if($trainingPlans->isNotEmpty())
    <!-- Box training details -->
    @foreach ($trainingPlans as $key => $plan)
    <progress value="0" max="100" id="uploader-plan">0%</progress>
    <input id="plan-upload" name="fileuploaded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
    <button onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'AddFileToTrainingPlan', {planId:{{$plan->id}}})">Subir</button>
        <div class="trainingPlan-container shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}} ">
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
                <button onclick=""class="btn-purple-basic">Ver más detalles</button>
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
    @include('page_messages.training_plans_not_available_message')   
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