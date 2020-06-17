<div class="content-group-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: 'miembros', addMembers: false, addTutorshipSession: false,}">
    <div class="container-dashboard">
        <div class="groupinfo">
            <img src="/uploads/group_avatars/{{$group->group_image}}" alt="profile-avatar">
            <div class="group-header">
                <p id="group-type">Grupo</p>
                <h1 id="group-title">{{$group->title}}</h1>
                <p id="group-description">{{$group->description}}</p>
            </div>
        </div>        
    </div>
    <!-- Start 'Navbar dashboard' -->
    <div class="navbar-dashboard">
        <div class="container-dashboard">
            <div class="navbar-dashboard-menu">
                <ul id="navbar-dashboard-items">
                    <li id="general-navbar" onclick="changeUrlParameters('general')" x-on:click.prevent @click="sectionTab = 'general'" :class="{'active-dashboard': sectionTab === 'general'}"><a href="#">Detalles generales</a></li>
                    <li id="noticias-navbar" onclick="changeUrlParameters('cuotas')" x-on:click.prevent @click="sectionTab = 'noticias'" :class="{'active-dashboard': sectionTab === 'noticias'}"><a href="#">Noticias</a></li>
                    <li id="miembros-navbar" onclick="changeUrlParameters('plan')" x-on:click.prevent @click="sectionTab = 'miembros'" :class="{'active-dashboard': sectionTab === 'miembros'}"><a href="#">Miembros</a></li>
                    <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                    <li id="gestionar-navbar" onclick="changeUrlParameters('tutorias')" x-on:click.prevent @click="sectionTab = 'gestion'" :class="{'active-dashboard': sectionTab === 'gestion'}"><a href="#">Gestionar grupo</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
            <div id="general-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
            </div>
            <div id="noticias-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'noticias'">
            </div>
            <div id="miembros-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'miembros'">
                @include('sections_groups.members')
            </div>
            <div id="archivos-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
            </div>
            <div id="gestionar-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'gestion'">
                @include('sections_groups.manage')
            </div>
        </div>
    </div>
</div>