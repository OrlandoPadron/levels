@section('head')
<!-- Firebase Scripts -->
@include('scripts.firebaseScripts')
@endsection
<div class="content-profile-dashboard" x-data="{openShowProfileData: false, sectionTab: '{{$tab}}', openNewThreadForm:false, addWallSection: false, uploadFile: false}">
    <div class="container-dashboard">
        <div class="userinfo">
            <img class="inner-shadow" src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard">
                <p id="user_name_dashboard" class="primary-blue-color">{{$user->name .' '. $user->surname}}</p>
                <div class="text-info-user-type">
                    <label id="user_type" class="primary-blue-color">Entrenador</label>
                    <div class="athlete-accounts-links">
                        <a href="https://www.strava.com/?hl=es" target="_blank">Strava</a>
                        <a href="https://connect.garmin.com/" target="_blank">Garmin Connect</a>
                        <a href="https://www.trainingpeaks.com/" target="_blank">TrainingPeaks</a>
                    </div>
                </div>
                <button class="btn-purple-basic"
                @click="openShowProfileData=!openShowProfileData" 
                @keydown.escape.window="openShowProfileData=false"
                >Información adicional</button>
            </div>
                {{-- @include('modals.additionalInfoModal') --}}
        </div>
    </div>
    <!-- Start 'Navbar dashboard' -->
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul id="navbar-dashboard-items">
                    <li id="general-navbar" onclick="changeUrlParameters('general')" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                    <li id="foro-navbar" onclick="changeUrlParameters('foro')" x-on:click.prevent @click="sectionTab = 'foro'" :class="{'active-dashboard': sectionTab === 'foro'}"><a href="#">Foro</a></li>
                    <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                    <li id="muro-navbar" onclick="changeUrlParameters('muro')" x-on:click.prevent @click="sectionTab = 'muro'" :class="{'active-dashboard': sectionTab === 'muro'}"><a href="#">Mi muro</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
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