<div class="content-trainer-dashboard" x-data="{feeStatusModal: false}">
    <div class="container-dashboard">
        <h1 class="primary-blue-color"><i class="fas fa-dumbbell"></i> Panel de Entrenador</h1>
    </div>
    @include('modals.trainerPanelModals.feeStatusModal')
    <div class="boxes">
        <div class="box-container-notification shadow-container plan-notification">
            <div class="box-icon">
                <div class="box-icon-container">
                    <i style="font-size: 36px;" class="fas fa-running"></i>
                </div>
            </div>
            <div class="box-content">
                <p>Planes de entrenamiento</p>
                <p>Sin actividad reciente</p>
            </div>
        </div>
        <div class="box-container-notification shadow-container forum-notification">
            <div class="box-icon">
                <div class="box-icon-container">
                    <i class="fas fa-comment-alt"></i>
                </div>
            </div>
            <div class="box-content">
                <p>Foro personal</p>
                <p>prueasasdsdsdba</p>
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
                <p>prueba</p>
            </div>
        </div>
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
    </div>
    <div class="athletes-trainer-dashboard">
        <h2>Deportistas entrenados por ti <span class="light">({{count(Auth::user()->trainer->trained_by_me)}})</span></h2>
        <div class="athletes-trained-by-me">
            @foreach(collect(getArrayOfUsersTrainedByMe(Auth::user()->trainer->id))->sortBy('name') as $key => $user)
                <div class="athlete-component">
                    <a href="{{route("profile.show", [$user->id, 'general'])}}"><img class="inner-shadow" src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar"></a>
                    <p>{{$user->name. ' '. $user->surname}}</p>
                </div>
            @endforeach
        </div>
    </div>

</div>