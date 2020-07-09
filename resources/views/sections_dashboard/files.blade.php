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
<input id="file-upload" name="fileuploaded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
<button onclick="uploadFile({{Auth::user()->id}}, {{$user->id}})">Subir</button>

{{-- <form action="{{route('profile.uploadFile')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <label for="file-upload">Subir fichero</label>
    <input name="user_id" value="{{Auth::user()->id}}">
</form> --}}

<h2 class="primary-blue-color">Ficheros de {{$user->name. ' '. $user->surname}}</h2>
<table id="files-table" class="fee-table file-datatable">
    <thead>
        <tr>
            <th>Nombre del fichero</th>
            <th>Descripción</th>
            <th>Formato</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($userFiles as $key => $file)
        <tr>
            <td>{{$file->file_name}}</td>
            <td>Sin descripción</td>
            <td>{{strtoupper($file->extension)}}</td>
            <td>
                <button onclick="window.open('{{$file->url}}','_blank')">Ver</button>
                <button>Eliminar</button>
            </td>
        </tr>     
        @endforeach
            
        
    </tbody>
</table>

<h2 class="primary-blue-color">Ficheros compartidos con {{$user->name. ' '. $user->surname}}</h2>
<table id="files-table2" class="fee-table file-datatable">
    <thead>
        <tr>
            <th>Nombre del fichero</th>
            <th>Descripción</th>
            <th>Formato</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach(getFilesSharedWithUser(Auth::user()->files, $user->id) as $key => $file)
        <tr>
            <td>{{$file->file_name}}</td>
            <td>Sin descripción</td>
            <td>{{strtoupper($file->extension)}}</td>
            <td>
                <button onclick="window.open('{{$file->url}}','_blank')">Ver</button>
                <button>Eliminar</button>
            </td>
        </tr>     
        @endforeach
            
        
    </tbody>
</table>
<script>
    $(document).ready(function() {
    $('.file-datatable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [1,2] },
            { "searchable": false, "targets": 0 }
        ],
        "bFilter": false
        });
    } );

    function pruebas(time){

    }

    function uploadFile(fileOwnerUserId, sharedWithUserId){
        //Get file 
        var file = document.getElementById("file-upload").files[0];

        //Create storage ref
        var storageRef = firebase.storage().ref('users/'+fileOwnerUserId+'/files/'+ file.name);

        // Auth
        firebase.auth().signInAnonymously().catch(function(error) {
            // Handle Errors here.
            var errorCode = error.code;
            var errorMessage = error.message;
            console.log("Error " + errorCode + ' ' + errorMessage);
        });

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
                console.log(err.message_);

            },

            function complete(){
                task.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                    console.log('File available at', downloadURL); 
                    saveFileReferenceIntoDatabase(file, fileOwnerUserId, sharedWithUserId, downloadURL);
                });
            }
        );


    }

    function saveFileReferenceIntoDatabase(file, fileOwnerUserId, sharedWithUserId, downloadURL){
        var fileName = file.name.split('.').slice(0, -1).join('.');
        var fileExtension = file.name.split('.').pop();
        $.ajax({
            url: "{{route("userFile.store")}}",
            type: "POST",
            data: {
                file_name: fileName,
                extension: fileExtension,
                size: file.size,
                url: downloadURL,
                owned_by: fileOwnerUserId,
                shared_with: sharedWithUserId,

                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert("Su archivo '" + fileName +"' se ha subido correctamente."); 
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "saveFileReferenceIntoDatabase" function');
            }  
        });
    }

</script>