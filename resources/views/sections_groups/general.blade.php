<h1 class="primary-blue-color">Detalles Generales</h1>
<div class="box-container-log shadow-container">
    <h2>Actividad reciente <span class="light">(Últimos 30 días)</span></h2>
    <div class="content">
        @if (getGroupLog($group->id)->count() > 0)
            <ul>
            @foreach(getGroupLog($group->id)->sortByDesc('created_at') as $key => $log)
                <li>
                    <div class="log-item">
                        <img class="inner-shadow" src="/uploads/avatars/{{$log->user->user_image}}" alt="profile-avatar">
                        <div class="log-details">
                            <p>{!!$log->author_id == Auth::user()->id ? 'Has ' . $log->action : getName($log->author_id) . ' ha ' . $log->action!!}</p>
                            <p>{{ucfirst($log->created_at->diffForHumans())}}</p>
                        </div>
                        <div class="log-buttons">
                            <button 
                            onclick="changeUrlParameters('{{$log->tab}}')" 
                            x-on:click.prevent @click="sectionTab = '{{$log->tab}}'" 
                            :class="{'active-dashboard': sectionTab === '{{$log->tab}}'}"
                            class="soft-btn">Ver sección</button>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        @else
            <p class="no-activity">
                Sin actividad reciente
            </p>
        @endif
    </div>
</div>