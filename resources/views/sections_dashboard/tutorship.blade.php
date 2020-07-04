<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                @click="addTutorshipSession=!addTutorshipSession"
                @keydown.escape.window="addTutorshipSession=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Añadir tutoría
    </button>

    {{-- <form action="{{route('tutorship.toggleBookmark')}}" method="POST">
        @csrf
        <input type="text" name="user_id" value="22">
        <input type="text" name="id_tutorship" value="6">
        <button type="submit">pruebas</button>
    </form> --}}
    @endif
    <h1 class="primary-blue-color">Tutorías</h1>
    <div class="filter-options">
        <div class="filter-buttons" id="filter-buttons-tutorships">
            <button class="filter-btn filter-selected" onclick="filterTutorships('newest')">Más recientes</button>
            <button class="filter-btn" onclick="filterTutorships('oldest')">Más antiguos</button>
            <button class="filter-btn" onclick="filterTutorships('bookmarked')">Marcadas</button>
        </div>
        <div class="filter-search-bar">
            <input type="search" id="searchTutorship" autocomplete="off">

        </div>
        <div id="filter-status-tutorship" class="search-status" style="display: none;">
            <span>Actualmente no tienes ninguna tutoría marcada. </span>
        </div>
        <div id="search-status-tutorship" class="search-status" style="display: none;">
        </div>
    </div>
</div>
@include('modals.newTutorshipSession')
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
@endif
<!-- Create the editor container -->
<div id="all-tutorships-container">
    @foreach($user->athlete->tutorships->sortByDesc('created_at') as $key => $tutorship)
        {{-- @if($loop->first) --}}
    <div id="tutorship-container-{{$tutorship->id}}" class="tutorship-container {{$tutorship->bookmarked == 1 ? 'tutorship-bookmarked' : ''}} {{$loop->first ? '' : 'tutorship-collapse'}} shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}" data-date="{{$tutorship->created_at->timestamp}}" data-tutorshipId = "{{$tutorship->id}}">
        <div class="tutorship-heading">
            <div class="tutorship-heading-title" >
                <p id="paragraph_title_{{$tutorship->id}}" class="bold container-title"> 
                    <a class="collapse-button" onclick="toggleCollapse({{$tutorship->id}})"><i id="collapse_icon_{{$tutorship->id}}" class="far {{$loop->first ? 'fa-minus-square' : 'fa-plus-square'}}"></i></a>{{$tutorship->title}} <span id="tutorship_date" class="light">({{Date::createFromFormat('Y-m-d', $tutorship->date)->format('d/m/Y')}})</span> </p>
                <input style="display: none;" id="input_title_{{$tutorship->id}}" type="text" name="title" value="{{$tutorship->title}}"></input>
                <input style="display: none;" id="input_date_{{$tutorship->id}}" type="date" name="date" value="{{$tutorship->date}}"></input>
                <p id="paragraph_goal_{{$tutorship->id}}" class="tutorship-goal"><span class="tutorship-number"> #{{$tutorship->tutorship_number}} </span>{{$tutorship->goal}}</p>
                <input style="display: none;" id="input_goal_{{$tutorship->id}}" type="text" name="goal" value="{{$tutorship->goal}}"></input>
            </div>
            <div class="tutorship-options">
                <a id="anchor_edit_button_{{$tutorship->id}}" onclick="edit({{$tutorship->id}})"><i class="far fa-edit"></i></a>
                <a onclick="deleteTutorship({{$tutorship->id}})" style="margin-right: 15px;"><i class="fas fa-trash"></i></a>
                {{-- <a><i class="fas fa-edit"></i></a>
                <a><i class="far fa-bookmark"></i></a> --}}
                <a id="anchor-{{$tutorship->id}}" 
                    {{$tutorship->bookmarked == 1 ? 'class=tutorship-option-bookmarked':''}} 
                    onclick="setBookmark({{$tutorship->id}})">
                    <i 
                        id="icon-{{$tutorship->id}}" 
                        class="{{$tutorship->bookmarked == 1 ? 'fas ' : 'far '}}fa-bookmark">
                    </i>
                </a>
            </div>
            <div class="separation-tutorship"></div>
        </div>
        <div class="tutorship-content">
            <div class="tutorship-description">
                {{-- <textarea id="description_textarea_{{$tutorship->id}}" style="display: none;" name="description" rows="4" cols="50">{{$tutorship->description}}</textarea> --}}
                <div id="editor_container_{{$tutorship->id}}"></div>
                <div id="description_paragrahp_{{$tutorship->id}}" class="tutorship-section-content">
                    {!!$tutorship->description!!}
                </div>
            </div>
        </div>
        <div id="edit_buttons_{{$tutorship->id}}" style="display:none;" class="tutorship-buttons">
            <button onclick="savechanges({{$tutorship->id}})" class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
            <button onclick="close_editor({{$tutorship->id}})" class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
        </div> 
    </div>


    @endforeach
        
</div>
<script>

    var edit_status = 0; //Allows edit toggle between views. 
    // https://codepen.io/Joeao/pen/BdOGKV
    var numOfBookmarkedTutorships = {{getNumberOfTutorshipsWithBookmark()}};
    var quill = []; 
    var id_container= "#tutorship-container-";
    var id_title= "#paragraph_title_";
    var id_input_title = "#input_title_";
    var id_input_date = "#input_date_";
    var id_goal= "#paragraph_goal_";
    var id_input_goal = "#input_goal_";
    var id_textarea = "#description_textarea_";
    var id_add_details = "#add_details_";
    var id_div_edit_buttons = "#edit_buttons_";
    var id_description_paragraph = "#description_paragrahp_";
    var id_anchor = "#anchor_edit_button_";
    var id_title_paragraph = "#paragraph_title_";
    var id_goal_paragraph = "#paragraph_goal_";
    var editor_container = "#editor_container_";
    var collapse_icon = "#collapse_icon_";
    
    $("#searchTutorship").keyup(delay(function (e) {
        searchTutorships();
    }, 500));
    
    function setBookmark(tutorshipId){ 
        console.log("Bookmarked");
        $.ajax({
            url: "{{route("tutorship.toggleBookmark")}}",
            type: "POST",
            data: {
                id_tutorship: tutorshipId,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var id_icon = "#icon-".concat(tutorshipId);
                var id_anchor = "#anchor-".concat(tutorshipId);

                if ( $(id_container.concat(tutorshipId)).hasClass( "tutorship-bookmarked" )){
                    $(id_container.concat(tutorshipId)).removeClass("tutorship-bookmarked");
                    $(id_icon).removeClass("fas");
                    $(id_icon).addClass("far");
                    $(id_anchor).removeClass("tutorship-option-bookmarked");
                    numOfBookmarkedTutorships--;
                }else{
                    $(id_container.concat(tutorshipId)).addClass("tutorship-bookmarked");
                    $(id_icon).removeClass("far");
                    $(id_icon).addClass("fas");
                    $(id_anchor).addClass("tutorship-option-bookmarked");
                    numOfBookmarkedTutorships++;
                }
                
            },
            error: function(){
                console.log('Error on ajax call "setBookmark" function');
            }  
        });
    }

    function showQuillEditorContainer(tutorshipId){
        
        var description = $(id_description_paragraph.concat(tutorshipId)).html();
        var html_quill_editor = "<div id='quill-editor-"+tutorshipId+"'>"+description+"</div>";
        $(editor_container.concat(tutorshipId)).append(html_quill_editor);
        
        quill[tutorshipId] = new Quill('#quill-editor-'.concat(tutorshipId), {
        modules: {
        toolbar: [
            [{ 'header': 1 }, { 'header': 2 }, {'header': 3}],     
            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],        
            ['link'],

        ]     
        },
        placeholder: 'Empieza a escribir aquí...',
        theme: 'snow'  // or 'bubble'
        });
    }

    function destroyQuillEditorContainer(tutorshipId){
        $(editor_container.concat(tutorshipId)).children().remove();
        // $(".ql-toolbar").remove();
        // $(".ql-snow").remove();


    }

    function edit(tutorshipId){
        if (edit_status == 1){
            close_editor(tutorshipId);
            
        }else{
            console.log('Edit function');
            edit_status = 1; //Next time edit button is triggered, close_editor will be called. 
            //Show edit interface. 
            if ($(id_container.concat(tutorshipId)).hasClass("tutorship-collapse")){
                toggleCollapse(tutorshipId);
            }
            $(id_title.concat(tutorshipId)).hide();
            $(id_goal.concat(tutorshipId)).hide();
            $(id_description_paragraph.concat(tutorshipId)).hide();

            $(id_input_title.concat(tutorshipId)).show();
            $(id_input_goal.concat(tutorshipId)).show();
            $(id_input_date.concat(tutorshipId)).show();
            $(id_textarea.concat(tutorshipId)).show();
            $(id_add_details.concat(tutorshipId)).show();
            $(id_div_edit_buttons.concat(tutorshipId)).show();
            $(id_anchor.concat(tutorshipId)).addClass("activated");
            if ($(editor_container.concat(tutorshipId)).children("#quill-editor-".concat(tutorshipId)).length){
                close_editor(tutorshipId);
            }else{
                showQuillEditorContainer(tutorshipId);

            }
        }

    }

    function close_editor(tutorshipId){
        //Hide edit interface. 
        edit_status  = 0; 
        $(id_title.concat(tutorshipId)).show();
        $(id_goal.concat(tutorshipId)).show();
        $(id_description_paragraph.concat(tutorshipId)).show();

        $(id_input_title.concat(tutorshipId)).hide();
        $(id_input_goal.concat(tutorshipId)).hide();
        $(id_input_date.concat(tutorshipId)).hide();
        $(id_textarea.concat(tutorshipId)).hide();
        $(id_add_details.concat(tutorshipId)).hide();
        $(id_div_edit_buttons.concat(tutorshipId)).hide();
        $(id_anchor.concat(tutorshipId)).removeClass("activated");
        destroyQuillEditorContainer(tutorshipId);
    }


    // Save changes into database 
    function savechanges(tutorshipId){
        console.log("Saving changes into database...");

        var title = $(id_input_title.concat(tutorshipId)).val();
        var date = $(id_input_date.concat(tutorshipId)).val();
        var goal = $(id_input_goal.concat(tutorshipId)).val();
        var description = quill[tutorshipId].getLength() == 1 ? "<p>Esta tutoría no tiene contenido.</p>" : quill[tutorshipId].root.innerHTML;
        //quill.root.innerHTML;

        $.ajax({
            url: "{{route("tutorship.update")}}",
            type: "POST",
            data: {
                id_tutorship: tutorshipId,
                title: title,
                date: date, 
                goal: goal,
                description: description,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var date_noformat = new Date(Date.parse(date));
                var formatted_date = date_noformat.getDate() + "/" + (date_noformat.getMonth() + 1) + "/" + date_noformat.getFullYear();

                var title_updated = title.concat('<span id="tutorship_date" class="light"> ('+formatted_date+')</span>');
                var title_updated = '<a class="collapse-button" onclick="toggleCollapse('+tutorshipId+')"><i id="collapse_icon_'+tutorshipId+'" class="far fa-minus-square"></i></a>'.concat(title_updated);
                var tutorship_number = $(id_goal_paragraph.concat(tutorshipId)).children('.tutorship-number').text();
                var goal_updated = '<span class="tutorship-number">'+tutorship_number+'</span>'+goal;
            
                $(id_title_paragraph.concat(tutorshipId)).html(title_updated);
                $(id_goal_paragraph.concat(tutorshipId)).html(goal_updated);
                $(id_description_paragraph.concat(tutorshipId)).html(description);
                close_editor(tutorshipId);
                
            },
            error: function(){
                console.log('Error on ajax call "savechanges" function');
            }  
        });
        

    }

    function toggleCollapse(tutorshipId){
        if ($(id_container.concat(tutorshipId)).hasClass("tutorship-collapse")){
            $(id_container.concat(tutorshipId)).removeClass("tutorship-collapse");
            $(collapse_icon.concat(tutorshipId)).removeClass("fa-plus-square");
            $(collapse_icon.concat(tutorshipId)).addClass("fa-minus-square");

        }else{
            $(id_container.concat(tutorshipId)).addClass("tutorship-collapse");
            $(collapse_icon.concat(tutorshipId)).removeClass("fa-minus-square");
            $(collapse_icon.concat(tutorshipId)).addClass("fa-plus-square");


        }

    }

    function deleteTutorship(tutorshipId){
        console.log("Deleting tutorship...");

        $.ajax({
            url: "{{route("tutorship.destroy")}}",
            type: "POST",
            data: {
                id_tutorship: tutorshipId,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                $(id_container.concat(tutorshipId)).hide();
                
            },
            error: function(){
                console.log('Error on ajax call "deleteTutorship" function');
            }  
        });

    }

    function filterTutorships(option){
        var tutorships = $("#all-tutorships-container").find(".tutorship-container");
        var optionSelected = 0;

        collapseEverything(tutorships);
        $("#search-status-tutorship").hide();

        // !TODO
        tutorships.first().find('.fa-minus-square').addClass('fa-plus-square');
        tutorships.first().find('.fa-minus-square').removeClass();
        switch (option){

            case 'newest':
                $(tutorships).show();
                    
                if ($("#filter-status-tutorship").is(":visible")) $("#filter-status-tutorship").hide();
                tutorships.sort(function(a, b){
                    return $(b).attr("data-date")-$(a).attr("data-date")
                });
                $("#all-tutorships-container").html(tutorships);
                break;

            case 'oldest':
                $(tutorships).show();
                if ($("#filter-status-tutorship").is(":visible")) $("#filter-status-tutorship").hide();
                tutorships.sort(function(a, b){
                    return $(a).attr("data-date")-$(b).attr("data-date")
                });
                $("#all-tutorships-container").html(tutorships);
                optionSelected = 1;
                break;

            case 'bookmarked':
                optionSelected = 2;
                if (numOfBookmarkedTutorships > 0){
                    for (i = 0; i< tutorships.length; i++){
                        if ($(tutorships[i]).hasClass('tutorship-bookmarked')){
                            $(tutorships[i]).show();
                        }else{
                            $(tutorships[i]).hide();
                        }
                    }
                    tutorships.sort(function(a, b){
                        return $(b).attr("data-date")-$(a).attr("data-date")
                    });
                    $("#all-tutorships-container").html(tutorships);

                }else{
                    $(tutorships).hide();
                    $("#filter-status-tutorship").show();
                }
                break; 

            defaul:
                console.log('Unspecified case');
                break;

        }
        var buttons = $("#filter-buttons-tutorships").children("button");
        for (i=0; i < buttons.length; i++){
            $(buttons[i]).removeClass("filter-selected");
        }
        $(buttons[optionSelected]).addClass("filter-selected");


       

    }

    function collapseEverything(tutorships){
        for (i = 0; i < tutorships.length; i++){
            if (!$(tutorships[i]).hasClass('tutorship-collapse')){
                toggleCollapse($(tutorships[i]).attr('data-tutorshipId'));
            }
        }
    }


    function delay(fn, ms) {
        let timer = 0
        return function(...args) {
            clearTimeout(timer)
            timer = setTimeout(fn.bind(this, ...args), ms || 0)
        }
    }

    function searchTutorships() {
        var searchInput = document.getElementById("searchTutorship");
        var filter = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        var tutorships = $("#all-tutorships-container").find(".tutorship-container");
        var filter_option = $( "#filter_option_tutorship option:selected" ).val();
        var numOfResults = 0; 
        var numOfOccurrences = 0;
        $(tutorships).unmark();
        
        
        /**
         Search by title, author and description. 
         */    
        for (i = 0; i < tutorships.length; i++) {
            var heading = $(tutorships[i]).find('.tutorship-heading-title').text().normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/(\r\n|\n|\r)/gm,"").toLowerCase().trim();
            var number = $(tutorships[i]).find('.tutorship-goal').children("span:first").text().normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().trim();
            var goal = $(tutorships[i]).find('.tutorship-goal').text().replace(number, '').normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().trim();
            var content = $(tutorships[i]).find('.tutorship-section-content').text().normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().trim();

       
            if (heading.includes(filter) || content.includes(filter)) {
                $(tutorships[i]).show();
                $(tutorships[i]).mark(filter, 
                        {"done": function(counter){
                            numOfOccurrences += counter; 
                        },
                    });
                
                if ($(tutorships[i]).hasClass("tutorship-collapse")){
                    toggleCollapse($(tutorships[i]).attr('data-tutorshipId'));
                }
                
                numOfResults++;
            } else {
                $(tutorships[i]).hide();
            }
         

        }
                     
        
        /*
            Showing/Hiding search input.
        */
        if (searchInput.value.length != 0){
            $("#search-status-tutorship").show();
            if (numOfOccurrences > 0){
                var html = '<p>Mostrando <span id="numOfOccurrences-tutorship">'+numOfOccurrences+'</span>'+ (numOfOccurrences == 1 ? ' coincidencia ' : ' coincidencias ') + 'en <span id="numOfTutorships">'+numOfResults+'</span> '+(numOfResults == 1 ? ' tutoría':' tutorías diferentes')+'.</p>';

            }else{
                var html = '<p>No se han encontrado resultados para "<span>'+$(searchInput).val()+'</span>"</p>';
            }

            $("#search-status-tutorship").html(html);


        }else{
            $("#search-status-tutorship").hide();

        }
    }
    

</script>