<div class="content-group-dashboard" x-data="{openShowProfileData: false, openNewPlan: false, sectionTab: '{{$tab}}', paymentSettings: false, addTutorshipSession: false,}">
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
                    <li id="noticias-navbar" onclick="changeUrlParameters('cuotas')" x-on:click.prevent @click="sectionTab = 'cuotas'" :class="{'active-dashboard': sectionTab === 'cuotas'}"><a href="#">Noticias</a></li>
                    <li id="miembros-navbar" onclick="changeUrlParameters('plan')" x-on:click.prevent @click="sectionTab = 'plan'" :class="{'active-dashboard': sectionTab === 'plan'}"><a href="#">Miembros</a></li>
                    <li id="archivos-navbar" onclick="changeUrlParameters('archivos')" x-on:click.prevent @click="sectionTab = 'archivos'" :class="{'active-dashboard': sectionTab === 'archivos'}"><a href="#">Archivos</a></li>
                    <li id="gestionar-navbar" onclick="changeUrlParameters('tutorias')" x-on:click.prevent @click="sectionTab = 'tutorias'" :class="{'active-dashboard': sectionTab === 'tutorias'}"><a href="#">Gestionar grupo</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End 'Navbar dashboard' -->
    <div class="content-dashboard">
        <div id="container-dashboard" class="container-dashboard">
            <div id="general-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'general'">
            </div>
            <div id="plan-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'plan'">
            </div>
            <div id="archivos-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'archivos'">
            </div>
            <div id="tutorias-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'tutorias'">
            </div>
            <div id="cuotas-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'cuotas'">
            </div>
            <div id="cuenta-section-container" x-show.transition.in.opacity.duration.500ms="sectionTab === 'cuenta'">
            </div>
        </div>
    </div>
</div>