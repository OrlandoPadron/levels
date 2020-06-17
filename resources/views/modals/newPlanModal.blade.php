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
                <input type="text" name="title"><br>
                <label for="description">Descripción / Objetivos</label><br>
                <textarea cols="50" rows="5" name="description"></textarea><br>
                <input type="text" hidden name="athlete_associated" value="{{$user->athlete->id}}">
                <h2 class="underlined">Organización</h2>
                <label for="">Macrociclos</label>
                <input type="number" min="1" name="num_macrocycles"><br>
                <label for="">Mesociclos</label>
                <input type="number"  min="1" name="num_mesocycles"><br>
                <label for="">Semanas/Mesociclos (microciclos)</label>
                <input type="number"  min="1" name="num_microcycles"><br>
                {{-- <label for="">Nº sesiones por semana</label>
                <input type="number"  min="1" name="num_sessions"><br> --}}
                <button type="submit">Crear</button>
            </form>

        </div>
        <div class="modal-footer">
            <h3>Modal Footer</h3>
        </div>
    </div>
</div>