<div class="heading-section">
    @if ($user->account_activated == 1)
    <button id="add-btn-forum" class="btn-add-basic button-position"
                @click="openNewThreadForm=!openNewThreadForm"
                @keydown.escape.window="openNewThreadForm=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Nuevo hilo
    </button>

    {{-- <form action="{{route('reply.destroy')}}" method="POST">
        @csrf
        <input type="text" name="reply_id" value="3">
        {{-- <input type="text" name="description" value="Prueba">
        <input type="text" name="author" value="{{Auth::user()->id}}"> --}}
        {{-- <button type="submit">pruebas</button> --}}
    {{-- </form> --}} 
    @endif

    <h1 id="forum-header" class="primary-blue-color">Ficheros</h1>
 
</div>
<h2 class="primary-blue-color">Subida/Descarga de ficheros</h2>
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
    
@endif
<progress value="0" max="100" id="uploader">0%</progress>
<input id="file-upload" multiple name="fileuploaded[]" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
<button onclick="uploadFile()">Subir</button>

{{-- <form action="{{route('profile.uploadFile')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <label for="file-upload">Subir fichero</label>
    <input name="user_id" value="{{Auth::user()->id}}">
</form> --}}

<h2 class="primary-blue-color">Ficheros de {{$user->name. ' '. $user->surname}}</h2>
<table id="files-table" class="fee-table">
    <thead>
        <tr>
            <th>Nombre del fichero</th>
            <th>Descripción</th>
            <th>Formato</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>curriculum.pdf</td>
            <td>Mi curriculum</td>
            <td>PDF</td>
            <td>
                <button>Ver</button>
                <button>Eliminar</button>
            </td>
        </tr>
        <tr>
            <td>test_esfuerzo.pdf</td>
            <td>Mi curriculum</td>
            <td>PDF</td>
            <td>
                <button>Ver</button>
                <button>Eliminar</button>
            </td>
        </tr>
        <tr>
            <td>pruebas2020.pdf</td>
            <td>Mi curriculum</td>
            <td>PDF</td>
            <td>
                <button>Ver</button>
                <button>Eliminar</button>
            </td>
        </tr>
            
        
    </tbody>
</table>

<h2 class="primary-blue-color">Ficheros compartidos con {{$user->name. ' '. $user->surname}}</h2>

<script>
    $(document).ready(function() {
    $('#files-table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [1,2,3] },
            { "searchable": false, "targets": 0 }
        ],
        "bFilter": false
        });
    } );

    function uploadFile(){
        //Get file 
        var file = document.getElementById("file-upload").files[0];
        

        //Create storage ref
        var storageRef = firebase.storage().ref('prueba/prueba2.jpg');

        //Upload file 
        var task = storageRef.put(file);

        //Update progress bar
        var uploader = document.getElementById("uploader");

        task.on('state_changed', 
            function progress(snapshot){
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
                uploader.value = progress;
            },

            function error(err){

            },

            function complete(){
                alert("Se ha subido el fichero");
                task.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                    console.log('File available at', downloadURL);
                });
            }
        );


    }

</script>