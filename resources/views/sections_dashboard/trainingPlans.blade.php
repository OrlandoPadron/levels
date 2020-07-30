<div class="heading-section">
    @if ($user->account_activated == 1 && (Auth::user()->isTrainer))
    <button class="btn-add-basic button-position"
                    @click="openNewPlan=!openNewPlan" 
                    @keydown.escape.window="openNewPlan=false">
                    <i class="fas fa-plus"></i>Nuevo plan
    </button>
    @endif
    <h1 class="primary-blue-color">Planes de entrenamiento</h1>
</div>
@if(Auth::user()->isTrainer)
@include('modals.newPlanModal')
@endif
{{-- && currentlyTrainingAthlete($user->athlete->id) --}}
@if($trainingPlans->isNotEmpty())
    <!-- Box training details -->
    @foreach ($trainingPlans->filter(function ($plan){
        if ($plan->status == 'active') return $plan;
    }) as $key => $plan)
    <div class="alpine-container" x-data="{addFileToPlan{{$plan->id}}: false, editPlan:false}">
        @include('modals.addFileToTrainingPlanModal', ["plan" => $plan])
        @include('modals.editPlanModal', ["plan" => $plan])

        <div class="trainingPlan-container shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
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
                <button 
                @click="addFileToPlan{{$plan->id}}=!addFileToPlan{{$plan->id}}" 
                @keydown.escape.window="addFileToPlan{{$plan->id}}=false"
                class="btn-purple-basic">Ver archivos</button>
                @if(Auth::user()->isTrainer && iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                <button 
                @click="editPlan=!editPlan"
                @keydown.escape.window="editPlan=false"
                class="btn-gray-basic">Editar plan</button>
                <form action="{{route('trainingPlan.destroy')}}" method="POST">
                    @csrf
                    <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
                    <input type="text" value="{{$user->id}}" name="user_id" hidden>
                    <button class="btn-red-basic">Eliminar</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    @endforeach
    <!-- Ends Box training details -->
@else
    @include('page_messages.training_plans_not_available_message')   
@endif
        