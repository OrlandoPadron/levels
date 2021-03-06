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

    //Show additional info 
    $shouldYouSeeMyAdditionalInfo = shouldYouSeeMyAdditionalInfo($user->id);

@endphp
<div class="content-profile-dashboard" x-data="{openShowProfileData: false, sectionTab: '{{$tab}}', openNewThreadForm:false, uploadFile: false}">
    <div class="container-dashboard">
        <div class="userinfo">
            <img class="inner-shadow" src="/uploads/avatars/{{$user->user_image}}" alt="profile-avatar">
            <div class="text-info-dashboard {{$shouldYouSeeMyAdditionalInfo ? '' : 'no-additional-info'}}">
                <p id="user_name_dashboard" class="primary-blue-color">{{$user->name .' '. $user->surname}}</p>
                <div class="text-info-user-type">
                    <label id="user_type" class="primary-blue-color">Entrenador</label>
                    @if (isset($additionalInfo['thirdParties']) && count($additionalInfo['thirdParties']) >= 1)
                        <div class="athlete-accounts-links">
                            @foreach($additionalInfo['thirdParties'] as $service => $url)
                                <a href="{{$url}}" target="_blank">{{ucfirst($service)}}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($shouldYouSeeMyAdditionalInfo)
                <div id="user-dashboard-buttons-container">
                    <button class="btn-purple-basic"
                    @click="openShowProfileData=!openShowProfileData" 
                    @keydown.escape.window="openShowProfileData=false"
                    >Información adicional</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if($shouldYouSeeMyAdditionalInfo)
        @include('modals.additionalInfoModal')
    @endif

    <!-- Start 'Navbar dashboard' -->
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul id="navbar-dashboard-items">
                    <li id="general-navbar" onclick="changeUrlParameters('general')" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                    @if(Auth::user()->id == $user->id)
                    <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
            <div id="general-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
                @include('sections_dashboard.generalTrainer')
            </div>
            @if(Auth::user()->id == $user->id)
            <div id="archivos-section-container" style="display: none;" x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
                @include('sections_dashboard.files')
            </div>
            @endif
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
            case 'archivos':
                title = title.concat(" | Archivos");
                break;
            default:
                title =title.concat(" | App");
                break;

        }
        return title; 
    }

</script>