@extends('layouts.base-inside-app')
@section('content')
<div class="heading-section">
    <button class="btn-add-basic button-position"
                    @click="newUser=!newUser" 
                    @keydown.escape.window="newUser=false">
                    <i class="fas fa-plus"></i>Crear usuario
    </button>
    <h1 class="primary-blue-color">Panel de administrador</h1>
</div>
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
            <th>Es entrenador</th>
            <th>Es administrador</th>
            <th>Cuenta desactivada</th>
            <th>Gestionar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
        @include('modals.adminModals.editUserModal', ['user'=>$user])   

        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->name2}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->surname2}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->isTrainer == 0 ? 'No' : 'Sí'}}</td>
            <td>{{$user->admin == 0 ? 'No' : 'Sí'}}</td>
            <td>{{$user->account_activated == 0 ? 'Sí' : 'No'}}</td>
            <td>
                <button
                onclick="setVisibleModal('{{$user->id}}')"
                >Editar usuario</button>
            </td>

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

    function setVisibleModal(userId){
        $('#editUser'.concat(userId)).fadeIn();

    }
</script>

@endsection
