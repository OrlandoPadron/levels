<div class="userbar">
    <div class="search-container">
      <form action="/" method="GET" autocomplete="off">
        <div class="wrap-search">
          <input type="text" placeholder="Buscar..." name="search" />
          <div class="button-submit">
            <button disabled type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
      </form>
      <div class="search-dropdown">
        <ul>
          <li>
            <img
              src="/images/profile_picture.jpg"
              alt="profile-pic"
              class="user_picture"
            />
            <div class="user_info">
              <a href=""><span>Orlando Padrón</span></a>
              <span class="user_info_usertype">Deportista</span>
            </div>
            <div class="training_button_searchbar">
              <button>Entrenando</button>
            </div>
          </li>
          <li>
            <img
              src="/images/profile_picture.jpg"
              alt="profile-pic"
              class="user_picture"
            />
            <div class="user_info">
              <span>Marc Pérez</span>
              <span class="user_info_usertype">Deportista</span>
            </div>
            <div class="training_button_searchbar">
              <button>Entrenando</button>
            </div>
          </li>
          <li>
            <img
              src="/images/profile_picture.jpg"
              alt="profile-pic"
              class="user_picture"
            />
            <div class="user_info">
              <span>Marc Pérez</span>
              <span class="user_info_usertype">Deportista</span>
            </div>
            <div class="training_button_searchbar">
              <button>Entrenando</button>
            </div>
          </li>
          <li>
            <img
              src="/images/profile_picture.jpg"
              alt="profile-pic"
              class="user_picture"
            />
            <div class="user_info">
              <span>Marc Pérez</span>
              <span class="user_info_usertype">Deportista</span>
            </div>
            <div class="not_training_button_searchbar">
              <button>Entrenar</button>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="userbuttons">
      <div class="greetings">
        <div class="user-greetings">
        <p>Hola, <span id="user_name">{{Auth::user()->name}} {{Auth::user()->surname}}</span></p>
        </div>
        <div class="user-type">
          <span class="smaller" id="type_user">{{Auth::user()->trainer == 1 ? 'Perfil entrenador' : 'Perfil deportista'}}</span>
        </div>
      </div>
      <div class="dropdown-button-userbar">
      <img src="/uploads/avatars/{{Auth::user()->user_image}}" alt="avatar" />
        <i class="fas fa-caret-down"></i>
        <div class="dropdown-button-userbar-content">
          <div class="dropdown-button-userbar-content-item">
            <a href=""><i class="fas fa-user"></i>Mi perfil</a>
          </div>
          <div class="dropdown-button-userbar-content-item">
            <a href=""><i class="fas fa-user-cog"></i>Panel admin</a>
          </div>
          <div class="dropdown-button-userbar-content-item">
            <a href=""><i class="fas fa-cog"></i>Configuración</a>
          </div>
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
