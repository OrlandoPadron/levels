<div class="content-profile-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: 'General'}">
    <div class="container-dashboard">
        <div class="userinfo">
            <img src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard">
                <p id="user_name_dashboard" class="primary-blue-color">{{$user->name .' '. $user->surname}}</p>
                <label id="user_type" class="primary-blue-color">{{$user->isTrainer == 0 ? 'Deportista' : 'Entrenador'}}</label>
                <button class="btn-purple-basic"
                @click="openShowProfileData=!openShowProfileData" 
                @keydown.escape.window="openShowProfileData=false"
                >Información adicional</button>
                @if(currentlyTrainingAthlete($user->athlete->id))
                    <form action="{{route('stopTrainingThisAthlete')}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn-basic stop-training-button"><i class="fas fa-minus-circle"></i> Dejar de entrenar</button>
        
                    </form>
                @else
                    <form action="{{route('trainUser')}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{$user->id}}" hidden>
                        <button type="submit" class="btn-basic train-button"><i class="fas fa-stopwatch"></i> Entrenar</button>
                    </form>
                @endif
            </div>
                @include('modals.additionalInfoModal')
        </div>
    </div>
    <!-- Start 'Navbar dashboard' -->
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul>
                    <li x-on:click.prevent @click="sectionTab = 'General'" :class="{'active-dashboard': sectionTab === 'General'}"><a href="#">Detalles generales</a></li>
                    <li x-on:click.prevent @click="sectionTab = 'Plan'" :class="{'active-dashboard': sectionTab === 'Plan'}"><a href="#">Plan entrenamiento</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->

    <div class="content-dashboard">
        <div class="container-dashboard">
            <div x-show="sectionTab === 'General'">
                <p>Detalles generales</p>
            </div>
            <div x-show="sectionTab === 'Plan'">
                @include('sections_dashboard.trainingPlans')
            </div>
        </div>
    </div>

</div>


