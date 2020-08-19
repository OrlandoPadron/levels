<div class="search-container" x-data="{ isOpen: true}" @click.away="isOpen = false">
    <form action="/" method="GET" autocomplete="off"  x-on:keydown.enter.prevent>
      <div class="wrap-search">
        <input 
        wire:model.debounce.500ms="search" 
        type="text" placeholder="Buscar..." 
        name="search" 
        @keydown = "isOpen = true"
        @focus = "isOpen = true"
        @keydown.escape.window = "isOpen = false"

        />
        {{-- <div class="button-submit">
          <button disabled type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div> --}}
      </div>
    </form>
    @if (strlen($search) >=3)
      <div 
      class="search-dropdown" 
      x-show.transition.opacity="isOpen"
      >
        @if($searchResults->count()>0)
          <ul>
              @foreach ($searchResults as $user)
                <li
                  class="searchbar-user-item"
                  onclick="location.href='{{route('profile.show', [$user->id, 'general'])}}'"
                >

                    <img
                    class="inner-shadow"
                    src="/uploads/avatars/{{$user->user_image}}"
                    alt="profile-pic"
                    class="user_picture"
                    />
                    <div 
                    class="user_info"
                    @if($loop->last) @keydown.tab="isOpen = false" @endif 
                    >
                        <a href="{{route('profile.show', [$user->id, 'general'])}}">{{$user->name . ' ' .$user->surname}}</a>
                        @if(Auth::user()->id == $user->id)
                    <span class="user_info_usertype">{{$user->isTrainer == 1 ? 'Entrenador' : 'Deportista'}} (Tú) </span>
                        @else
                            <span class="user_info_usertype">{{$user->isTrainer == 1 ? 'Entrenador' : 'Deportista'}}</span>

                        @endif
                        
                    </div>
                    @if($user->isTrainer==0 && Auth::user()->isTrainer == 1)
                      @if(iAmcurrentlyTrainingThisAthlete($user->athlete->id))
                        <div class="training_button_searchbar">
                          <button>Entrenando</button>
                        </div>
                      @endif
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

