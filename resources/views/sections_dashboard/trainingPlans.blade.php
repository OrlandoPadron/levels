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
    @if ($trainingPlans->filter(function ($plan){
    if ($plan->status == 'active') return $plan;
    })->count() > 0)
    <h2 class="primary-blue-color heading-text-container">Planes activos</h2>
    <!-- Box training details -->
    @foreach ($trainingPlans->filter(function ($plan){
        if ($plan->status == 'active') return $plan;
    })->sortByDesc('created_at') as $key => $plan)
    <div class="alpine-container" x-data="{addFileToPlan: false, editPlan:false, showFilesAssociated:true}" {!!$loop->last ? 'style=margin-bottom:80px;' : ''!!}>
        @include('modals.addFileToTrainingPlanModal', ["plan" => $plan])
        @include('modals.editPlanModal', ["plan" => $plan])
        @include('modals.filesAssociatedWithTrainingPlanModal', ["plan" => $plan])

        <div class="trainingPlan-container shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
            <div class="trainingPlan-status">
                <div class="info-trainingPlan-status">
                    <p class="title-plan bold">'{{$plan->title}}'</p>
                    <p class="duration-plan">{{$plan->start_date->format("d/m/Y")}} — {{$plan->end_date->format("d/m/Y")}}</p>
                <p class="status-plan"><i class="fas fa-check-circle"></i>Estado: <span class="status-plan-{{$plan->status == 'active' ? 'active' : 'finished'}}">{{$plan->status == 'active' ? 'Activo' : 'Finalizado'}}</span></p>
                </div>
                
            </div>
            <div class="trainingPlan-description">
                <div class="separation-plan"></div>
                <div class="trainingPlan-text">
                    <p class="title-description bold">Descripción del entrenamiento</p>
                    <p>{{$plan->description == null ? 'Plan sin descripción' : $plan->description}}</p>
                </div>
            </div>
            <div class="trainingPlan-options">
                <button 
                @click="addFileToPlan=!addFileToPlan" 
                @keydown.escape.window="addFileToPlan=false"
                class="btn-purple-basic">Ver archivos</button>
                @if(Auth::user()->isTrainer && iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                <button 
                @click="editPlan=!editPlan"
                @keydown.escape.window="editPlan=false"
                class="btn-gray-basic">Gestionar plan</button>
                @endif
            </div>
        </div>
    </div>

    @endforeach
    @endif
    <!-- Ends Box training details -->
    @if ($trainingPlans->filter(function ($plan){
        if ($plan->status == 'finished') return $plan;
    })->count() > 0)
    <h2 class="primary-blue-color heading-text-container">Planes finalizados</h2>
    <!-- Finished training plans -->
    @foreach ($trainingPlans->filter(function ($plan){
        if ($plan->status == 'finished') return $plan;
    })->sortByDesc('created_at') as $key => $plan)
    <div class="alpine-container" x-data="{addFileToPlan: false, editPlan:false, showFilesAssociated:false}">
        @include('modals.addFileToTrainingPlanModal', ["plan" => $plan])
        @include('modals.editPlanModal', ["plan" => $plan])
        @include('modals.filesAssociatedWithTrainingPlanModal', ["plan" => $plan])

        <div class="trainingPlan-container shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
            <div class="trainingPlan-status">
                <div class="info-trainingPlan-status">
                    <p class="title-plan bold">'{{$plan->title}}'</p>
                    <p class="duration-plan">{{$plan->start_date->format("d/m/Y")}} — {{$plan->end_date->format("d/m/Y")}}</p>
                    <p class="status-plan"><i class="fas fa-check-circle"></i>Estado: <span class="status-plan-finished">{{$plan->status == 'active' ? 'Activo' : 'Finalizado'}}</span></p>
                </div>
                
            </div>
            <div class="trainingPlan-description">
                <div class="separation-plan"></div>
                <div class="trainingPlan-text">
                    <p class="title-description bold">Descripción del entrenamiento</p>
                    <p>{{$plan->description == null ? 'Plan sin descripción' : $plan->description}}</p>
                
                </div>
            </div>
            <div class="trainingPlan-options">
                <button 
                @click="addFileToPlan=!addFileToPlan" 
                @keydown.escape.window="addFileToPlan=false"
                class="btn-purple-basic">Ver archivos</button>
                @if(Auth::user()->isTrainer && iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                <button 
                @click="editPlan=!editPlan"
                @keydown.escape.window="editPlan=false"
                class="btn-gray-basic">Gestionar plan</button>
                @endif
            </div>
        </div>
    </div>

    @endforeach

    <!-- Ends finished training plans -->
    @endif
@else
    @include('page_messages.training_plans_not_available_message')   
@endif
        