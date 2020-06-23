<div id="reply-container-{{$reply->id}}" class="reply-container shadow-container">
    <div class="reply-heading">
        <div class="reply-details">
            <img src="/uploads/avatars/{{getUser($reply->author)->user_image}}" alt="user_img">
            <div class="reply-details-autor">
                <p class="bold">RE: <span class="light">{{$reply->thread->title}}</span></p>
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