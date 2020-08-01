<!-- Create New Training Plan Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openNewPlan">
 <!-- Modal content -->
    <div class="modal-content" @click.away="openNewPlan=false">
        <div class="modal-header">
            <span class="close" @click="openNewPlan=!openNewPlan">&times;</span>
            <h2>Crear nuevo plan de entrenamiento</h2>
        </div>
        <div class="modal-body">
            <form class="form-newplan" action="{{route('trainingPlan.store')}}" method="POST">
                @csrf
                <h2 class="underlined">Información general</h2>
                <label for="title">Título</label><br>
                <input type="text" name="title" required><br>
                <label for="startDate">Fecha de inicio</label><br>
                <input type="date" name="startDate" value="{{date("Y-m-d")}}" required><br>
                <label for="endDate">Fecha de finalización</label><br>
                <input type="date" name="endDate" value="{{date("Y-m-d")}}" required><br>
                <label for="description">Descripción / Objetivos</label><br>
                <textarea cols="50" rows="5" name="description"></textarea><br>
                <input type="text" hidden name="athlete_associated" value="{{$user->athlete->id}}">
                <button type="submit">Crear</button>
            </form>

        </div>
        <div class="modal-footer">
            <h3>Modal Footer</h3>
        </div>
    </div>
</div>