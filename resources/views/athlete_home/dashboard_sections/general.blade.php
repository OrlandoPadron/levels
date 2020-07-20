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
            <button class="soft-btn">Ver perfil</button>
        @endif
    </div>
</div>
<div class="general-dashboard-athlete">
    <div class="box-container-notification shadow-container forum-notification">
        <div class="box-icon">
            <div class="box-icon-container">
                <i class="fas fa-comment-alt"></i>
            </div>
        </div>
        <div class="box-content">
            <p>Foro personal</p>
            <p>3 nuevas respuestas</p>
        </div>
    </div>
    <div class="box-container-notification shadow-container forumgroup-notification">
        <div class="box-icon">
            <div class="box-icon-container">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="box-content">
            <p>Foros grupales</p>
            <p>3 nuevas respuestas</p>
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