<div class="navbar" x-data="{openNewGroupForm: false}">
    <h1 class="app-name-navbar">Levels</h1>
    <div class="sidebar-mobile">
      <ul class="items">
        @if(Auth::user()->isTrainer)
        <div class="item-list {{request()->routeIs('home') ? 'active' : ''}}" onclick="location.href='{{route('home')}}'">
          <li>
            <div class="icon">
              <i class="fas fa-dumbbell"></i>
            </div>
            <div class="text-list">
              <a href="{{route('home')}}"><span id="trainer_panel">Panel de entrenador</span></a>
            </div>
          </li>
        </div>
        @else
        <div class="item-list {{request()->routeIs('athlete.home') ? 'active' : ''}}" onclick="location.href='{{route('home')}}'">
          <li>
            <div class="icon">
              <i class="fas fa-home" style="margin-left: 5px"></i>
            </div>
            <div class="text-list">
              <a href="{{route('home')}}">Inicio</a>
            </div>
          </li>
        </div>
        @endif
        <div class="item-list {{request()->routeIs('group.show') ? 'active' : ''}} item-list-group">
          <li>
            <div class="icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <div class="text-list">
              <span>Grupos</span>
            </div>
            @if(Auth::user()->isTrainer)
            <div class="add-button">
              <a href=""
                x-on:click.prevent
                @click="openNewGroupForm=!openNewGroupForm" 
                @keydown.escape.window="openNewGroupForm=false"
              ><i class="fas fa-plus-circle"></i></a>
            </div>
            @endif
          </li>
        </div>
      </ul>
      <!--hidden-->
      @if(Auth::user()->isTrainer == 1)
        @include('modals.newGroupModal')
      @endif
      @if(Auth::user()->account_activated)
        @if (getUserGroups()->count() > 0)
        <div class="group">
          <ul class="group-list">
            @foreach(getUserGroups()->sortBy('title') as $group)
              <li>
                <a href="{{route('group.show', [$group->id, 'general'])}}">{{$group->title}}</a>
              </li>
            @endforeach
          </ul>
        </div>
        @endif
      @endif

    </div>
  </div>