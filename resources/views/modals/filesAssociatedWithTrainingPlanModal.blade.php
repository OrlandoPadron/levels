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
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <div class="table-buttons">
                                            <button>Ver</button>
                                            <button>Actualizar</button>
                                            <button>Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                   

                                
                            </tbody>
                        </table>
                   </div>
                   <div class="modal-buttons">
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

</script>

<style>

</style>