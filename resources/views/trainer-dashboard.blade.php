<div class="content-trainer-dashboard" x-data="{planStatusModal:false, forumStatusModal: false, feeStatusModal: false, groupForumStatusModal:false}">
    <div class="container-dashboard">
        <h1 class="primary-blue-color"><i class="fas fa-dumbbell"></i> Panel de Entrenador</h1>
    </div>
    @include('modals.trainerPanelModals.feeStatusModal')
    @include('modals.trainerPanelModals.trainingPlanStatusModal')
    @include('modals.trainerPanelModals.forumStatusModal')
    @include('modals.trainerPanelModals.groupForumStatusModal')
    <div class="boxes">
        <div class="box-container-notification shadow-container plan-notification"
                @click="planStatusModal=!planStatusModal" 
                @keydown.escape.window="planStatusModal=false">
            <div class="box-icon">
                <div class="box-icon-container">
                    <i style="font-size: 36px;" class="fas fa-running"></i>
                </div>
            </div>
            <div class="box-content">
                <p class="notification_status">Planes de entrenamiento
                    @if($notifications['trainingPlansUpdates']['totalChanges'] == 0)
                    <i class="fas fa-check-circle"></i>
                    @endif
                </p>
                <p>{{$notifications['trainingPlansUpdates']['totalChanges'] > 0 ? 
                    ($notifications['trainingPlansUpdates']['totalChanges'] == 1 ? 
                      '1 cambio pendiente' : $notifications['trainingPlansUpdates']['totalChanges'] . ' cambios pendientes' ) 
                    : 'Sin actividad reciente'}}</p>
            </div>
        </div>
        <div class="box-container-notification shadow-container forum-notification"
                @click="forumStatusModal=!forumStatusModal" 
                @keydown.escape.window="forumStatusModal=false">
            <div class="box-icon">
                <div class="box-icon-container">
                    <i class="fas fa-comment-alt"></i>
                </div>
            </div>
            <div class="box-content">
                <p class="notification_status">Foros de deportistas 
                    @if($notifications['athletesThreads']['totalChanges'] == 0)
                    <i class="fas fa-check-circle"></i>
                    @endif</p>
                <p>{{$notifications['athletesThreads']['totalChanges'] > 0 ? 
                    ($notifications['athletesThreads']['totalChanges'] == 1 ? 
                      '1 respuesta nueva' : $notifications['athletesThreads']['totalChanges'] . ' respuestas nuevas' ) 
                    : 'Sin actividad reciente'}}</p>
            </div>
        </div>
        <div class="box-container-notification shadow-container forumgroup-notification"
            @click="groupForumStatusModal=!groupForumStatusModal" 
            @keydown.escape.window="groupForumStatusModal=false">
            <div class="box-icon">
                <div class="box-icon-container">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="box-content">
                <p class="notification_status">Foros grupales 
                    @if($notifications['gThreads']['totalNumOfNewChanges'] == 0)
                    <i class="fas fa-check-circle"></i>
                    @endif</p>
                <p>{{$notifications['gThreads']['totalNumOfNewChanges'] > 0 ? 
                    ($notifications['gThreads']['totalNumOfNewChanges'] == 1 ? 
                      '1 respuesta nueva' : $notifications['gThreads']['totalNumOfNewChanges'] . ' respuestas nuevas' ) 
                    : 'Sin actividad reciente'}}</p>
            </div>
        </div>
        <div class="box-container-notification shadow-container payment-notification"
                @click="feeStatusModal=!feeStatusModal" 
                @keydown.escape.window="feeStatusModal=false">
            <div class="box-icon">
                <div class="box-icon-container">
                    <i style="margin-left:-5px;" class="fas fa-euro-sign"></i>
                </div>
            </div>
            <div class="box-content">
                <p class="notification_status">
                    Estado del mes ({{ucfirst(Date::now()->format('F'))}})
                    @if($notifications['athletesHaventPaid']->count() == 0)
                    <i class="fas fa-check-circle"></i>
                    @endif
                </p>
                <p>{{$notifications['athletesHaventPaid']->count() > 0 ? 
                    ($notifications['athletesHaventPaid']->count() == 1 ? 
                      '1 deportista pendiente' : $notifications['athletesHaventPaid']->count() . ' deportistas pendientes' ) 
                    : 'Ningún pago pendiente'}}
                </p>
            </div>
        </div>
    </div>
    @php
        $numOfAthletesTrainedByMe = count(Auth::user()->trainer->trained_by_me);
    @endphp
        <div class="athletes-trainer-dashboard">
            @if($numOfAthletesTrainedByMe > 0)
            <h2>Deportistas entrenados por ti <span class="light">({{$numOfAthletesTrainedByMe}})</span></h2>
            <div class="athletes-trained-by-me">
                @foreach(collect(getArrayOfUsersTrainedByMe())->sortBy('name') as $key => $user)
                    <div class="athlete-component">
                        <a href="{{route("profile.show", [$user->id, 'general'])}}"><img class="inner-shadow" src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar"></a>
                        <p>{{$user->name. ' '. $user->surname}}</p>
                    </div>
                @endforeach
            </div>
            @else
            @include('page_messages.no_athletes_to_train_message')
            @endif
        </div>

</div>