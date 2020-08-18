<!-- Add File to Training Plan -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.550ms.opacity="addFileToPlan">
    <!-- Modal content -->
       <div class="modal-content upload-file-modal" @click.away="addFileToPlan=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="addFileToPlan=!addFileToPlan">&times;</span>
               <h2>Añadir fichero al plan</h2>
           </div>
           <div class="modal-body">
            <div class="modal-body-container">
                <div class="item-with-button-add-file">
                    <button class="soft-btn" onclick="document.getElementById('file-upload-{{$plan->id}}').click();">Seleccionar archivo</button>
                    <p id="selected-file-name-{{$plan->id}}">Ningún archivo seleccionado</p>
                    <i id="file-load-status-icon-{{$plan->id}}" class="fas fa-check-circle"></i>
                    <input onchange="changeUI('uploadToTrainingPlan', {{$plan->id}})" id="file-upload-{{$plan->id}}" name="fileuploaded" type="file" 
                    accept="application/pdf, application/msword, image/*, 
                    application/vnd.ms-powerpoint, .csv, 
                    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, 
                    application/vnd.ms-excel, video/*, audio/*" hidden/>

                </div>
                <div class="item-with-input">
                    <p>Nombre del archivo</p>
                    <input type="text" name="title" id="file-name-input-{{$plan->id}}" placeholder="Nombre del archivo" required>
                </div>
                <div class="item-with-progressbar">
                    <p>Estado de la subida</p>
                    <progress value="0" max="100" id="uploader-{{$plan->id}}">0%</progress>

                </div>
                <div class="modal-buttons">
                    <div class="principal-button">
                        <button disabled class="btn-add-basic" id="upload-btn-{{$plan->id}}" type="submit"
                        onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'AddFileToTrainingPlan', {planId:{{$plan->id}}})">Subir archivo</button>
                    </div>

                </div>
            
            </div>
       </div>
    </div>
</div>
<script>

    function viewFile(fileUrl, trainingPlanId){
        updateNotificationLogJson(trainingPlanId,'trainingPlans');
        window.open( 
              fileUrl, "_blank"); 
    }

</script>