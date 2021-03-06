@section('head')
<!-- Firebase Scripts -->
@include('scripts.firebaseScripts')
@endsection
@php
    $numOfPlansUpdated= numOfPlansAssociatedWithUserIHaventSeen($user->id, $notifications['trainingPlansUpdates']);
    
    //Additional info
    $additionalInfo = null;
    if($user->additional_info != '{}'){
        $decrypt = Crypt::decryptString($user->additional_info);
        $additionalInfo = json_decode($decrypt, true);
    }else{
        $additionalInfo = json_decode($user->additional_info, true);
    }
    if(isset($additionalInfo['thirdParties'])){
        foreach($additionalInfo['thirdParties'] as $key => $value) {
            if(empty($value)) unset($additionalInfo['thirdParties'][$key]); 
        }        
    }

@endphp
<div class="content-profile-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: '{{$tab}}', paymentSettings: false, addTutorshipSession: false, openNewThreadForm:false, uploadFile:false, shareFile:false}">
    <div class="container-dashboard">
        <div class="userinfo">
            <img class="inner-shadow" src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard 
                {{$user->athlete->trainer_id != null ? 
                (iAmcurrentlyTrainingThisAthlete($user->athlete->id) ? '' : 'no-additional-info')
                : 
                ''}}
                ">
                <p id="user_name_dashboard" class="primary-blue-color">{{$user->name .' '. $user->surname}}</p>
                <div class="text-info-user-type">
                    <label id="user_type" class="primary-blue-color">{{$user->isTrainer == 0 ? 'Deportista' : 'Entrenador'}}</label>
                    @if (isset($additionalInfo['thirdParties']) && count($additionalInfo['thirdParties']) >= 1)
                        <div class="athlete-accounts-links">
                            @foreach($additionalInfo['thirdParties'] as $service => $url)
                                <a href="{{$url}}" target="_blank">{{ucfirst($service)}}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div id="user-dashboard-buttons-container" style="
                    {{$user->athlete->trainer_id != null ? 
                    (iAmcurrentlyTrainingThisAthlete($user->athlete->id) ? '' : 'margin-top:0px;')
                    : 
                    ''}}">
                    @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))

                    <button class="btn-purple-basic"
                    @click="openShowProfileData=!openShowProfileData" 
                    @keydown.escape.window="openShowProfileData=false"
                    >Información adicional</button>
                    @endif

                    @if ($user->athlete->trainer_id != null)
                        @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                            <form action="{{route('stopTrainingThisAthlete')}}" method="POST">
                                @csrf
                                <button type="submit" class="soft-btn stop-training"><i class="fas fa-ban"></i> Dejar de entrenar</button>
                                <input type="text" name="user_id" value="{{$user->id}}" hidden>
                
                            </form>
                        @endif
                    @else
                        <form action="{{route('trainUser')}}" method="POST">
                            @csrf
                            <input type="text" name="user_id" value="{{$user->id}}" hidden>
                            <button type="submit" class="soft-btn start-training"><i class="fas fa-dumbbell"></i> Entrenar</button>
                        </form>
                    @endif

                </div>

            </div>
            @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                @include('modals.additionalInfoModal')
            @endif
        </div>
    </div>
    @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))
        <!-- Start 'Navbar dashboard' -->
        <div class="navbar-dashboard">
            <div class="container-dashboard">
                <div class="navbar-dashboard-menu">
                    <ul id="navbar-dashboard-items">
                        <li id="general-navbar" onclick="changeUrlParameters('general')" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                        <li id="plan-navbar" onclick="changeUrlParameters('plan')" x-on:click.prevent @click="sectionTab = 'plan'" :class="{'active-dashboard': sectionTab === 'plan'}">
                            @if ($numOfPlansUpdated > 0)
                            <div class="notification-indicator"></div>
                            @endif
                            <a href="#">Planes de entrenamiento</a>
                        </li>
                        <li id="foro-navbar" onclick="changeUrlParameters('foro')" x-on:click.prevent @click="sectionTab = 'foro'" :class="{'active-dashboard': sectionTab === 'foro'}">
                            @if ($notifications['threads']['totalNumOfNewChanges'] > 0)
                            <div class="notification-indicator"></div>
                            @endif
                            <a href="#">Foro</a>
                        </li>
                        <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                        <li id="tutorias-navbar" onclick="changeUrlParameters('tutorias')" x-on:click.prevent @click="sectionTab = 'tutorias'" :class="{'active-dashboard': sectionTab === 'tutorias'}"><a href="#">Tutorías</a></li>
                        <li id="cuotas-navbar" onclick="changeUrlParameters('cuotas')" x-on:click.prevent @click="sectionTab = 'cuotas'" :class="{'active-dashboard': sectionTab === 'cuotas'}"><a href="#">Cuotas</a></li>
                        <li id="muro-navbar" onclick="changeUrlParameters('muro')" x-on:click.prevent @click="sectionTab = 'muro'" :class="{'active-dashboard': sectionTab === 'muro'}"><a href="#">Muro</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End 'Navbar dashboard' -->
        
        <div class="content-dashboard">
            <div id="container-dashboard" class="container-dashboard">
                <div id="general-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else
                        @include('sections_dashboard.general')
                    @endif
                </div>
                <div id="plan-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'plan'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else
                        @include('sections_dashboard.trainingPlans')
                    @endif
                </div>
                <div id="foro-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'foro'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else
                        @if(Request::get('thread_view') == 0)
                            @include('common_sections.forum')
                        @else
                        @include('sections_dashboard.thread')
                        @endif
                    @endif
                </div>
                <div id="archivos-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else
                        @include('sections_dashboard.files')
                    @endif                        
                </div>
                <div id="tutorias-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'tutorias'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else
                        @include('sections_dashboard.tutorship')
                    @endif
                </div>
                <div id="cuotas-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'cuotas'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else   
                        @include('sections_dashboard.payment')
                    @endif                        
                </div>
                <div id="plan-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'muro'">
                    @if ($user->account_activated==0)
                        @include('page_messages.account_deactivated_message')
                    @else
                        @include('sections_dashboard.myWall')
                    @endif
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


<script>
    var oldUrl = window.location.href; 
    const regexGetPageSection = /([^\/]+$)/g;
    
    window.onpopstate= function(event){
        if (event.state['section'] !== null){
            var section = "#"+event.state['section'];
            var sectionContainer = "-section-container";
            console.log(section.concat(sectionContainer));
            $("#container-dashboard").children().hide();
            $("#navbar-dashboard-items").children().removeClass('active-dashboard');
            $(section.concat("-navbar")).addClass('active-dashboard');
            $(section.concat(sectionContainer)).show();
        }
    };

    window.onload = function() {
        var section = oldUrl.match(regexGetPageSection);
        document.title = getSectionTitle(section[0]);
        history.replaceState({
            section:section[0]
            }, getSectionTitle(section[0]), window.location.href);
    };

    function changeUrlParameters(tab){
        var url = oldUrl.replace(regexGetPageSection, tab); 
        
        window.history.pushState({
            section: tab
        }, getSectionTitle(tab), url);
        document.title = getSectionTitle(tab);
    }

    function getSectionTitle(tab){
        var title = "{{getName($user->id)}} ";
        switch(tab){

            case 'general':
                title = title.concat(" | General");
                break;
            case 'plan':
                title = title.concat(" | Plan");
                break;
            case 'foro':
                title = title.concat(" | Foro");
                break;
            case 'archivos':
                title = title.concat(" | Archivos");
                break;
            case 'tutorias':
                title = title.concat(" | Tutorías");
                break;
            case 'cuotas':
                title = title.concat(" | Cuotas");
                break;
            case 'cuenta':
                title = title.concat(" | Cuenta");
                break;
            case 'muro':
                title = title.concat(" | Muro");
                break;                
            default:
                title =title.concat(" | App");
                break;

        }
        return title; 
    }

</script>