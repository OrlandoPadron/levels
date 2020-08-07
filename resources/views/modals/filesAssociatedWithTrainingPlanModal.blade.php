<!-- Add File to Training Plan -->
<div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="showFilesAssociated">
    <!-- Modal content -->
       <div class="modal-content plan-files" @click.away="showFilesAssociated=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="showFilesAssociated=!showFilesAssociated">&times;</span>
               <h2>Archivos del plan</h2>
           </div>
           <div class="modal-body">
               <div class="modal-body-container">
                   <p>Archivos asociados a <span class="italic" style="font-weight: 500; color: #6013bb;">"{{$plan->title}}"</span></p>
                   <div class="file-table-container basic-table">
                    @php
                        $countOfFiles = count(getFilesAssociatedWithPlanId($plan->id));
                        dump($countOfFiles);
                    @endphp
                    @if ($countOfFiles > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</thstyle=>
                                    <th>Tipo</th>
                                    <th>Última actualización</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(getFilesAssociatedWithPlanId($plan->id) as $key => $file)
                                    <tr>
                                        <td>{{$file->file_name}}</td>
                                        <td>{{'.'.$file->extension}}</td>
                                        <td>{{$plan->updated_at->diffForHumans()}}</td>
                                        <td>
                                            <div class="table-buttons">
                                                <button onclick="viewFile('{{$file->url}}', {{$plan->id}})">Ver</button>
                                                <button onclick="showUpdateFileMode({{$plan->id}},  
                                                    {'fileId': {{$file->id}}, 'userId': {{$user->id}}, 'filename': '{{$file->file_name}}','extension': '{{$file->extension}}' })">Actualizar</button>
                                                <button onclick="deleteUserFile({{$user->id}}, 
                                                '{{$file->file_name .'.'. $file->extension}}', {{$file->id}}, 
                                                'TrainingPlanSection', {planId:{{$plan->id}}})">Eliminar</button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                @endforeach
                                    
                                    
                                    
                            </tbody>
                    </table>
                    @else
                    <p>No hay ficheros</p>
                    @endif
                   </div>
                   {{-- Update plan file section --}}
                   <div style="display:none;" id="update-file-mode-{{$plan->id}}">
                        <p>Actualizar archivo</p>
                        <div class="item-with-button-add-file">
                            <button class="soft-btn" onclick="document.getElementById('file-plan-update-{{$plan->id}}').click();">Seleccionar archivo</button>
                            <p id="selected-update-file-name-{{$plan->id}}">Ningún archivo seleccionado</p>
                            <i id="update-file-load-status-icon-{{$plan->id}}" class="fas fa-check-circle"></i>
                            <input onchange="changeUI('updateFileFromTrainingPlan', {{$plan->id}})" id="file-plan-update-{{$plan->id}}" name="fileuploaded" type="file" 
                            accept="application/pdf, application/msword, image/*, 
                            application/vnd.ms-powerpoint, .csv, 
                            application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, 
                            application/vnd.ms-excel, video/*, audio/*" hidden/>
        
                        </div>
                        <div class="item-with-progressbar">
                            <p>Estado de la subida</p>
                        <progress value="0" max="100" id="uploader-update-{{$plan->id}}">0%</progress>
    
                        </div>
                        <div class="modal-buttons">
                            <div class="principal-button">
                                <button disabled id="update-plan-file-btn-{{$plan->id}}" class="btn-add-basic">Actualizar</button>
                            </div>
        
                        </div>
                   </div>
                   {{-- End update plan file section --}}
                   <div id="add-new-plan-file-{{$plan->id}}" class="modal-buttons">
                    <div class="principal-button">
                        <button class="btn-add-basic"
                        @click="showFilesAssociated=!showFilesAssociated,addFileToPlan=!addFileToPlan" 
                        @keydown.escape.window="addFileToPlan=false"
                        >Añadir nuevo archivo</button>
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

    function showUpdateFileMode(planId, additionalContent = []){
        console.log(additionalContent);
        $('#add-new-plan-file-'.concat(planId)).hide();
        $('#update-file-mode-'.concat(planId)).fadeIn(250);
        $("#update-plan-file-btn-".concat(planId)).click(function(){
            var fileName = additionalContent['filename'].concat("." + additionalContent['extension']);
            var fileId = additionalContent['fileId'];
            var userId = additionalContent['userId'];
            var newFile = document.getElementById("file-plan-update-".concat(planId)).files[0];
            var newfileExtension = newFile.name.split('.').pop();

            if (newfileExtension == additionalContent['extension']){
                updatePlanFile(fileId, userId, planId, fileName);

            }else{
                alert('Archivo no válido.'); 
            }

        });
    }



</script>