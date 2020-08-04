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
                <div class="modal-body-container">
                    <div class="item-with-input">
                        <p>Título</p>
                        <input type="text" name="title" value="{{$plan->title}}" required>
                    </div>
                    <div class="flex-horizontal">
                        <div class="item-with-input">
                            <p>Fecha inicio</p>
                            <input type="date" name="startDate" value="{{$plan->start_date->format('Y-m-d')}}" required>
                        </div>
                        <div class="item-with-input">
                            <p>Fecha fin</p>
                            <input type="date" name="endDate" value="{{$plan->end_date->format('Y-m-d')}}" required>
                        </div>
                    </div>
                    <div class="item-with-text-area">
                        <p>Descripción - Objetivos</p>
                        <textarea name="description">{{$plan->description}}</textarea><br>
                    </div>
                    <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
                    <input type="text" value="{{$user->id}}" name="user_id" hidden>
                    <input type="text" name="method" value="updatePlan" hidden>
                    <div class="modal-buttons">
                        <div class="alternative-buttons">
                            <a><i class="fas fa-calendar-check"></i>Marcar como finalizado</a>
                            <a><i class="fas fa-trash"></i>Eliminar plan</a>
                        </div>
                        <div class="principal-button">
                            <button class="btn-add-basic" type="submit">Guardar cambios</button>

                        </div>

                    </div>
                    
                </div>
            </form>


        </div>
        <div class="modal-footer">
            <h3>Modal Footer</h3>
        </div>
    </div>
</div>

{{-- <form class="form-newplan" action="{{route('trainingPlan.update')}}" method="POST">
    @csrf
    <h2 class="underlined">Información general</h2>
    <label for="title">Título</label><br>
    <input type="text" name="title" value="{{$plan->title}}" required><br>
    <label for="startDate">Fecha de inicio</label><br>
    <input type="date" name="startDate" value="{{$plan->start_date->format('Y-m-d')}}" required><br>
    <label for="endDate">Fecha de finalización</label><br>
    <input type="date" name="endDate" value="{{$plan->end_date->format('Y-m-d')}}" required><br>
    <label for="description">Descripción / Objetivos</label><br>
    <textarea cols="50" rows="5" name="description">{{$plan->description}}</textarea><br>
    <select name="status">
        <option value="active" {{$plan->status == 'active' ? 'selected' : ''}}>Activo</option>
        <option value="finished" {{$plan->status != 'active' ? 'selected' : ''}}>Finalizado</option>
      </select>
    <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
    <input type="text" value="{{$user->id}}" name="user_id" hidden>
    <input type="text" name="method" value="updatePlan" hidden>
    <button type="submit">Guardar cambios</button>
</form>
<form action="{{route('trainingPlan.destroy')}}" method="POST">
    @csrf
    <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
    <input type="text" value="{{$user->id}}" name="user_id" hidden>
    <button class="btn-red-basic">Eliminar</button>
</form> --}}