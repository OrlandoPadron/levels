<div class="heading-section">
    @if(Auth::user()->isTrainer)
    <button class="btn-add-basic button-position"
                @click="addMembers=!addMembers" 
                @keydown.escape.window="addMembers=false"
                    
                ><i style="margin-right: 5px;" class="fas fa-plus"></i> Añadir miembros
    </button>
        
    @endif
    <h1 class="primary-blue-color">Miembros</h1>
</div>
@if(Auth::user()->isTrainer)
@include('modals.addMembersToGroupModal')
@endif
<div class="members">
    @php
        $userLoggedRole = getUserRole($group->id, Auth::user()->id);
        $showManageColumn = false;
        if ($userLoggedRole == 'Propietario' || $userLoggedRole == 'Administrador' ){
            $showManageColumn = true; 
        }
    @endphp
    <table id="members_table">
        <thead>
            <th>Usuario</th>
            <th>Perfil</th>
            <th>Rol dentro del grupo</th>
            @if($showManageColumn)
            <th>Gestionar</th>
            @else
            <th></th>
            @endif
        </thead>
        <tbody>
        @foreach(getGroupUsers($group->id) as $key=>$user)
            @php
              $userRole = getUserRole($group->id,$user->id);
            @endphp
            <tr>
                <td
                    @if (Auth::user()->isTrainer)
                    onclick="location.href='{{route('profile.show', [$user->id, 'general'])}}'"
                    class="hover-container"
                    @endif
                
                >
                    <div class="table-user">
                        <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                        <p>{{$user->name . ' ' . $user->surname}}</p>
                    </div>
                </td>
                <td>
                    @if($user->isTrainer)
                    <p style="color:#6013bb;">Entrenador</p>
                    @else
                    <p>Deportista</p>
                    @endif
                </td>
                <td>
                    <p>{{$userRole}}</p>
                </td>
                @switch($userLoggedRole)
                    @case('Propietario')
                        <td>
                            @if(Auth::user()->id!=$user->id)
                                @if($userRole != 'Administrador')
                                    <button onclick="if (confirm('¿Deseas convertir en administrador del grupo a \'{{$user->name . ' ' . $user->surname}}\'?')) {
                                        toggleGroupAdmin({{$group}}, {{$user->id}})}">Convertir en administrador</button>
                                @else
                                    <button onclick="if (confirm('¿Deseas quitar el rol de administrador del grupo a \'{{$user->name . ' ' . $user->surname}}\'?')) {
                                        toggleGroupAdmin({{$group}}, {{$user->id}})}">Retirar administrador</button>
                                @endif
                                <button onclick="if (confirm('¿Deseas eliminar del grupo a \'{{$user->name . ' ' . $user->surname}}\'?')) {
                                    removeFromGroup({{$user->id}})}">Eliminar del grupo</button>
                            @endif
                        </td>
                        @break
                    @case('Administrador')
                        <td>
                            @if (Auth::user()->id != $user->id)
                                @if($userRole != 'Propietario' && $userRole!= 'Administrador')
                                <button onclick="if (confirm('¿Deseas eliminar del grupo a \'{{$user->name . ' ' . $user->surname}}\'?')) {
                                    removeFromGroup({{$user->id}})}">Eliminar del grupo</button>
                                @endif
                            @endif
                        </td>    
                    @break
     
                    @default
                        <td></td>
                        @break
                        
                @endswitch
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>

    $(document).ready(function() {
    $('#members_table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "columnDefs": [
            { "orderable": false, "targets": [3] },

        ],
        "order": [ 0, 'asc' ],
        "bFilter": true
        });
    } );

    function removeFromGroup(id){
        console.log('Remove from Group User ' + id);
        $.ajax({
            url: "{{route("group.removeMember")}}",
            type: "POST",
            data: {
                group_id: {{$group->id}},
                user_id: id,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert('Miembro eliminado del grupo');
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "removeFromGroup" function');
            }  
        });
    }

    function toggleGroupAdmin(groupId, userId){
        $.ajax({
            url: "{{route("group.toggleGroupAdmin")}}",
            type: "POST",
            data: {
                group_id: {{$group->id}},
                user_id: userId,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                alert('Se han cambiado los permisos.');
                location.reload();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "toggleGroupAdmin" function');
            }  
        });
    }

</script>