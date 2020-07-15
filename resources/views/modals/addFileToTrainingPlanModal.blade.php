<!-- Add File to Training Plan -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addFileToPlan{{$plan->id}}">
    <!-- Modal content -->
       <div class="modal-content" @click.away="addFileToPlan{{$plan->id}}=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="addFileToPlan{{$plan->id}}=!addFileToPlan{{$plan->id}}">&times;</span>
               <h2>Añadir fichero al plan</h2>
           </div>
           <div class="modal-body">
                {{$plan->id}}
                <progress value="0" max="100" id="uploader-plan">0%</progress>
                <input id="plan-upload" name="fileuploaded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
                <button onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'AddFileToTrainingPlan', {planId:{{$plan->id}}})">Subir</button>
                <div class="files">
                    <p>Ficheros asociados con el plan de entrenamiento</p>
                    <ul>
                    @foreach(getFilesAssociatedWithPlanId($plan->id) as $key => $file)
                        <li>
                            <a href="{{$file->url}}" target="_blank" style="color: black;">{{$file->file_name}}</a>
                            <button onclick="deleteUserFile({{$user->id}}, '{{$file->file_name .'.'. $file->extension}}', {{$file->id}}, 'TrainingPlanSection', {planId:{{$plan->id}}})">Eliminar fichero</button>
                        </li>
                    @endforeach
                    </ul>
                    
                </div>
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>

<script>
</script>