@section('head')
<!-- Firebase Scripts -->
@include('scripts.firebaseScripts')
@endsection
@php
$userLoggedRole = getUserRole($group->id, Auth::user()->id);
$showEditModal = false;
if ($userLoggedRole == 'Propietario' || $userLoggedRole == 'Administrador' ){
    $showEditModal = true; 
}
@endphp
<div class="content-group-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: '{{$tab}}', addMembers: false, shareFile:false, addTutorshipSession: false, openNewThreadForm: false, editGroupDetails: false, uploadFile: false,}">
    <div class="container-dashboard">
        <div class="groupinfo">
            <div class="{{ $showEditModal ? 'img-group-container' : 'img-group-container-no-editable'}}" 
                @if($showEditModal)
                    @click="editGroupDetails=!editGroupDetails"
                    @keydown.escape.window="editGroupDetails=false"
                @endif
                >
                <img class="inner-shadow" src="/uploads/group_avatars/{{$group->group_image}}" alt="profile-avatar">
                @if($showEditModal)
                <a href="" x-on:click.prevent>
                    <i class="fas fa-pencil-alt"></i>
                </a>
                @endif
            </div>
            <div {!! $showEditModal ? 'class=group-header' : '' !!}
                @if($showEditModal)
                    @click="editGroupDetails=!editGroupDetails"
                    @keydown.escape.window="editGroupDetails=false"
                @endif
            >
                <p id="group-type">Grupo</p>
                <h1 id="group-title">{{$group->title}}</h1>
                <p id="group-description">{{$group->description}}</p>
            </div>
        </div>        
    </div>
    @include('modals.editGroupDetailsModal')
    <!-- Start 'Navbar dashboard' -->
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul id="navbar-dashboard-items">
                    <li id="general-navbar" onclick="changeUrlParameters('general')" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                    <li id="noticias-navbar" onclick="changeUrlParameters('foro')" x-on:click.prevent @click="sectionTab = 'foro'" :class="{'active-dashboard': sectionTab === 'foro'}">
                        @if ($notifications['threads']['totalNumOfNewChanges'] > 0)
                            <div class="notification-indicator"></div>
                        @endif
                        <a href="#">Foro</a>
                    </li>
                    <li id="miembros-navbar" onclick="changeUrlParameters('miembros')" x-on:click.prevent @click="sectionTab = 'miembros'" :class="{'active-dashboard': sectionTab === 'miembros'}"><a href="#">Miembros</a></li>
                    <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
            <div id="general-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
                @include('sections_groups.general')
            </div>
            <div id="foro-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'foro'">
                @include('common_sections.forum')
            </div>
            <div id="miembros-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'miembros'">
                @include('sections_groups.members')
            </div>
            <div id="archivos-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
                @include('sections_groups.files')
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
        var title = "{{$group->title}}";
        switch(tab){

            case 'general':
                title = title.concat(" | General");
                break;
            case 'foro':
                title = title.concat(" | Foro");
                break;
            case 'miembros':
                title = title.concat(" | Miembros");
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