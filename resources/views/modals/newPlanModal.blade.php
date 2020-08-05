<!-- Create New Training Plan Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openNewPlan">
 <!-- Modal content -->
    <div class="modal-content create-plan-modal" @click.away="openNewPlan=false">
        <div class="modal-header">
            <span class="close" @click="openNewPlan=!openNewPlan">&times;</span>
            <h2>Crear nuevo plan de entrenamiento</h2>
        </div>
        <div class="modal-body">
            <form class="form-newplan" action="{{route('trainingPlan.store')}}" method="POST">
                @csrf
                @php
                    $nextPlan = $user->athlete->trainingPlans->count()+1;
                @endphp
                <div class="modal-body-container">
                    <div class="item-with-input">
                        <p>Título</p>
                        <input type="text" name="title" value="Plan de entrenamiento #{{$nextPlan}}" required>
                    </div>
                    <div class="flex-horizontal">
                        <div class="item-with-input">
                            <p>Fecha inicio</p>
                            <input type="date" name="startDate" value="{{date("Y-m-d")}}" required>
                        </div>
                        <div class="item-with-input">
                            <p>Fecha fin</p>
                            <input type="date" name="endDate" value="{{date("Y-m-d")}}" required>
                        </div>
                    </div>
                    <div class="item-with-text-area">
                        <p>Descripción - Objetivos</p>
                        <textarea name="description" placeholder="Escriba aquí una breve descripción del plan ... "></textarea><br>
                    </div>
                    <input type="text" name="athlete_associated" value="{{$user->athlete->id}}" hidden>
                    <div class="modal-buttons">
                        <div class="principal-button">
                            <button class="btn-add-basic" type="submit">Crear plan</button>
                        </div>

                    </div>
                    
                </div>
            </form>


        </div>
    </div>
</div>