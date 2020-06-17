<div class="heading-section">
    <button class="btn-add-basic button-position"
                    @click="addMembers=!addMembers" 
                    @keydown.escape.window="addMembers=false"
                    
                ><i style="margin-right: 5px;" class="fas fa-plus"></i> Añadir miembros
    </button>
    <h1 class="primary-blue-color">Miembros</h1>
</div>
@include('modals.addMembersToGroupModal')
<div class="members">
    @if(getGroupUsers($group->id)->isNotEmpty())
        <table id="members_table">
            <tr>
                <th></th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Gestionar</th>
            </tr>
            @foreach(getGroupUsers($group->id)->sortBy('name') as $key => $user)
                <tr id="row_user_{{$user->id}}">
                    <td class="members_table_image"><a href="{{route("profile.show", [$user->id, 'general'])}}"><img src="/uploads/avatars/{{$user->user_image}}" alt="user_img"></a></td>
                    <td>{{$user->name . ' ' . $user->surname}}</td>
                    <td>Miembro</td>
                    <td>
                        <button>Hacer admin</button>
                        <button onclick="removeFromGroup({{$user->id}}, {{$user->athlete->id}})">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No hay miembros</p>
    @endif
</div>

<script>

    var row_user = "#row_user_";
    var total_members; 

    window.onload = function() {
       total_members = {{getGroupUsers($group->id)->count()}};
    };

    function removeFromGroup(id, athleteId){
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
                total_members--;
                $(row_user.concat(id)).hide();
                
                //Modal update
                $("#li_member_".concat(athleteId)).show();
                
                if (total_members==0){
                    $("#members_table").hide();
                    $(".members").append().html("<p>No hay miembros</p>");

                }
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "removeFromGroup" function');
            }  
        });
    }

</script>