
<div class="post-container shadow-container {{$thread->pinned ? 'post-pinned' : ''}}">
    <div class="post-heading">
        <div class="post-details">
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
        <div>
            <p>{{$thread->description}}</p>
        </div>
    </div>
</div>
<div class="add-reply">
    <div class="top-add-reply">
        <img src="/uploads/avatars/{{Auth::user()->user_image}}" alt="">
        <div class="editor-add-reply shadow-editor">
            <div id="editor-add-reply"></div>
        </div>
    </div>
    <div class="footer-add-reply">
        <a>Cancelar</a>
        <button class="btn-purple-basic ">Responder</button>
    </div>
</div>

<h2>Respuestas</h2>
@if($thread->replies->count() != 0)
    @foreach($thread->replies as $key => $reply)
    <div class="reply-container shadow-container">
        <div class="reply-heading">
            <div class="reply-details">
                <img src="/uploads/avatars/{{getUser($reply->author)->user_image}}" alt="user_img">
                <div class="reply-details-autor">
                    <p class="bold">RE: <span class="light">{{$thread->title}}</span></p>
                    <p>{{getName($reply->author)}}<span class="italic" style="margin-left: 5px;">({{ucfirst($reply->created_at->diffForHumans())}})</span></span></p>
                </div>
            </div>
            <div class="reply-options">
                <a id="anchor_edit_button_" onclick="edit()"><i class="far fa-edit"></i></a>
                <a onclick="deleteTutorship()"><i class="fas fa-trash"></i></a>
            </div>
        </div>
        <div class="reply-content">
            <div>
                <p>{{$reply->description}}</p>
            </div>
        </div>
    </div>
    @endforeach

@else
<p>Sin respuestas</p>
@endif

<script>
    var quill = new Quill('#editor-add-reply', {
        modules: {
        toolbar: [
            [{ 'size': ['small', false, 'large'] }],  // custom dropdown
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link'],
        ]     
        },
        placeholder: 'Puedes responder desde aquí...',
        theme: 'snow'  // or 'bubble'
    });
</script>