<div id="reply-container-{{$reply->id}}" class="reply-container shadow-container">
    <div class="reply-heading">
        <div class="reply-details">
            <img src="/uploads/avatars/{{getUser($reply->author)->user_image}}" alt="user_img">
            <div class="reply-details-autor">
                <p class="bold">RE: <span class="light">{{$reply->thread->title}}</span></p>
                <p>{{getName($reply->author)}}<span id="reply_date_{{$reply->id}}" class="italic" style="margin-left: 5px;">({{$reply->created_at->diffForHumans()}})</span></span></p>
            </div>
        </div>
        @if($reply->author == Auth::user()->id || Auth::user()->admin)
        <div class="reply-options">
            <a id="reply_edit_button_{{$reply->id}}" onclick="editReply({{$reply->id}})"><i class="far fa-edit"></i></a>
            <a onclick="deleteReply({{$reply->id}})"><i class="fas fa-trash"></i></a>
        </div>
        @endif
    </div>
    <div class="reply-content">
        <div>
            <div id="editor_container_{{$reply->id}}"></div>
            <div id="reply_description_{{$reply->id}}">
                {!!$reply->description!!}
            </div>
            <div id="reply_editor_buttons_{{$reply->id}}" class="reply_editor_buttons" style="display: none;">
                <button onclick="saveChanges({{$reply->id}})" class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
                <button onclick="closeEditor({{$reply->id}})" class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
            </div> 
        </div>
    </div>
</div>