{{-- <p>{{$user->name}} es entrenado por</p>
<p>{{getTrainersNameByTrainerId($user->athlete->trainer_id)}}</p> --}}

<div class="box-container shadow-container">
    <div class="box-image">
        <img class="inner-shadow" src="/uploads/avatars/{{getTrainerByTrainerId($user->athlete->trainer_id)->user->user_image}}" alt="">
    </div>
    <div class="box-content">
        <p>Tu entrenador es</p>
        <p>{{getTrainersNameByTrainerId($user->athlete->trainer_id)}}</p>
    </div>
    <div class="box-container-buttons">
        <button class="soft-btn">Ver perfil</button>
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

    <div class="box-container-log shadow-container">
        <h2>Actividad reciente <span class="light">(Último mes)</span></h2>
        <div class="content">
            <ul>
                <li>
                    Oe
                </li>
                <li>
                    Oe
                </li>
                <li>
                    Oe
                </li>
                <li>
                    Oe
                </li>
            </ul>
        </div>
    </div>
</div>
