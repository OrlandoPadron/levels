<div class="heading-section">
    @if ($user->account_activated == 1)
    <button id="add-btn-forum" class="btn-add-basic button-position"
                @click="openNewThreadForm=!openNewThreadForm"
                @keydown.escape.window="openNewThreadForm=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Nuevo hilo
    </button>

    <form action="{{route('reply.destroy')}}" method="POST">
        @csrf
        <input type="text" name="reply_id" value="3">
        {{-- <input type="text" name="description" value="Prueba">
        <input type="text" name="author" value="{{Auth::user()->id}}"> --}}
        <button type="submit">pruebas</button>
    </form>
    @endif
    <h1 id="forum-header" class="primary-blue-color">Foro</h1>
 
</div>
@include('modals.addNewThread')
<div id="open-thread-container">
</div>

<div class="pinned-threads">
    <h2 class="primary-blue-color">Hilo fijado</h2>
    @if (($threads->filter->pinned)->isNotEmpty())
        @include('sections_dashboard.components.threadComponent', ["thread" => ($threads->filter->pinned)->first(), "generalThreadView" => true])
    @endif
</div>
<div class="non-pinned-threads">
    <div class="filter-options">
        <p>Mostrando primero </p>
        <button onclick="filter('newest')">Más recientes</button>
        <button onclick="filter('oldest')">Más antiguos</button>
        <input type="search" id="searchThread" onkeyup="search()">
    </div>
    <div class="non-pinned-threads-content">
        @if($threads->count() != 0)
        @foreach ($threads->filter(function($thread){return $thread->pinned==0;})->sortDesc() as $thread)
            @include('sections_dashboard.components.threadComponent', ["thread" => $thread, "generalThreadView" => true])
        @endforeach
        @endif
    </div>

</div>

<script>
    function goToThreads(thread_id){
        $( "#open-thread-container" ).load( "/thread/".concat(thread_id));
        $("#forum-header").html('<i style="margin-right: 15px;" class="fas fa-chevron-circle-left"></i>');
        $("#forum-header").append("Volver atrás");
        $("#forum-header").attr("onclick", 'closeThread()');
        $("#forum-header").addClass("clickable");
        $(".post-container").fadeOut(500);
        $(".pinned-threads").fadeOut(500);
        $(".non-pinned-threads").fadeOut(500);
        $("#add-btn-forum").fadeOut(500);
        $( "#open-thread-container" ).fadeIn(500);
        $(".page-content").animate({ scrollTop: 0 }, "slow");

    }

    function closeThread(){
        $("#forum-header").text("Foro");
        $(".post-container").fadeIn(500);
        $("#add-btn-forum").fadeIn(500);
        $(".pinned-threads").fadeIn(500);
        $(".non-pinned-threads").fadeIn(500);
        $("#forum-header").removeAttr("onclick");
        $("#forum-header").removeClass("clickable");
        $( "#open-thread-container" ).fadeOut(500);
        $(".page-content").animate({
             scrollTop: 0 
            }, "slow");
    }

    function deleteThread(threadId){
        console.log("Deleting thread...");

        $.ajax({
            url: "{{route("thread.destroy")}}",
            type: "POST",
            data: {
                thread_id: threadId,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                $("#gthread_container_".concat(threadId)).hide();
                
            },
            error: function(){
                console.log('Error on ajax call "deleteThread" function');
            }  
        });
    }
    function pinThread(threadId){
        console.log("Thread is being pinned...");
        $.ajax({
            url: "{{route("thread.pin")}}",
            type: "POST",
            data: {
                thread_id: threadId,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var general_thread_container = "#gthread_container_"; //Main view container
                var general_thread_pin_icon = "#gpin_icon_"; //Main view icon
                var thread_container = "#thread_container_";
                var thread_pin_icon = "#pin_icon_";

                $(thread_container.concat(threadId)).toggleClass( "post-pinned" );
                $(thread_pin_icon.concat(threadId)).toggleClass("pinned");
                $(general_thread_container.concat(threadId)).toggleClass("post-pinned");
                $(general_thread_container.concat(threadId)).toggleClass("post-collapse");
                $(general_thread_pin_icon.concat(threadId)).toggleClass('pinned');
                
                
                
            },
            error: function(){
                console.log('Error on ajax call "setBookmark" function');
            }  
        });        
    }


    function filter(option){
        var threads = $(".non-pinned-threads-content").find(".post-container");
        switch (option){
            case 'oldest':
                threads.sort(function(a, b){
                    return $(a).attr("data-date")-$(b).attr("data-date")
                });
                $(".non-pinned-threads-content").html(threads);
                break;

            case 'newest':
                threads.sort(function(a, b){
                    return $(b).attr("data-date")-$(a).attr("data-date")
                });
                $(".non-pinned-threads-content").html(threads);
                break;
            defaul:
                console.log('Unspecified case');
                break;

        }
        
       

    }

    function search() {
        var searchInput = document.getElementById("searchThread");
        var filter = searchInput.value.toLowerCase();
        var threads = $(".non-pinned-threads-content").find(".post-container");
        console.log(threads);   

        /**
            Search by title, author and description. 
        */    
        
        for (i = 0; i < threads.length; i++) {
            if (threads[i].innerText.toLowerCase().includes(filter)) {
                var title = $(threads[i]).find('.post-details-autor').children("p:first").text();
                console.log('titulo %o ', title);

                $(threads[i]).show();
            } else {
                threads[i].style.display = "none";
            }
        }
    }
    


</script>