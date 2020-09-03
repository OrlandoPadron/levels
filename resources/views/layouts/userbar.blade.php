<div class="userbar">
  @if(Auth::user()->isTrainer)
    <livewire:search-dropdown> 
  @endif
    <div class="userbuttons">
      <div class="greetings">
        <div class="user-greetings">
        <p>Hola, <span id="user_name">{{Auth::user()->name}} {{Auth::user()->surname}}</span></p>
        </div>
        <div class="user-type">
          <span class="smaller" id="type_user">{{Auth::user()->isTrainer == 1 ? 'Perfil entrenador' : 'Perfil deportista'}}</span>
        </div>
      </div>
      <div class="dropdown-button-userbar" x-data="{open: false}">
        <div  
          class="dropdonw-button-to-open"
          @click="open=!open" 
          @click.away="open=false"
          @keydown.escape.window="open=false"
          >
          <img
            src="/uploads/avatars/{{Auth::user()->user_image}}" 
            alt="avatar"
           
            />
          <i class="fas fa-caret-down"></i>

        </div>
        <div class="dropdown-button-userbar-content" style="display:none;" x-show.transition.duration.250ms.opacity="open" >
          <div class="dropdown-button-userbar-content-item">
          <a href="{{route('profile.show', [Auth::user()->id, "general"])}}"><i class="fas fa-user"></i>Mi perfil</a>
          </div>
          <div class="dropdown-button-userbar-content-item">
          <a href="{{route('profileEdit.show')}}"><i class="fas fa-cog"></i>Configuración</a>
          </div>
          
          @if(Auth::user()->admin==1)
            <div class="dropdown-button-userbar-content-item">
              <a href="{{route('admin')}}"><i class="fas fa-user-cog"></i>Panel admin</a>
            </div>
          @endif
          <div class="dropdown-button-userbar-content-logout">
            <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>Cerrar sesión
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div> 