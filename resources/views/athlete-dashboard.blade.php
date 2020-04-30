<div class="content-profile-dashboard">
    <div class="container-dashboard">
        <div class="userinfo">
            <img src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard">
                <p id="user_name_dashboard">{{$user->name .' '. $user->surname}}</p>
                <label id="user_type">{{$user->isTrainer == 0 ? 'Deportista' : 'Entrenador'}}</label>
                <button class="btn-purple-basic">Ver datos personales</button>
                @if(currentlyTrainingAthlete($user->id))
                    <form action="{{route('stopTrainingThisAthlete')}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn-basic train-button">Dejar de entrenar</button>
                    </form>
                @else
                    <form action="{{route('trainUser')}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn-basic train-button">Entrenar</button>
                    </form>
                @endif
                
                
            </div>
    
        </div>

    </div>
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul>
                    <li class="active-dashboard"><a href="?tab=general">Detalles generales</a></li>
                    <li class=""><a href="?tab=training_plan">Plan entrenamiento</a></li>
                </ul>
            </div>
        </div>

    </div>

    <div class="content-dashboard">
        <div class="container-dashboard">
            @if (Request::get('a')==1)
                <p>Detalles generales</p>  
            @else
                <p>Planes entrenamiento</p>  
            @endif
        </div>
    </div>

</div>


