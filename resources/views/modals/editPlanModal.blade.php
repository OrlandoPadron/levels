<!-- Create New Training Plan Modal -->
<div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="editPlan">
 <!-- Modal content -->
    <div class="modal-content edit-plan-modal" @click.away="editPlan=false">
        <div class="modal-header">
            <span class="close" @click="editPlan=!editPlan">&times;</span>
            <h2>Gestionar plan de entrenamiento</h2>
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
                    @php
                        $arrayOfFileNames = getArrayOfFilesNames($plan->files_associated);
                    @endphp
                    
                    <div class="modal-buttons">
                        <div class="alternative-buttons">
                            <a onclick="submitForm('togglePlanStatus', {{$plan->id}});"><i class="fas fa-calendar-check"></i>Marcar como {{$plan->status == 'active' ? 'finalizado' : 'activo'}}</a>
                            <a onclick="
                            if (confirm('¿Deseas eliminar el plan \'{{$plan->title}}\'?')) {
                                submitForm('destroyPlan', {{$plan->id}}, {{$user->id}}, {{json_encode($arrayOfFileNames, true)}});
                            }"><i class="fas fa-trash"></i>Eliminar plan</a>
                        </div>
                        <div class="principal-button">
                            <button class="btn-add-basic" type="submit">Guardar cambios</button>
                        </div>

                    </div>
                    
                </div>
            </form>


        </div>
    </div>
    <form action="{{route('trainingPlan.destroy')}}" method="POST" id="destroyPlanForm{{$plan->id}}">
        @csrf
        <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
        <input type="text" value="{{$user->id}}" name="user_id" hidden>
    </form>
    <form action="{{route('trainingPlan.update')}}" method="POST" id="togglePlanStatusForm{{$plan->id}}">
        @csrf
        <input type="text" value="{{$plan->id}}" name="id_plan" hidden>
        <input type="text" name="method" value="togglePlanStatus" hidden>
    </form>
</div>


<script>

    function submitForm(method, planId, userId=0, filesAssociated=[]){
        switch(method){
            case 'destroyPlan':
                data = [userId , planId, method];
                console.log(filesAssociated);
                filesAssociated.forEach(removeEachFileFromFirebase, data);
                $('#destroyPlanForm'.concat(planId)).submit();
                
                break;
            case 'togglePlanStatus':
                $('#togglePlanStatusForm'.concat(planId)).submit();
                break;

        }
    }

    function removeEachFileFromFirebase(fileName){
        var userId = parseInt(this[0], 10); 
        var planId = parseInt(this[1], 10); 
        var method = String(this[2]); 

        deleteUserFile(userId,fileName, null, method, {planId:planId});
    }

</script>