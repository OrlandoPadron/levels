<div id="thread_container_{{$thread->id}}" class="post-container shadow-container {{$thread->pinned ? 'post-pinned' : ''}} 
    {{$generalThreadView ? ($loop->first ? '' : 'post-collapse') : ''}}">
    <div class="post-heading">
        <div class="post-details" onclick="goToThreads({{$thread->id}})">
            <img src="/uploads/avatars/{{getUser($thread->author)->user_image}}" alt="user_img">
            <div class="post-details-autor">
                <p class="bold">{{$thread->title}}</p>
                <p>{{$thread->created_at == $thread->updated_at ? 'Creado ' : 'Modificado '}} por <span>{{getName($thread->author)}}<span class="italic" style="margin-left: 5px;">({{$thread->created_at == $thread->updated_at ? ucfirst($thread->created_at->diffForHumans()) : $thread->updated_at->diffForHumans()}})</span></span></p>
            </div>
        </div>
        <div class="post-options">
            @if (!$generalThreadView)
            <a id="thread_edit_button_{{$thread->id}}" onclick="editThread({{$thread->id}})"><i class="far fa-edit"></i></a>
            <form id="deleteThreadForm" action="{{route('thread.destroy')}}" method="POST">
                @csrf
                <input type="text" value="{{$thread->id}}" name="thread_id" hidden>
                <input type="text" value="1" name="return_to_forum" hidden> 
            </form>
            <a onclick="document.getElementById('deleteThreadForm').submit()"><i class="fas fa-trash"></i></a>
            <a class="{{$thread->pinned ? 'pinned' : ''}}""><i class="fas fa-thumbtack"></i></a>
            @else
            <a onclick="deleteThread({{$thread->id}})"><i class="fas fa-trash"></i></a>
            <a class="{{$thread->pinned ? 'pinned' : ''}}""><i class="fas fa-thumbtack"></i></a>
            @endif
        </div>
    </div>
    @if($generalThreadView)
    <div class="post-content">
        <div class="blurry-effect">
            <div id="gthread_description_{{$thread->id}}">
                {!!$thread->description!!}
            </div>
        </div>
    </div>
    <div class="post-footer">
        <a  onclick="goToThreads({{$thread->id}})"><i class="fas fa-comment-alt"></i>{{$thread->replies->count()}} {{$thread->replies->count() == 1 ? 'respuesta' : 'respuestas'}}</a>
        @if($thread->replies->count() == 0)
        <p>Último mensaje por <span>{{getName($thread->author)}}<span class="italic"> ({{ucfirst($thread->created_at->diffForHumans())}})</span></span></p>
        @else   
        <p>Último mensaje por <span>{{getName($thread->replies->last()->author)}}<span class="italic"> ({{ucfirst($thread->replies->last()->created_at->diffForHumans())}})</span></span></p>
        @endif
        
        
    </div>
    @else
    <div class="post-content">
        <div id="thread_editor_container_{{$thread->id}}"></div>
        <div id="thread_description_{{$thread->id}}">
            {!!$thread->description!!}
        </div>
        <div id="thread_editor_buttons_{{$thread->id}}" class="thread_editor_buttons" style="display: none;">
            <button onclick="saveThreadChanges({{$thread->id}})" class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
            <button onclick="closeThreadEditor({{$thread->id}})" class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
        </div> 
    </div>
    @endif
</div>