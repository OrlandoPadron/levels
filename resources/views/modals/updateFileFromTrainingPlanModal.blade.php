<!-- Add File to Training Plan -->
<div id="updateFileFromTrainingPlan{{$file->id}}" style="display: none;" class="modal">
    <!-- Modal content -->
       <div class="modal-content upload-file-modal">
           <div class="modal-header">
               <span id="closeModal" class="close">&times;</span>
               <h2>Añadir fichero al plan</h2>
           </div>
           <div class="modal-body">
            <div class="modal-body-container">
                <p>{{$file->id}}</p>
            
            </div>
       </div>
    </div>
</div>

{{-- <div class="modal-body">
     {{$plan->id}}
     <progress value="0" max="100" id="uploader-plan">0%</progress><br>
     <label for="fileName">Nombre del fichero</label><br>
     <input type="text" name="fileName"><br>
     <input id="plan-upload" name="fileuploaded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
     <button onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'AddFileToTrainingPlan', {planId:{{$plan->id}}})">Subir</button>
     <div class="files">
         <p>Ficheros asociados con el plan de entrenamiento</p>
         <ul>
         @foreach(getFilesAssociatedWithPlanId($plan->id) as $key => $file)
             <li>
                 <span>{{$file->file_name}}</span>
                 <input id="plan-upload-upgrade" name="fileupgraded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
                 <button onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'UpdateFileTrainingPlan', {planId:{{$plan->id}}, fileId: {{$file->id}}, filename: '{{$file->file_name}}'})">Actualizar</button>
                 <button onclick="viewFile('{{$file->url}}', {{$plan->id}})">Ver fichero</button>
                 <button onclick="deleteUserFile({{$user->id}}, '{{$file->file_name .'.'. $file->extension}}', {{$file->id}}, 'TrainingPlanSection', {planId:{{$plan->id}}})">Eliminar fichero</button>
             </li>
         @endforeach
         </ul>
         
     </div>
</div> --}}
<script>

    function viewFile(fileUrl, trainingPlanId){
        updateNotificationLogJson(trainingPlanId,'trainingPlans');
        window.open( 
              fileUrl, "_blank"); 
    }

</script>