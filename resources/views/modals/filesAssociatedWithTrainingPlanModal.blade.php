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
                   <div id="file-view-mode-{{$plan->id}}">
                        @php
                            $countOfFiles = count(getFilesAssociatedWithPlanId($plan->id));
                        @endphp
                        @if($countOfFiles > 0)
                        <p>Archivos asociados a <span class="italic" style="font-weight: 500; color: #6013bb;">"{{$plan->title}}"</span></p>
                        @else
                        <div class="training-plan-no-files-message ">
                            <p><span class="italic" style="font-weight: 500; color: #6013bb;">"{{$plan->title}}"</span> no tiene archivos.</p>
                        </div>
                        @endif
                        <div class="file-table-container basic-table">
                            @if ($countOfFiles > 0)
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Última modificación</th>
                                        <th>Has visto el cambio</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(getFilesAssociatedWithPlanId($plan->id) as $key => $file)
                                            <tr>
                                                <td >
                                                    {{$file->file_name}}
                                                </td>
                                                <td>{{'.'.$file->extension}}</td>
                                                <td>
                                                    {{$file->updated_at->diffForHumans()}}
                                                    
                                                </td>
                                                <td id="table-notification-status">
                                                    
                                                    @if(haventISeenThisFile($file->id, $notifications['trainingPlansUpdates']))
                                                    <i class="fas fa-times-circle"></i>
                                                    @else
                                                    <i class="fas fa-check-circle"></i>
                                                    @endif

                                                    
                                                </td>
                                                <td>
                                                    <div class="table-buttons">
                                                        <button onclick="viewFile('{{$file->url}}', {{$plan->id}})">Ver</button>
                                                        <button onclick="showUpdateFileMode({{$plan->id}},  
                                                            {'fileId': {{$file->id}}, 'userId': {{$user->id}}, 'filename': '{{$file->file_name}}','extension': '{{$file->extension}}' })">Actualizar</button>
                                                        @if(Auth::user()->isTrainer)
                                                        <button onclick="deleteUserFile({{$user->id}}, 
                                                        '{{$file->file_name .'.'. $file->extension}}', {{$file->id}}, 
                                                        'TrainingPlanSection', {planId:{{$plan->id}}})">Eliminar</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                            
                                            
                                            
                                    </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                   {{-- Update plan file section --}}
                   <div style="display:none;" id="update-file-mode-{{$plan->id}}" class="update-file-section">
                        <p>Actualizar archivo <span class="italic"></span></p>
                        <div id="upload-error-{{$plan->id}}" style="display: none;" class="item-with-error">
                            <p><i class="fas fa-exclamation-circle"></i> Error</p>
                            <p>El archivo '<span></span>' no es válido. Asegúrese de estar seleccionando una modificación del archivo original.</p>
                        </div>    

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
                            <div class="principal-button update-plan-file-buttons">
                                <button onclick="closeUpdateFileMode({{$plan->id}})" class="btn-gray-basic">Cancelar</button>
                                <button disabled id="update-plan-file-btn-{{$plan->id}}" class="btn-add-basic">Actualizar</button>
                            </div>
        
                        </div>
                   </div>
                   {{-- End update plan file section --}}
                   <div id="add-new-plan-file-{{$plan->id}}" class="modal-buttons">
                    <div  {!!!Auth::user()->isTrainer ? 'style=display:none;' : ''!!} class="principal-button">
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
        $('#file-view-mode-'.concat(planId)).hide();
        $('#add-new-plan-file-'.concat(planId)).hide();
        $('#update-file-mode-'.concat(planId)).find("span:first-child").text('"'+additionalContent['filename']+'"');
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
                $('#upload-error-'.concat(planId)).fadeIn(250);
                $('#upload-error-'.concat(planId)).find("span").text(newFile.name);
            }

        });
    }

    function closeUpdateFileMode(planId){
        $('#file-view-mode-'.concat(planId)).fadeIn(250);
        $('#add-new-plan-file-'.concat(planId)).fadeIn(250);
        $('#update-file-mode-'.concat(planId)).hide();
    }



</script>