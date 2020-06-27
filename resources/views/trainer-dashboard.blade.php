<div class="content-trainer-dashboard">
    <div class="container-dashboard">
        <h1 class="primary-blue-color"><i class="fas fa-dumbbell"></i> Panel de Entrenador</h1>
    </div>

    <div class="boxes">
        <div class="box-item-container shadow-container">
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-stopwatch"></i>
            <p class="boxes-message-status">Sesiones completadas</p>
        </div>
        <div class="box-item-container shadow-container">
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-comment-alt"></i>
            <p class="boxes-message-status">Revisar actividad foros deportistas</p>
        </div>
        <div class="box-item-container shadow-container">

            <div class="relative-container">
                <i class="fas fa-users"></i>
            </div>
            <div class="buble-notification">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-comment-alt"></i>
            <p class="boxes-message-status">Revisar actividad foros grupales</p>
        </div>
        <div class="box-item-container shadow-container">
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-euro-sign"></i>
            <p class="boxes-message-status">Revisar cuota de Junio</p>
        </div>
        {{-- <div class="box-item-container shadow-container">
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-euro-sign"></i>
            <p class="boxes-message-status">Revisar cuota de Junio</p>
            
        </div> --}}
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