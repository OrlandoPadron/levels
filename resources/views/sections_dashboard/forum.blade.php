<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                @click="addTutorshipSession=!addTutorshipSession"
                @keydown.escape.window="addTutorshipSession=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Nuevo tema
    </button>

    {{-- <form action="{{route('tutorship.toggleBookmark')}}" method="POST">
        @csrf
        <input type="text" name="user_id" value="22">
        <input type="text" name="id_tutorship" value="6">
        <button type="submit">pruebas</button>
    </form> --}}
    @endif
    <h1 class="primary-blue-color">Foro</h1>
</div>
{{-- {{$threads->count()}} --}}
@if($threads->count() != 0)
@foreach ($threads->sortDesc() as $thread)
<div class="post-container shadow-container {{$thread->pinned ? 'post-pinned' : ''}} {{$loop->first ? '' : 'post-collapse'}}">
    <div class="post-heading">
        <div class="post-details" onclick="goToThreads()">
            <img src="/uploads/avatars/{{getUser($thread->author)->user_image}}" alt="user_img">
            <div class="post-details-autor">
                <p class="bold">{{$thread->title}}</p>
                <p>Creado por <span>{{getName($thread->author)}}<span class="italic" style="margin-left: 5px;">({{ucfirst($thread->created_at->diffForHumans())}})</span></span></p>
            </div>
        </div>
        <div class="post-options">
            <a id="anchor_edit_button_" onclick="edit()"><i class="far fa-edit"></i></a>
            <a onclick="deleteTutorship()"><i class="fas fa-trash"></i></a>
            <a class="{{$thread->pinned ? 'pinned' : ''}}""><i class="fas fa-thumbtack"></i></a>
        </div>
    </div>
    <div class="post-content">
        <div class="blurry-effect">
            <p>{{$thread->description}}</p>
        </div>
    </div>
    <div class="post-footer">
        <a><i class="fas fa-comment-alt"></i>{{$thread->replies->count()}} {{$thread->replies->count() == 1 ? 'respuesta' : 'respuestas'}}</a>
        @if($thread->replies->count() == 0)
        <p>Último mensaje por <span>{{getName($thread->author)}}<span class="italic"> ({{ucfirst($thread->created_at->diffForHumans())}})</span></span></p>
        @else   
        <p>Último mensaje por <span>{{getName($thread->replies->last()->author)}}<span class="italic"> ({{ucfirst($thread->replies->last()->created_at->diffForHumans())}})</span></span></p>
        @endif
        
        
    </div>
</div>
@endforeach
@endif

<script>
    function goToThreads(){
        
    }

</script>