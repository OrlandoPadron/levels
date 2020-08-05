<!-- Add File to Training Plan -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="showFilesAssociated">
    <!-- Modal content -->
       <div class="modal-content plan-files" @click.away="showFilesAssociated=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="showFilesAssociated=!showFilesAssociated">&times;</span>
               <h2>Archivos del plan</h2>
           </div>
           <div class="modal-body">
               <div class="modal-body-container">
                   <p>Archivos asociados a <span class="italic">'{{$plan->title}}'</span></p>
                   <div class="file-table-container">
                        <table id="files-table-{{$plan->id}}" >
                            <thead>
                                <tr>
                                    <th>Nombre</th>
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
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prueba</td>
                                    <td>PDF</td>
                                    <td>{{date("d/m/Y")}}</td>
                                    <td>
                                        <button>Ver</button>
                                        <button>Actualizar</button>
                                        <button>Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                   </div>
                   <div class="modal-buttons">
                    <div class="principal-button">
                        <button class="btn-add-basic">Añadir nuevo archivo</button>
                    </div>

                </div>
               </div>
           </div>
       </div>
   </div>

<script>

    $(document).ready(function() {
        var planId = {{$plan->id}};
        $('#files-table-'.concat(planId)).DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": 3 },
            ],
            "bFilter": false,
            "scrollResize": true,
            "scrollY": '200px',
            "scrollCollapse": true,
            "paging": false
        });
    } );

    function viewFile(fileUrl, trainingPlanId){
        updateNotificationLogJson(trainingPlanId,'trainingPlans');
        window.open( 
              fileUrl, "_blank"); 
    }

</script>

<style>

</style>