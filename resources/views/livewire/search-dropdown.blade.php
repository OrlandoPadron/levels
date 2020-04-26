<div class="search-container">
    <form action="/" method="GET" autocomplete="off">
      <div class="wrap-search">
        <input wire:model.debounce.500ms="search" type="text" placeholder="Buscar..." name="search" />
        <div class="button-submit">
          <button disabled type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    @if (strlen($search) >=3)
      <div class="search-dropdown">
        @if($searchResults->count()>0)
          <ul>
              @foreach ($searchResults as $user)
                <li>
                    <img
                    src="/uploads/avatars/{{$user->user_image}}"
                    alt="profile-pic"
                    class="user_picture"
                    />
                    <div class="user_info">
                        <a href="">{{$user->name . ' ' .$user->surname}}</a>
                        @if(Auth::user()->id == $user->id)
                    <span class="user_info_usertype">{{$user->trainer == 1 ? 'Entrenador' : 'Deportista'}} - Eres tú </span>
                        @else
                            <span class="user_info_usertype">{{$user->trainer == 1 ? 'Entrenador' : 'Deportista'}}</span>

                        @endif
                        
                    </div>
                    @if($user->trainer==0 && Auth::user()->trainer == 1)
                    <div class="training_button_searchbar">
                        <button>Entrenando</button>
                    </div>
                    @endif
                </li>  
              @endforeach
          </ul>
        @else
        <div class="results-not-found">
          <span>No se han encontrado resultados para "{{$search}}"</span>
        </div>
        @endif
      </div>
    @endif
  </div>

