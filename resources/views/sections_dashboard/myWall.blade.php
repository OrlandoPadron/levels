<div class="heading-section">
    @if ($user->account_activated == 0)
    @endif
    @if ($user->id == Auth::user()->id)
    <button type="submit" form="addSectionToWallForm" class="btn-add-basic button-position">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Añadir sección
    </button>
    <h1 class="primary-blue-color">Mi muro</h1>
    @else
    <h1 class="primary-blue-color">Muro de {{$user->name}}</h1>

    @endif
</div>

<form action="{{route('user.myWall')}}" method="POST" id="addSectionToWallForm">
    @csrf
    <input type="text" name="method" hidden value="newSection">
</form>

<div id="my-wall-page-message" style="display: {{count(getUserWall($user->id)) == 0 ? '' : 'none'}};">
    @include('page_messages.my_wall_info')
</div>


@foreach(getUserWall($user->id) as $id => $wall)
<div id="wall-container-{{$id}}" class="wall-container">
    <div class="wall-heading">
        <h2 id="wall-section-title-{{$id}}" class="primary-blue-color wall-title">{{$wall['title']}}</h2>
        <div class="wall-title-container">
            <input style="display:none;" id="input-section-title-{{$id}}" type="text" name="title" placeholder="Título sección" value="{{$wall['title']}}"></input>
            <div id="wall-position-{{$id}}" class="wall-position" style="display: none;">
                <label for="position">Posición</label>
                <select onchange="changeSectionOrder({{$id}})" id="section-position-{{$id}}" name="position">
                    @for($i = 1; $i <= getUserWallElements($user->id); $i++)
                    <option value="{{$i}}" {{$wall['position'] == $i ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
        @if ($user->id == Auth::user()->id)
        <div class="container-options my-wall-options">
            <i onclick="editWallSection({{$id}})" class="far fa-edit"></i>
            <i onclick="if (confirm('¿Deseas eliminar la sección \'{{$wall['title']}}\'?')) {
                deleteWallSection({{$id}},{{$user->id}})}" class="fas fa-trash"></i>
        </div>
        @endif
    </div>
    <div class="my-wall shadow-container ">
        <div id="text-content-{{$id}}" class="text-container-content my-wall-content">
            <p>{!!$wall['content']!!}</p>
        </div>
        <div id="wallQuillEditor-container-{{$id}}" class='myWall-quillEditor'></div>
        <div id="wall-saving-buttons-{{$id}}" style="display:none;" class="wall-buttons">
            <button onclick="saveWallSectionChanges({{$id}})" class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
            <button onclick="closeWallEditMode({{$id}})" class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
        </div> 
    </div>

</div>
@endforeach



<script>

    var editMode = [];
    var quill = []; 
    var newSectionOrder = [];
    var totalSections = 0; 

    $(document).ready(function(){
        totalSections = {{count(getUserWall($user->id))}};
    });

    function showMyWallQuillEditor(id){
        var description = $("#text-content-".concat(id)).html();
        var html_quill_editor = "<div id='text-container-quillEditor-"+id+"'>"+description+"</div>";
        $('#wallQuillEditor-container-'.concat(id)).append(html_quill_editor);
        quill[id] = new Quill('#text-container-quillEditor-'.concat(id), {
            modules: {
            toolbar: [
                [{ 'header': 1 }, { 'header': 2 }, {'header': 3}],     
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

    function editWallSection(id){

        if (editMode[id] == undefined || editMode[id] == false){
            editMode[id] = true; 

            //Hide content and show editor.
            $("#text-content-".concat(id)).hide();
            $("#wall-saving-buttons-".concat(id)).show();
            $("#input-section-title-".concat(id)).show();
            $("#wall-position-".concat(id)).show();
            $("#wall-section-title-".concat(id)).hide();

            showMyWallQuillEditor(id);
        }else{
            editMode[id] = false; 
            closeWallEditMode(id);

        }

    }

    function saveWallSectionChanges(id){
        //Getting new changes. 
        var title = $('#input-section-title-'.concat(id)).val();
        // console.log(title);
        var content = quill[id].getLength() == 1 ? "<p>Sin contenido.</p>" : quill[id].root.innerHTML;
        var newPosition = "-1"; 
                
        if (typeof newSectionOrder[id] !== 'undefined'){
            newPosition = newSectionOrder[id]; 
        }

        $.ajax({
            url: "{{route("user.myWall")}}",
            type: "POST",
            data: {
                id: id,
                title: title,
                content: content, 
                method: 'updateSection',
                newPosition: newPosition,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                
                //Updating and showing changes into UI. 
                $("#text-content-".concat(id)).html(content);
                $("#wall-section-title-".concat(id)).text(title);
                if (newPosition != "-1"){
                    location.reload();
                }else{
                    closeWallEditMode(id);

                }
                
            },
            error: function(callback){
                console.log(callback);
                console.log('Error on ajax call "saveWallSectionChanges" function');
            }  
        });


    }


    function deleteWallSection(id, userId){
        $.ajax({
            url: "{{route("user.myWall")}}",
            type: "POST",
            data: {
                id: id,
                userId: userId,
                method: 'deleteSection',
                _token: "{{csrf_token()}}",
            },
            success: function(){
                $('#wall-container-'.concat(id)).hide();
                totalSections--;
                if(totalSections == 0){
                    $('#my-wall-page-message').show();
                }
            },
            error: function(){
                console.log('Error on ajax call "deleteWallSection" function');
            }  
        });
    }

    function closeWallEditMode(id){
        $("#text-content-".concat(id)).show();
        $("#wall-saving-buttons-".concat(id)).hide();
        $("#input-section-title-".concat(id)).hide();
        $("#wall-position-".concat(id)).hide();
        $("#wall-section-title-".concat(id)).show();
        destroyWallQuillEditor(id); 
    }

    function destroyWallQuillEditor(id){
        $('#wallQuillEditor-container-'.concat(id)).children().remove();
    }

    function changeSectionOrder(id){
        newSectionOrder[id]= $("#section-position-".concat(id)).children("option:selected").val();

        
    }

</script>