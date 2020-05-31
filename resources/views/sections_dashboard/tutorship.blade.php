<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                @click="addTutorshipSession=!addTutorshipSession" 
                @keydown.escape.window="addTutorshipSession=false">
        <i style="margin-right: 10px;" class="fas fa-people-arrows"></i> Añadir tutoría
    </button>

    {{-- <form action="{{route('tutorship.toggleBookmark')}}" method="POST">
        @csrf
        <input type="text" name="user_id" value="22">
        <input type="text" name="id_tutorship" value="6">
        <button type="submit">pruebas</button>
    </form> --}}
    @endif
    <h1 class="primary-blue-color">Tutorías</h1>
</div>
@include('modals.newTutorshipSession')
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
@endif
<!-- Create the editor container -->

{{-- <div id="editor1">
</div> --}}
  

@foreach($user->athlete->tutorships->sortByDesc('created_at') as $key => $tutorship)
    {{-- @if($loop->first) --}}
        <div id="tutorship-container-{{$tutorship->id}}" class="tutorship-container {{$tutorship->bookmarked == 1 ? 'tutorship-bookmarked' : ''}} shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
            <div class="tutorship-heading">
                <div class="tutorship-heading-title">
                    <p id="paragraph_title_{{$tutorship->id}}" class="bold container-title">{{$tutorship->title}} <span id="tutorship_date" class="light">({{Date::createFromFormat('Y-m-d', $tutorship->date)->format('d/m/Y')}})</span> </p>
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
                    <p class="tutorship-section-title">Descripción</p>
                    <textarea id="description_textarea_{{$tutorship->id}}" style="display: none;" name="description" rows="4" cols="50">{{$tutorship->description}}</textarea>
                    <p id="description_paragrahp_{{$tutorship->id}}" class="tutorship-section-content">{{$tutorship->description}}</p>
                </div>
            </div>
            <div id="add_details_{{$tutorship->id}}" style="display:none;" class="tutorship-add-details">
                <button>Añadir detalles</button>
            </div>
            <div id="edit_buttons_{{$tutorship->id}}" style="display:none;" class="tutorship-buttons">
                <button onclick="savechanges({{$tutorship->id}})" class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
                <button onclick="close_editor({{$tutorship->id}})" class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
            </div> 
        </div>
        
@endforeach


{{-- <div class="tutorship-container tutorship-collapse shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
    <div class="tutorship-heading">
        <div class="tutorship-heading-title">
            <p class="bold container-title">Título de tutoría  <span id="tutorship_date" class="light">(26/05/2020)</span> </p>
            <p class="tutorship-goal"><span class="tutorship-number"> #1 </span>Tutoría inicial. Empieza a entrenar.</p>
        </div>
        <div class="tutorship-options">
            <a><i class="far fa-edit"></i></a>
            <a><i class="fas fa-edit"></i></a>
            <a><i class="far fa-bookmark"></i></a>
            <a><i class="fas fa-bookmark"></i></a>
        </div>
        <div class="separation-tutorship"></div>
    </div>
    <div class="tutorship-content">
        <div class="tutorship-description">
            <p class="tutorship-section-title">Descripción</p>
            <p class="tutorship-section-content">Analizamos planing Julio y Agosto: bien, las series bien. Nota mejoría en pulsaciones, le han bajado y se mantiene en la zona.
                Días de descanso? LUNES Y MIÉRCOLES.
                Actividad en Tenerife
                Objetivos de Artenara y Summer run no llegamos, son sólo test.
                Marcar zonas de entrenamiento en base a test de esfuerzo. Test de Cooper.
                Empieza con rutinas básicas de gimnasio. Más adelante metemos las SESIONES.
                En el primer mes construimos base aeróbica.
                Pasar número de cuenta BBVA. Paga Junio ya por transferencia.
                Se hizo test de esfuerzo muy básico, voy a tener que hacerle test de campo.
                35018
                En 150 y 170 ppm no se encuentra mal. Va a 6´el km a gusto.
                Fechas de Julio normal.
            </p>
        </div>
        <div class="tutorship-description">
            <p class="tutorship-section-title">A tener en cuenta</p>
            <p class="tutorship-section-content">Prefiere lunes y miércoles de descanso.</p>
        </div>
        <div class="tutorship-description">
            <p class="tutorship-section-title">Pendiente</p>
            <p class="tutorship-section-content">Enviarme analítica.</p>
        </div>
        
    </div>
    <div class="tutorship-add-details">
        <button>Añadir detalles</button>
    </div>
    <div class="tutorship-buttons">
        <button class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
        <button class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
    </div>
</div> --}}
<script>

    var edit_status = 0; //Allows edit toggle between views. 
    var quill = new Quill('#editor1', {
        modules: {
        toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
        ]       
        },
        placeholder: 'Compose an epic...',
        theme: 'snow'  // or 'bubble'
    });
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
                }else{
                    $(id_container.concat(tutorshipId)).addClass("tutorship-bookmarked");
                    $(id_icon).removeClass("far");
                    $(id_icon).addClass("fas");
                    $(id_anchor).addClass("tutorship-option-bookmarked");
                }
                
            },
            error: function(){
                console.log('Error on ajax call "setBookmark" function');
            }  
        });
    }

    function edit(tutorshipId){
        if (edit_status == 1){
            close_editor(tutorshipId);
            
        }else{
            console.log('Edit function');
            edit_status = 1; //Next time edit button is triggered, close_editor will be called. 
            //Show edit interface. 
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
    }


    // Save changes into database 
    function savechanges(tutorshipId){
        console.log("Saving changes into database...");

        var title = $(id_input_title.concat(tutorshipId)).val();
        var date = $(id_input_date.concat(tutorshipId)).val();
        var goal = $(id_input_goal.concat(tutorshipId)).val();
        var description = $(id_textarea.concat(tutorshipId)).val();

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

                var title_updated = title.concat(' <span id="tutorship_date" class="light">('+formatted_date+')</span>');
                var tutorship_number = $(id_goal_paragraph.concat(tutorshipId)).children('.tutorship-number').text();
                var goal_updated = '<span class="tutorship-number">'+tutorship_number+'</span>'+goal;
            
                $(id_title_paragraph.concat(tutorshipId)).html(title_updated);
                $(id_goal_paragraph.concat(tutorshipId)).html(goal_updated);
                $(id_description_paragraph.concat(tutorshipId)).text(description);
                close_editor(tutorshipId);
                
            },
            error: function(){
                console.log('Error on ajax call "savechanges" function');
            }  
        });
        

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
</script>