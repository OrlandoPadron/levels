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
    <table>
        <tr>
            <th></th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Gestionar</th>
        </tr>
        <tr>
            <td class="members_table_image"><img src="/uploads/avatars/orlando.jpg" alt="user_img"></td>
            <td>Orlando Padrón</td>
            <td>Miembro</td>
            <td>
                <button>Hacer admin</button>
                <button>Eliminar</button>
            </td>
        </tr>
    </table>
</div>