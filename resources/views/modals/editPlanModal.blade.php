<!-- Create New Training Plan Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="editPlan">
 <!-- Modal content -->
    <div class="modal-content" @click.away="editPlan=false">
        <div class="modal-header">
            <span class="close" @click="editPlan=!editPlan">&times;</span>
            <h2>Editar plan de entrenamiento</h2>
        </div>
        <div class="modal-body">
            <form class="form-newplan" action="{{route('trainingPlan.update')}}" method="POST">
                @csrf
                <h2 class="underlined">Información general</h2>
                <label for="title">Título</label><br>
                <input type="text" name="title" value="{{$plan->title}}"><br>
                <label for="description">Descripción / Objetivos</label><br>
                <textarea cols="50" rows="5" name="description">{{$plan->description}}</textarea><br>
                <select name="status" id="status">
                    <option value="not_finished" {{$plan->status == 'active' ? 'selected' : ''}}>Activo</option>
                    <option value="finished" {{$plan->status != 'active' ? 'selected' : ''}}>Finalizado</option>
                  </select>
                <input type="text" name="method" value="updatePlan" hidden>
                <button type="submit">Guardar cambios</button>
            </form>

        </div>
        <div class="modal-footer">
            <h3>Modal Footer</h3>
        </div>
    </div>
</div>