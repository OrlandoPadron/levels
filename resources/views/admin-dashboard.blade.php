@extends('layouts.base-inside-app')
@section('content')
<h1>Panel de administrador</h1>
<h2>Usuarios</h2>
<table id="users-table" class="fee-table file-datatable">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Segundo nombre</th>
            <th>Primer apellido</th>
            <th>Segundo apellido</th>
            <th>Email</th>
            <th>Entrenador</th>
            <th>Admin</th>
            <th>Cuenta desactivada</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->name2}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->surname2}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->isTrainer}}</td>
            <td>{{$user->admin}}</td>
            <td>{{$user->account_activated}}</td>

        </tr>     
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#users-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },  
        });
    });

</script>

@endsection
