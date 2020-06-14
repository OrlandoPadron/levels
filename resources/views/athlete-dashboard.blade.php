<div class="content-profile-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: '{{$tab}}', paymentSettings: false, addTutorshipSession: false,}">
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
                @if ($user->athlete->trainer_id != null)
                    @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                        <form action="{{route('stopTrainingThisAthlete')}}" method="POST">
                            @csrf
                            <input type="text" name="user_id" value="{{$user->id}}" hidden>
                            <button type="submit" class="btn-basic stop-training-button"><i class="fas fa-minus-circle"></i> Dejar de entrenar</button>
            
                        </form>
                    @endif
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
    @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))
        <!-- Start 'Navbar dashboard' -->
        <div class="navbar-dashboard">
            <div class="container-dashboard">
                <div class="navbar-dashboard-menu">
                    <ul>
                        <li x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                        <li x-on:click.prevent @click="sectionTab = 'plan'" :class="{'active-dashboard': sectionTab === 'plan'}"><a href="#">Plan entrenamiento</a></li>
                        <li x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                        <li x-on:click.prevent @click="sectionTab = 'tutorias'" :class="{'active-dashboard': sectionTab === 'tutorias'}"><a href="#">Tutorías</a></li>
                        <li x-on:click.prevent @click="sectionTab = 'cuotas'" :class="{'active-dashboard': sectionTab === 'cuotas'}"><a href="#">Cuotas</a></li>
                        <li x-on:click.prevent @click="sectionTab = 'cuenta'" :class="{'active-dashboard': sectionTab === 'cuenta'}"><a href="#">Cuenta</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End 'Navbar dashboard' -->
        <div class="content-dashboard">
            <div class="container-dashboard">
                <div x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
                    @include('sections_dashboard.general')
                </div>
                <div x-show.transition.in.opacity.duration.500ms="sectionTab === 'plan'">
                    @include('sections_dashboard.trainingPlans')
                </div>
                <div x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
                    @include('sections_dashboard.files')
                </div>
                <div x-show.transition.in.opacity.duration.500ms="sectionTab === 'tutorias'">
                    @include('sections_dashboard.tutorship')
                </div>
                <div x-show.transition.in.opacity.duration.500ms="sectionTab === 'cuotas'">
                    @include('sections_dashboard.payment')
                </div>
                <div x-show.transition.in.opacity.duration.500ms="sectionTab === 'cuenta'">
                    @include('sections_dashboard.account')
                </div>
            </div>
        </div>
    @else
        <div class="content-dashboard">
            <div class="container-dashboard">
                @include('page_messages.trainer_status_message')
            </div>
        </div>
    @endif

</div>


