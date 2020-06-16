<div class="navbar" x-data="{openNewGroupForm: false}">
    <h1 class="app-name-navbar">Levels</h1>
    <ul class="items">
      <div class="item-list {{request()->routeIs('profile.show') || request()->routeIs('home') ? 'active' : ''}}">
        <li>
          <div class="icon">
            <i class="fas fa-dumbbell"></i>
          </div>
          <div class="text-list">
            <a href="{{route('home')}}"><span id="trainer_panel">Panel de entrenador</span></a>
          </div>
        </li>
      </div>
      <div class="item-list {{request()->routeIs('group.show') ? 'active' : ''}}">
        <li>
          <div class="icon">
            <i class="fas fa-user-friends"></i>
          </div>
          <div class="text-list">
            <a href=""><span>Grupos</span></a>
          </div>
          <div class="add-button">
            <a href=""
              x-on:click.prevent
              @click="openNewGroupForm=!openNewGroupForm" 
              @keydown.escape.window="openNewGroupForm=false"
            ><i class="fas fa-plus-circle"></i></a>
          </div>
        </li>
      </div>
    </ul>
    <!--hidden-->
    @if(Auth::user()->isTrainer == 1)
      @include('modals.newGroupModal')
      @if(Auth::user()->trainer->groups->isNotEmpty())
        <div class="group">
          <ul class="group-list">
            @foreach(Auth::user()->trainer->groups->sortBy('title') as $group)
              <li>
                <a href="{{route('group.show', [$group->id, 'general'])}}">{{$group->title}}</a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif
    @endif
  </div>