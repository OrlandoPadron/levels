@extends('layouts.base-inside-app')
@section('head')
<!-- Firebase Scripts -->
@include('scripts.firebaseScripts')
@endsection
@section('content')
<div class="alpine" x-data="{addNewUser: false,}">
    <div class="heading-section">
        <button class="btn-add-basic button-position"
                        @click="addNewUser=!addNewUser" 
                        @keydown.escape.window="addNewUser=false">
                        <i class="fas fa-plus"></i>Crear usuario
        </button>
        <h1 class="primary-blue-color">Panel de administrador</h1>
    </div>
    @include('modals.adminModals.newUserModal')
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
                <th>Cuenta activada</th>
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
                <td>{!!$user->isTrainer == 0 ? 'No' : '<span style=color:green;>Sí</span>'!!}</td>
                <td>{!!$user->admin == 0 ? 'No' : '<span style=color:green;>Sí</span>'!!}</td>
                <td>{!!$user->account_activated == 0 ? '<span style=color:red;>No</span>' : '<span style=color:green;>Sí</span>' !!}</td>
                <td>
                    <button
                    onclick="setVisibleModal('{{$user->id}}')"
                    >Editar usuario</button>
                </td>

            </tr> 
            @endforeach
        </tbody>
    </table>
</div>
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
