<div class="heading-section">
    @if ($user->account_activated == 0)
    @endif
    <button class="btn-add-basic button-position"
        @click="addTutorshipSession=!addTutorshipSession"
        @keydown.escape.window="addTutorshipSession=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Añadir contenido
    </button>
    <h1 class="primary-blue-color">Mi muro</h1>
</div>
<div class="wall-heading">
    <h2 id="wall-section-title-id" class="primary-blue-color wall-title">Currículum</h2>
    <input style="display:none;" id="input-section-title-id" type="text" name="title" placeholder="Título sección" value="Currículum"></input>
    <div class="container-options my-wall-options">
        <i onclick="editWallSection(1)" class="far fa-edit"></i>
        <i class="fas fa-trash"></i>
    </div>

</div>
<div class="text-container shadow-container my-wall">
    <div id="text-content-id" class="text-container-content my-wall-content">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris posuere arcu quam, ac ultricies enim mattis sed. Integer vestibulum ut nisi sit amet congue. Mauris lobortis orci a lectus viverra pharetra. Maecenas vitae massa rhoncus, aliquet sapien nec, vehicula quam. Mauris bibendum id felis ut imperdiet. Fusce justo mi, efficitur id dignissim eu, hendrerit non ex. Suspendisse risus justo, aliquet non luctus id, faucibus accumsan metus. Donec at dui odio. Proin sagittis, velit ut lacinia laoreet, felis lorem placerat ligula, et hendrerit mauris nulla vitae est. Proin interdum, ex quis vehicula interdum, urna mauris convallis justo, eu convallis turpis dui vel justo. In at nulla id ligula tristique auctor sed sed arcu. Nam tristique molestie neque. Pellentesque scelerisque id dui sit amet tincidunt.

            Cras pretium, tellus ac fermentum volutpat, neque purus suscipit sapien, id vulputate eros orci a justo. Donec ornare dignissim nunc, sit amet finibus nisi vulputate vitae. Maecenas vitae arcu vitae mi efficitur ornare ullamcorper at justo. Quisque turpis nibh, fermentum sollicitudin augue nec, fringilla ullamcorper arcu. Integer non tincidunt nisi, quis maximus lacus. Phasellus sed velit sem. Suspendisse sit amet dui aliquet ex cursus blandit. Donec lobortis orci at luctus pellentesque. Vestibulum nisi est, sollicitudin ut risus eget, auctor mollis ex.
            
            Duis maximus posuere lectus in bibendum. In placerat, sapien eu feugiat fringilla, turpis neque lobortis purus, sed accumsan dui ante eget lorem. Aliquam tristique augue commodo augue placerat commodo. Morbi quis lacus sit amet leo vulputate feugiat. Nulla tempus leo quis viverra rhoncus. Proin dapibus metus nisi, nec gravida risus fermentum vel. Phasellus et velit efficitur, sodales massa in, vehicula ante.</p>
    </div>
    <div id="wallQuillEditor-container-id" class='myWall-quillEditor'></div>
    <div id="wall-buttons-id" style="display:none;" class="wall-buttons">
        <button onclick="saveWallSectionChanges()" class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
        <button onclick="closeWallSectionEditor()" class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
    </div> 
</div>


<script>

    var quill = []; 

    function showMyWallQuillEditor(id){
        var description = $("#text-content-id").html();
        var html_quill_editor = "<div id='text-container-quillEditor-"+id+"'>"+description+"</div>";
        $('#wallQuillEditor-container-id').append(html_quill_editor);
        quill[id] = new Quill('#text-container-quillEditor-'.concat(id), {
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

    function editWallSection(id){
        console.log('estamos');

        //Hide content and show editor.
        $("#text-content-id").hide();
        $("#wall-buttons-id").show();
        $("#input-section-title-id").show();
        $("#wall-section-title-id").hide();

        showMyWallQuillEditor(id);

    }

    function saveWallSectionChanges(){
        $("#text-content-id").show();
        $("#wall-buttons-id").hide();
        $("#input-section-title-id").hide();
        $("#wall-section-title-id").show();
        destroyWallQuillEditor();
    }


    function destroyWallQuillEditor(){
        $('#wallQuillEditor-container-id').children().remove();
    }
</script>