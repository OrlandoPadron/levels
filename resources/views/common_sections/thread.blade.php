
@include('common_sections.components.threadComponent', ["thread" => $thread, "generalThreadView" => false])
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
    @foreach($thread->replies as $key => $reply)
        @include('common_sections.components.replyComponent', ["reply" => $reply])
    @endforeach

    
@else
<p id="no_replies">Sin respuestas</p>
@endif
</div>

<script>
    //Threads JS
    var quillThreads = [];
    var quill_thread_editor_container = "#thread_editor_container_";
    var anchor_thread_edit_button = "#thread_edit_button_";
    var thread_edit_buttons = "#thread_editor_buttons_";
    var thread_description = "#thread_description_";


    function editThread(threadId){
        if (quillThreads[threadId] != null){
            closeThreadEditor(threadId);
            
        }else{
            //Show edit interface.
            $(thread_edit_buttons.concat(threadId)).show();
            $(anchor_thread_edit_button.concat(threadId)).addClass('activated');
            $(thread_description.concat(threadId)).hide();

            showQuillThreadEditor(threadId);
        }
    }

    function showQuillThreadEditor(threadId){
        var description = $(thread_description.concat(threadId)).html();
        var html_quill_editor = "<div id='quill-editor-"+threadId+"'>"+description+"</div>";
        $(quill_thread_editor_container.concat(threadId)).append(html_quill_editor);
        
        quillThreads[threadId] = new Quill('#quill-editor-'.concat(threadId), {
        modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link'],

        ]     
        },
        placeholder: 'Empieza a escribir aquí...',
        theme: 'snow'  // or 'bubble'
        });

    }

    function saveThreadChanges(threadId){
        var description = quillThreads[threadId].getLength() == 1 ? "<p>Contenido eliminado.</p>" : quillThreads[threadId].root.innerHTML;
        $.ajax({
            url: "{{route("thread.update")}}",
            type: "POST",
            data: {
                id_thread: threadId,
                description: description,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var date_span = "#thread_date_".concat(threadId);
                $(date_span).text("(Modificado ahora mismo)");
                $(thread_description.concat(threadId)).html(description);
                $("#gthread_description_".concat(threadId)).html(description);
                closeThreadEditor(threadId);
                
            },
            error: function(){
                console.log('Error on ajax call "saveThreadChanges" function');
            }  
        });
    }

    function closeThreadEditor(threadId){
        //Hide edit interface. 
        $(thread_edit_buttons.concat(threadId)).hide();
        $(thread_description.concat(threadId)).show();
        $(anchor_thread_edit_button.concat(threadId)).removeClass('activated');
        destroyQuillEditorContainer(threadId, true);
    }

    



    //Replies JS
    var quillReplies = [];
    var reply_container= "#reply-container-";
    var quill_reply_editor_container = "#editor_container_";
    var reply_description = "#reply_description_";
    var reply_edit_buttons = "#reply_editor_buttons_";
    var anchor_replay_edit_button = "#reply_edit_button_";
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

    function newReply(threadId){
        if (quill_newReply.getLength() > 1){
            var description = quill_newReply.root.innerHTML;
            var reply;
            $.ajax({
                    url: "{{route("reply.store")}}",
                    type: "POST",
                    data: {
                        thread_id: threadId,
                        description: description,
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

    function showQuillEditor(replyId){
        var description = $(reply_description.concat(replyId)).html();
        var html_quill_editor = "<div id='quill-editor-"+replyId+"'>"+description+"</div>";
        $(quill_reply_editor_container.concat(replyId)).append(html_quill_editor);
        
        quillReplies[replyId] = new Quill('#quill-editor-'.concat(replyId), {
        modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link'],

        ]     
        },
        placeholder: 'Empieza a escribir aquí...',
        theme: 'snow'  // or 'bubble'
        });
    }

    function editReply(replyId){
        if (quillReplies[replyId] != null){
            closeEditor(replyId);
            
        }else{
            console.log('Edit function');
            //Show edit interface.
            $(reply_edit_buttons.concat(replyId)).show();
            $(anchor_replay_edit_button.concat(replyId)).addClass('activated');
            $(reply_description.concat(replyId)).hide();

            showQuillEditor(replyId);
        }

    }

    function saveChanges(replyId){
        var description = quillReplies[replyId].getLength() == 1 ? "<p>Contenido eliminado.</p>" : quillReplies[replyId].root.innerHTML;

        $.ajax({
            url: "{{route("reply.update")}}",
            type: "POST",
            data: {
                id_reply: replyId,
                description: description,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var date_span = "#reply_date_".concat(replyId);
                $(date_span).text("(Modificado ahora mismo)");
                $(reply_description.concat(replyId)).html(description);
                closeEditor(replyId);
                
            },
            error: function(){
                console.log('Error on ajax call "saveChanges" function');
            }  
        });
    }

    function closeEditor(replyId){
        //Hide edit interface. 
        $(reply_edit_buttons.concat(replyId)).hide();
        $(reply_description.concat(replyId)).show();
        $(anchor_replay_edit_button.concat(replyId)).removeClass('activated');
        destroyQuillEditorContainer(replyId, false);

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
                    $('#all-replies').prepend('<p id="no_replies">Sin respuestas</p>');

                }
                
            },
            error: function(){
                console.log('Error on ajax call "deleteReply" function');
            }  
        });

    }

    function destroyQuillEditorContainer(id, isThread){

        if (isThread){
            $(quill_thread_editor_container.concat(id)).children().remove();
            quillThreads[id] = null;            
        }else{
            $(quill_reply_editor_container.concat(id)).children().remove();
            quillReplies[id] = null;
        }

    }
</script>