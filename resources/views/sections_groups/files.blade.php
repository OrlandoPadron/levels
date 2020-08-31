<div class="heading-section">
    <button id="add-btn-forum" class="btn-gray-basic button-position" style="margin-left: 10px;"
    @click="shareFile=!shareFile"
    @keydown.escape.window="shareFile=false">
    <i style="margin-right: 2px;" class="fas fa-share-square"></i> Compartir archivo
    </button>
    <button id="add-btn-forum" class="btn-add-basic button-position"
                @click="uploadFile=!uploadFile"
                @keydown.escape.window="uploadFile=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Subir archivo
    </button>
    <h1 id="forum-header" class="primary-blue-color">Archivos</h1>

    @include('modals.uploadGroupFile')
    @include('modals.shareFileWithGroup')

 
</div>

<div class="general-file-table-container">
    <div class="file-table-container">
        <h2 class="primary-blue-color">Archivos del grupo</h2>
        <table id="files-table" class="fee-table file-datatable">
            <thead>
                <tr>
                    <th>Nombre del archivo</th>
                    <th>Formato</th>
                    <th>Propietario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                $userLoggedRole = getUserRole($group->id, Auth::user()->id);
                @endphp
                @foreach(getGroupFiles($group->id) as $key => $file)
                <tr>
                    @php
                        $owned_by = $file->user->name . ' ' . $file->user->surname;
                    @endphp
                    <td>{{$file->file_name}}</td>
                    <td>{{strtoupper($file->extension)}}</td>
                    <td>{{$owned_by}}</td>
                    <td>
                        <button onclick="window.open('{{$file->url}}','_blank')">Ver</button>
                        @if(Auth::user()->id == $file->owned_by || $userLoggedRole == 'Propietario' || $userLoggedRole == 'Administrador')
                        <button onclick="
                        if (confirm('¿Deseas dejar de compartir \'{{$file->file_name}}\' con el grupo?')) {
                            stopSharingGroupFile({{$group->id}}, {{$file->id}}, '{{$file->file_name .'.'.$file->extension}}')}">Eliminar</button>
                        @endif
                        
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
            { "orderable": false, "targets": [3] },
            { "searchable": false, "targets": 0 }
        ],
        "bFilter": false
        });
    } );

</script>