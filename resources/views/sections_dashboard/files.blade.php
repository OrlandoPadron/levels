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
<form action="{{route('profile.uploadFile')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <label for="file-upload">Subir fichero</label>
    <input name="user_id" value="{{Auth::user()->id}}">
    <input id="file-upload" multiple name="fileuploaded[]" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
    <button type="submit">Subir
    </button>
</form>

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
</script>


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyA78SiccN2Ja0DvcBvJQpcBYjhl9h08Bmc",
    authDomain: "levels-11f76.firebaseapp.com",
    databaseURL: "https://levels-11f76.firebaseio.com",
    projectId: "levels-11f76",
    storageBucket: "levels-11f76.appspot.com",
    messagingSenderId: "295655081196",
    appId: "1:295655081196:web:676fb218bc2539496551c9",
    measurementId: "G-41719VQ8YE"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>