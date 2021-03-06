@section('head')
<!-- Firebase Scripts -->
@include('scripts.firebaseScripts')
@endsection
@php
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
<div class="content-profile-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: '{{$tab}}', openNewThreadForm:false, addWallSection: false, uploadFile: false, groupForumStatusModal: false}">
    <div class="container-dashboard">
        <div class="userinfo">
            <img class="inner-shadow" src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard">
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
                <div id="user-dashboard-buttons-container">
                    <button class="btn-purple-basic"
                    @click="openShowProfileData=!openShowProfileData" 
                    @keydown.escape.window="openShowProfileData=false"
                    >Información adicional</button>

                </div>
            </div>
                @include('modals.additionalInfoModal')
        </div>
        @include('modals.groupForumStatusForAthleteModal')

    </div>
    @if ($user->account_activated==0)
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
            @include('page_messages.account_deactivated_message')
        </div>
    </div>
    @else
    <!-- Start 'Navbar dashboard' -->
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul id="navbar-dashboard-items">
                    <li id="general-navbar" onclick="changeUrlParameters('general')" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                    <li id="plan-navbar" onclick="changeUrlParameters('plan')" x-on:click.prevent @click="sectionTab = 'plan'" :class="{'active-dashboard': sectionTab === 'plan'}">
                        @if ($notifications['trainingPlansUpdates']['totalChanges'] > 0)
                        <div class="notification-indicator"></div>
                        @endif
                        <a href="#">Planes de entrenamiento </a>
                    </li>
                    <li id="foro-navbar" onclick="changeUrlParameters('foro')" x-on:click.prevent @click="sectionTab = 'foro'" :class="{'active-dashboard': sectionTab === 'foro'}">
                        @if ($notifications['threads']['totalNumOfNewChanges'] > 0)
                        <div class="notification-indicator"></div>
                        @endif
                        <a href="#">Foro</a>
                    
                    </li>
                    <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                    <li id="muro-navbar" onclick="changeUrlParameters('muro')" x-on:click.prevent @click="sectionTab = 'muro'" :class="{'active-dashboard': sectionTab === 'muro'}"><a href="#">Mi muro</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
            <div id="general-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
                @include('athlete_home.dashboard_sections.general')
            </div>
            <div id="plan-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'plan'">
                @include('sections_dashboard.trainingPlans')
            </div>
            <div id="foro-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'foro'">
                @if(Request::get('thread_view') == 0)
                @include('common_sections.forum')
                @else
                @include('sections_dashboard.thread')
                @endif
            </div>
            <div id="archivos-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
                @include('sections_dashboard.files')
            </div>
            <div id="muro-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'muro'">
                @include('sections_dashboard.myWall')
            </div>
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
        var title = "{{getName($user->id)}}";
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
                title = title.concat(" | Mi muro");
                break;
            default:
                title =title.concat(" | App");
                break;

        }
        return title; 
    }

</script>