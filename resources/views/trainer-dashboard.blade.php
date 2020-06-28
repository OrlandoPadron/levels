<div class="content-trainer-dashboard">
    <div class="container-dashboard">
        <h1 class="primary-blue-color"><i class="fas fa-dumbbell"></i> Panel de Entrenador</h1>
    </div>

    <div class="boxes">
        <div class="box-item-container shadow-container" style="color: #136ebb;" >
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-stopwatch"></i>
            <p class="boxes-message-status">Sesiones completadas</p>
        </div>
        <div class="box-item-container shadow-container" style="color: #6013bb;" >
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-comment-alt"></i>
            <p class="boxes-message-status">Foros deportistas</p>
        </div>
        <div class="box-item-container shadow-container" style="color: #bb6013;">

            <div class="relative-container">
                <i class="fas fa-users"></i>
            </div>
            <div class="buble-notification">
                <div class="bubble-circle" >
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-comment-alt"></i>
            <p class="boxes-message-status">Foros grupales</p>
        </div>
        <div class="box-item-container shadow-container" style="color: #6ebb13;">
            <div class="buble-notification bubble-fix">
                <div class="bubble-circle">
                    <p id="#notification">1</p>
                </div>
            </div>
            <i class="fas fa-euro-sign"></i>
            <p class="boxes-message-status">Cuota de {{ucfirst(Date::now()->format('F'))}}</p>
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

    <div class="trainer-log">
        <h2>Actividad reciente <span class="light">(Último mes)</span></h2>
        <div class="trainer-log-container shadow-container">
            <ul class="trainer-log-list">
                <li>
                    <div class="trainer-log-element">
                        <div class="log-element-user">
                            <img class="inner-shadow" src="/uploads/avatars/{{Auth::user()->user_image}}" alt="profile-avatar">
                            <div class="log-element-user-message">
                                <p>Orlando Padrón ha subido un nuevo fichero</p>
                                <p>Hace dos minutos</p>
                            </div>
                        </div>
                        <div class="log-element-button">
                            <button class="soft-btn">Ver detalles</button>
                        </div>
                        
                    </div>
                </li>
                <li>
                    <div class="trainer-log-element">
                        <div class="log-element-user">
                            <img class="inner-shadow" src="/uploads/avatars/{{Auth::user()->user_image}}" alt="profile-avatar">
                            <div class="log-element-user-message">
                                <p>Orlando Padrón ha subido un nuevo fichero</p>
                                <p>Hace dos minutos</p>
                            </div>
                        </div>
                        <div class="log-element-button">
                            <button class="soft-btn">Ver detalles</button>
                        </div>
                        
                    </div>
                </li>
                <li>
                    <div class="trainer-log-element">
                        <div class="log-element-user">
                            <img class="inner-shadow" src="/uploads/avatars/{{Auth::user()->user_image}}" alt="profile-avatar">
                            <div class="log-element-user-message">
                                <p>Orlando Padrón ha subido un nuevo fichero</p>
                                <p>Hace dos minutos</p>
                            </div>
                        </div>
                        <div class="log-element-button">
                            <button class="soft-btn">Ver detalles</button>
                        </div>
                        
                    </div>
                </li>
                <li>
                    <div class="trainer-log-element">
                        <div class="log-element-user">
                            <img class="inner-shadow" src="/uploads/avatars/{{Auth::user()->user_image}}" alt="profile-avatar">
                            <div class="log-element-user-message">
                                <p>Orlando Padrón ha subido un nuevo fichero</p>
                                <p>Hace dos minutos</p>
                            </div>
                        </div>
                        <div class="log-element-button">
                            <button class="soft-btn">Ver detalles</button>
                        </div>
                        
                    </div>
                </li>
                
            </ul>
        </div>
    </div>

</div>