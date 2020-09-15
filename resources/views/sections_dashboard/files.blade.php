<div class="heading-section">
    @if ($user->account_activated == 1)
    @if(Auth::user()->id != $user->id)
        <button id="add-btn-forum" class="btn-gray-basic button-position" style="margin-left: 10px;"
        @click="shareFile=!shareFile"
        @keydown.escape.window="shareFile=false">
        <i style="margin-right: 2px;" class="fas fa-share-square"></i> Compartir archivo
        </button>
    @endif
        <button id="add-btn-forum" class="btn-add-basic button-position"
                    @click="uploadFile=!uploadFile"
                    @keydown.escape.window="uploadFile=false">
            <i style="margin-right: 5px;" class="fas fa-plus"></i> Subir archivo
        </button>
    @endif

    <h1 id="forum-header" class="primary-blue-color">Archivos</h1>

    @include('modals.uploadFile')
    @if(Auth::user()->id != $user->id)
    @include('modals.shareFile')
    @endif

 
</div>

<div class="general-file-table-container">
    <div class="file-table-container">
        @if(Auth::user()->id == $user->id)
        <h2 class="primary-blue-color">Tus archivos</h2>
        @else
        <h2 class="primary-blue-color">Archivos de {{$user->name. ' '. $user->surname}}</h2>
        @endif
        <table id="files-table" class="fee-table file-datatable">
            <thead>
                <tr>
                    <th>Nombre del archivo</th>
                    <th>Formato</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userFiles->filter(function($file){
                    if ($file->file_type != 1) return $file;
                }) as $key => $file)
                <tr>
                    <td>{{$file->file_name}}</td>
                    <td>{{strtoupper($file->extension)}}</td>
                    <td>
                        <button onclick="window.open('{{$file->url}}','_blank')">Ver</button>
                        @if (Auth::user()->id == $user->id)
                        <button onclick="
                        if (confirm('¿Deseas eliminar el archivo \'{{$file->file_name}}\'?')) {
                            deleteUserFile({{Auth::user()->id}}, '{{$file->file_name .'.'.$file->extension}}', {{$file->id}}, 'AthleteFileSection')
                        }">Eliminar</button>
                        @endif
                    </td>
                </tr>     
                @endforeach
                    
                
            </tbody>
        </table>
    
    </div>
    {{-- !TODO MEJORAR  --}}
    @if(Auth::user()->isTrainer || Auth::user()->id == $user->id)
    <div class="file-table-container">
        <h2 class="primary-blue-color">Archivos compartidos {{Auth::user()->id == $user->id ? 'contigo' : 'con ' . $user->name. ' '. $user->surname}}</h2>
        <table id="files-table2" class="fee-table file-datatable">
            <thead>
                <tr>
                    <th>Nombre del archivo</th>
                    <th>Formato</th>
                    <th>Propietario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach(getFilesSharedWithUser($user->id) as $key => $file)
                @php
                    $owned_by = $file->user->name . ' ' . $file->user->surname;
                @endphp
                <tr>
                    <td>{{$file->file_name}}</td>
                    <td>{{strtoupper($file->extension)}}</td>
                    <td>{{$owned_by}}</td>
                    <td>
                        <button onclick="window.open('{{$file->url}}','_blank')">Ver</button>
                        @if($file->owned_by == Auth::user()->id)
                        <button onclick="
                        if (confirm('¿Deseas dejar de compartir \'{{$file->file_name}}\' con {{$user->name . ' ' . $user->surname}}?')) {
                            stopSharingFile({{$file->id}}, {{$user->id}}, '{{$file->file_name}}')
                        };">Dejar de compartir</button>
                        @endif
                    </td>
                </tr>     
                @endforeach
                    
                
            </tbody>
        </table>
    
    </div>
    @endif

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