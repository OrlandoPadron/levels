<div class="box-container shadow-container">
    <div class="box-image">
        <img class="inner-shadow" src="/uploads/avatars/{{$user->athlete->trainer_id != null ? getTrainerByTrainerId($user->athlete->trainer_id)->user->user_image : 'default_avatar.jpg'}}" alt="">
    </div>
    <div class="box-content">
        <p>{{$user->athlete->trainer_id != null ? 'Tu entrenador es': ''}}</p>
        <p>{{$user->athlete->trainer_id != null ? getTrainersNameByTrainerId($user->athlete->trainer_id) : 'Sin entrenador actualmente'}}</p>
    </div>
    <div class="box-container-buttons">
        @if($user->athlete->trainer_id != null)
            <button class="soft-btn" onclick="window.location = '{{route('profile.show', [getUserIdByTrainerId(Auth::user()->athlete->trainer_id), "general"])}}'">Ver perfil</button>
        @endif
    </div>
</div>
<div class="general-dashboard-athlete">
    <div class="box-container-notification shadow-container plan-notification hover-scale"
    onclick="changeUrlParameters('plan')" @click="sectionTab = 'plan'">
        <div class="box-icon">
            <div class="box-icon-container">
                <i style="font-size: 36px;" class="fas fa-running"></i>
            </div>
        </div>
        <div class="box-content">
            <p class="notification_status">Plan de entrenamiento
                @if($notifications['trainingPlansUpdates']['totalChanges'] == 0)
                    <i class="fas fa-check-circle"></i>
                @endif
            </p>
            <p>{{$notifications['trainingPlansUpdates']['totalChanges'] > 0 ? 
                ($notifications['trainingPlansUpdates']['totalChanges'] == 1 ? 
                  '1 cambio pendiente' : $notifications['trainingPlansUpdates']['totalChanges'] . ' cambios pendientes' ) 
                : 'Sin actividad reciente'}}
            </p>
        </div>
    </div>
    <div class="box-container-notification shadow-container forum-notification hover-scale"
    onclick="changeUrlParameters('foro')" @click="sectionTab = 'foro'">
        <div class="box-icon">
            <div class="box-icon-container">
                <i class="fas fa-comment-alt"></i>
            </div>
        </div>
        <div class="box-content">
            <p class="notification_status">Foro personal
                @if($notifications['threads']['totalNumOfNewChanges'] == 0)
                    <i class="fas fa-check-circle"></i>
                @endif
            </p>
            <p>{{$notifications['threads']['totalNumOfNewChanges'] > 0 ? 
                ($notifications['threads']['totalNumOfNewChanges'] == 1 ? 
                  '1 respuesta nueva' : $notifications['threads']['totalNumOfNewChanges'] . ' respuestas nuevas' ) 
                : 'Sin actividad reciente'}}
            </p>
        </div>
    </div>
    <div class="box-container-notification shadow-container forumgroup-notification hover-scale"
            @click="groupForumStatusModal=!groupForumStatusModal" 
            @keydown.escape.window="groupForumStatusModal=false">
        <div class="box-icon">
            <div class="box-icon-container">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="box-content">
            <p class="notification_status">Foros grupales
                @if($notifications['gthreads']['totalNumOfNewChanges'] == 0)
                    <i class="fas fa-check-circle"></i>
                @endif
            </p>
            <p>{{$notifications['gthreads']['totalNumOfNewChanges'] > 0 ? 
                ($notifications['gthreads']['totalNumOfNewChanges'] == 1 ? 
                  '1 respuesta nueva' : $notifications['gthreads']['totalNumOfNewChanges'] . ' respuestas nuevas' ) 
                : 'Sin actividad reciente'}}</p>
        </div>
    </div>
    @if ($user->athlete->monthPaid)
    <div class="box-container-notification shadow-container payment-notification">
        <div class="box-icon">
            <div class="box-icon-container">
                <i style="margin-left:-5px;" class="fas fa-euro-sign"></i>
            </div>
        </div>
        <div class="box-content">
            <p>Estado mes {{ucfirst(Date::now()->format('F'))}}</p>
            <p>Pagado</p>
        </div>
    </div>
    @endif

    <div class="box-container-log shadow-container">
        <h2>Actividad reciente <span class="light">(Últimos 30 días)</span></h2>
        <div class="content">
            @if (getLoggedInUserLog()->count() > 0)
                <ul>
                @foreach(getLoggedInUserLog()->sortByDesc('created_at') as $key => $log)
                    <li>
                        <div class="log-item">
                            <img class="inner-shadow" src="/uploads/avatars/{{$log->user->user_image}}" alt="profile-avatar">
                            <div class="log-details">
                                <p>{!!$log->author_id == Auth::user()->id ? 'Has ' . $log->action : getName($log->author_id) . ' ha ' . $log->action!!}</p>
                                <p>{{ucfirst($log->created_at->diffForHumans())}}</p>
                            </div>
                            <div class="log-buttons">
                                <button 
                                onclick="changeUrlParameters('{{$log->tab}}')" 
                                x-on:click.prevent @click="sectionTab = '{{$log->tab}}'" 
                                :class="{'active-dashboard': sectionTab === '{{$log->tab}}'}"
                                class="soft-btn">Ver sección</button>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
            @else
                <p class="no-activity">
                    Sin actividad reciente
                </p>
            @endif
        </div>
    </div>
</div>