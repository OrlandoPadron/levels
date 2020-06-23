
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
            {!!$thread->description!!}
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
        <button onclick="newReply({{$thread->id}})" class="btn-purple-basic ">Responder</button>
    </div>
</div>

<h2>Respuestas</h2>
<div id="all-replies">
@if($thread->replies->count() != 0)
    @foreach($thread->replies->sortDesc() as $key => $reply)
    <div id="reply-container-{{$reply->id}}" class="reply-container shadow-container">
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
                <a onclick="deleteReply({{$reply->id}})"><i class="fas fa-trash"></i></a>
            </div>
        </div>
        <div class="reply-content">
            <div>
                {!!$reply->description!!}
            </div>
        </div>
    </div>
    @endforeach

    
@else
<p id="no_replies">Sin respuestas</p>
@endif
</div>

<script>
    var reply_container= "#reply-container-";
    var quill_newReply = new Quill('#editor-add-reply', {
        modules: {
        toolbar: [
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

    function newReply(thread_id){
        if (quill_newReply.getLength() > 1){
            var description = quill_newReply.root.innerHTML;
            var reply;
            $.ajax({
                    url: "{{route("reply.store")}}",
                    type: "POST",
                    data: {
                        thread_id: thread_id,
                        description: description,
                        author: 26,
                        _token: "{{csrf_token()}}",
                    },
                    success: function(replyId){
                        $.ajax({ 
                            type: "GET",   
                            url: "/component/reply/".concat(replyId),   
                            async: false,
                            success : function(text)
                            {
                                reply= text;
                                $('#no_replies').remove();
                                $('#all-replies').prepend(reply);
                            }
                        });
                        quill_newReply.setContents([]);
                        
                    },
                    error: function(){
                        console.log('Error on ajax call "newReply" function');
                    }  
                });
        }  
            

    }

    function deleteReply(replyId){
        console.log("Deleting reply...");

        $.ajax({
            url: "{{route("reply.destroy")}}",
            type: "POST",
            data: {
                reply_id: replyId,
                _token: "{{csrf_token()}}",
            },
            success: function(repliesRemaining){
                $(reply_container.concat(replyId)).hide();
                if (repliesRemaining == 0){
                    $('#all-replies').prepend('<p>Sin respuestas</p>');

                }
                
            },
            error: function(){
                console.log('Error on ajax call "deleteReply" function');
            }  
        });

    }
</script>