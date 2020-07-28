<div class="heading-section">
    @if (isset($user))
        @if ($user->account_activated == 1)
        <button id="add-btn-forum" class="btn-add-basic button-position"
                    @click="openNewThreadForm=!openNewThreadForm"
                    @keydown.escape.window="openNewThreadForm=false">
            <i style="margin-right: 5px;" class="fas fa-plus"></i> Nuevo hilo
        </button>
        @endif
    @else
        <button id="add-btn-forum" class="btn-add-basic button-position"
                    @click="openNewThreadForm=!openNewThreadForm"
                    @keydown.escape.window="openNewThreadForm=false">
            <i style="margin-right: 5px;" class="fas fa-plus"></i> Nuevo g hilo
        </button>
    @endif
    <h1 id="forum-header" class="primary-blue-color">Foro</h1>
 
</div>
@if(isset($user))
@include('modals.addNewThread')
@else
@include('modals.addNewThreadToGroup')
@endif

<div id="forum-page-message" style="display: {{$threads->count() == 0 ? '' : 'none'}};">
    @include('page_messages.threads_not_available_message')
</div>

@if($threads->count() > 0)

<div id="open-thread-container">
</div>
<div id="thread-content">
    <div class="pinned-threads" style="{{($threads->filter->pinned)->isEmpty() ? 'display:none;' : ''}}">
        <h2 class="primary-blue-color">Hilo fijado</h2>
        @if (($threads->filter->pinned)->isNotEmpty())
            @include('common_sections.components.threadComponent', ["thread" => ($threads->filter->pinned)->first(), "generalThreadView" => true])
        @endif
    </div>
    <div class="non-pinned-threads" >
        <div class="filter-options">
            <div class="filter-buttons" id="filter-buttons-forum">
                <button class="filter-btn filter-selected" onclick="filter('newest')">Más recientes</button>
                <button class="filter-btn" onclick="filter('oldest')">Más antiguos</button>
            </div>
            <div class="filter-search-bar">
                <input type="search" id="searchThread" onkeyup="search()" placeholder="Buscar...">
                <select id="filter_option">
                    <option value="title">Título</option>
                    <option value="author">Autor</option>
                </select>

            </div>
            <div id="search-status" class="search-status" style="display: none">
                <p>Mostrando <span id="numOfResults"></span> resultados para "<span id="search_value"></span>". </p>

            </div>
        </div>
        <div id="non-pinned-threads-content" class="non-pinned-threads-content">
            @if($threads->count() != 0)
            @foreach ($threads->filter(function($thread){return $thread->pinned==0;})->sortDesc() as $thread)
                @include('common_sections.components.threadComponent', ["thread" => $thread, "generalThreadView" => true])
            @endforeach
            @endif
        </div>

    </div>
</div>
@endif
<script>
    var totalThreads; 

    $(document).ready(function(){
        totalThreads = {{$threads->count()}};
    });

    function goToThreads(thread_id){
        console.log('abrimos thread');
        $("#open-thread-container").load( "/thread/".concat(thread_id));
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
        updateNotificationLogJson(thread_id, 'forum');

    }

    function closeThread(){
        $("#forum-header").text("Foro");
        $(".post-container").fadeIn(500);
        $("#add-btn-forum").fadeIn(500);
        if ($(".pinned-threads").children(".post-container").length){
            $(".pinned-threads").fadeIn(500);
        }
        $(".non-pinned-threads").fadeIn(500);
        $("#forum-header").removeAttr("onclick");
        $("#forum-header").removeClass("clickable");
        $( "#open-thread-container" ).fadeOut(500);
        $( "#open-thread-container").empty();

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
                totalThreads--; 
                if (totalThreads == 0){
                    $("#forum-page-message").show();
                    $("#thread-content").hide();

                }
                
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

                /*
                    JS interface cases 
                    1. 'Pinned post' to 'Unpinned post'
                    2. 'Unpinned post' to 'Pinned post' 
                    3. 'Pinned post 1' to 'Pinned post 2' (Pinned post swap)
                */

                if ($(".pinned-threads").is(":visible")){
                    // CASE 1 Removing pinned thread. 
                    if ($(general_thread_container.concat(threadId)).hasClass("post-pinned")){
                        $("#non-pinned-threads-content").prepend($(".pinned-threads").children(".post-container"));
                        $(".pinned-threads").hide();
                    }else{
                        //CASE 3
                        $(".pinned-threads").children(".post-container").toggleClass('post-pinned');
                        $(".pinned-threads").children(".post-container").toggleClass('post-collapse');
                        $(".pinned-threads").children(".post-container").find('.pinned').toggleClass('pinned');
                        $("#non-pinned-threads-content").prepend($(".pinned-threads").children(".post-container"));
                        $(".pinned-threads").append($(general_thread_container.concat(threadId)));
                        $(".pinned-threads").show();
                    }

                }else{
                    //Cases if the pin command is issued from an open thread. 
                    if($("#open-thread-container").children().length != 0){
                        if ($(".pinned-threads").has(".post-container").length){
                            // CASE 1 Removing pinned thread. 
                            if ($(general_thread_container.concat(threadId)).hasClass("post-pinned")){
                                $("#non-pinned-threads-content").prepend($(".pinned-threads").children(".post-container"));
                                $(".pinned-threads").hide();
                                console.log("Case 1");
                            }else{
                                //CASE 3
                                $(".pinned-threads").children(".post-container").toggleClass('post-pinned');
                                $(".pinned-threads").children(".post-container").toggleClass('post-collapse');
                                $(".pinned-threads").children(".post-container").find('.pinned').toggleClass('pinned');
                                $("#non-pinned-threads-content").prepend($(".pinned-threads").children(".post-container"));
                                $(".pinned-threads").append($(general_thread_container.concat(threadId)));
                        }

                        }else{
                            $(".pinned-threads").append($(general_thread_container.concat(threadId)));
 
                        }

                    }else{
                        // CASE 2 
                        $(".pinned-threads").append($(general_thread_container.concat(threadId)));
                        $(".pinned-threads").show();

                    }
                }
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
        var optionSelected = 0;
        switch (option){
            case 'newest':
                threads.sort(function(a, b){
                    return $(b).attr("data-date")-$(a).attr("data-date")
                });
                $(".non-pinned-threads-content").html(threads);
                break;

            case 'oldest':
                threads.sort(function(a, b){
                    return $(a).attr("data-date")-$(b).attr("data-date")
                });
                $(".non-pinned-threads-content").html(threads);
                optionSelected=1; 
                break;

            defaul:
                console.log('Unspecified case');
                break;

        }
        var buttons = $("#filter-buttons-forum").children("button");
        for (i=0; i < buttons.length; i++){
            $(buttons[i]).removeClass("filter-selected");
        }
        $(buttons[optionSelected]).addClass("filter-selected");

       

    }

    function search() {
        var searchInput = document.getElementById("searchThread");
        var filter = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        var threads = $(".non-pinned-threads-content").find(".post-container");
        var filter_option = $( "#filter_option option:selected" ).val();
        var numOfResults = 0; 
        
        /**
            Search by title, author and description. 
        */    
        for (i = 0; i < threads.length; i++) {
        var title = $(threads[i]).find('.post-details-autor').children("p:first").text().normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
        var date = $(threads[i]).find('.post-details-autor').children("p:nth-child(2)").children("span:first").children("span:first").text();
        var author = $(threads[i]).find('.post-details-autor').children("p:nth-child(2)").children("span:first").text().replace(date, '').normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    
            switch (filter_option){
                case 'title':
                    if (title.includes(filter)) {
                        $(threads[i]).show();
                        numOfResults++;
                    } else {
                        $(threads[i]).hide();
                    }
                    break;
                case 'author':
                    if (author.includes(filter)) {
                        $(threads[i]).show();
                        numOfResults++;
                    } else {
                        $(threads[i]).hide();
                    }                
                    break;
                }            
        
        }
        /*
            Showing/Hiding search input.
        */
        if (searchInput.value.length != 0){
            $("#search-status").show().find("#search_value").text(searchInput.value);
            $("#search-status").find("#numOfResults").text(numOfResults);

        }else{
            $("#search-status").hide().find("#search_value").text(searchInput.value);

        }
    }
    


</script>