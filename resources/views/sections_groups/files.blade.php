<div class="heading-section">
    <button id="add-btn-forum" class="btn-add-basic button-position"
                @click="uploadFile=!uploadFile"
                @keydown.escape.window="uploadFile=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Subir archivo
    </button>

    <h1 id="forum-header" class="primary-blue-color">Archivos</h1>

    @include('modals.uploadFile', ['isGroup' => true])

 
</div>


{{-- <form action="{{route('profile.uploadFile')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <label for="file-upload">Subir fichero</label>
    <input name="user_id" value="{{Auth::user()->id}}">
</form> --}}
<div class="general-file-table-container">
    <div class="file-table-container">
        <h2 class="primary-blue-color">Archivos del grupo</h2>
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
                
                @foreach(getGroupFiles($group->id) as $key => $file)
                <tr>
                    <td>{{$file->file_name}}</td>
                    <td>Sin descripción</td>
                    <td>{{strtoupper($file->extension)}}</td>
                    <td>
                        <button onclick="window.open('{{$file->url}}','_blank')">Ver</button>
                        {{-- @if (Auth::user()->id == $user->id) --}}
                        <button onclick="deleteUserFile({{Auth::user()->id}}, {{$file->file_name .'.'.$file->extension}}, {{$file->id}})">Eliminar</button>
                        {{-- @endif --}}
                    </td>
                </tr>     
                @endforeach

            </tbody>
        </table>
    </div>

</div>

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

</script>