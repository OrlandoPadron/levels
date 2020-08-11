<!-- Edit Group Details Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="editGroupDetails">
    <!-- Modal content -->
       <div class="modal-content edit-group-modal" @click.away="editGroupDetails=false">
           <div class="modal-header">
               <span class="close" @click="editGroupDetails=!editGroupDetails">&times;</span>
               <h2>Editar grupo</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" enctype="multipart/form-data" action="{{route('group.update')}}" method="POST">
                   @csrf
                   <input type="text" name="group_id" value="{{$group->id}}" hidden>

                   <div class="modal-body-container">
                       <div class="grid-edit-group-container">
                            <div class="edit-group-image">
                                <img class="inner-shadow" src="/uploads/group_avatars/{{$group->group_image}}"
                                alt="group_avatar" id="group_avatar_preview">
                                <button type="button" onclick="document.getElementById('file-upload').click();" class="soft-btn">Añadir imagen</button>
                                <label for="delete-file">Restablecer imagen</label>
                                
                                <input onchange="changeImagePreview(event)" id="file-upload" name="group_avatar" type="file" accept="image/*" hidden/>
                            
                            </div>
                            <div class="edit-form">
                                <div class="item-with-input">
                                    <p>Título</p>
                                    <input type="text" name="title" placeholder="Título del grupo" value="{{$group->title}}" required>
                                </div>
                                <div class="item-with-text-area">
                                    <p>Descripción</p>
                                    <textarea name="description" placeholder="Escriba aquí una descripción para el grupo... ">{{$group->description}}</textarea>
                                </div>
                            </div>

                       </div>
                    
                    <div class="modal-buttons">
                        <div class="principal-button">
                            <button class="btn-add-basic" type="submit">Guardar cambios</button>
                        </div>

                    </div>
                
                </div>
                   {{-- <label for="title">Titulo</label><br>
                   <input type="text" name="title" value="{{$group->title}}"><br>
                   <label for="description">Descripción</label><br>
                   <textarea cols="50" rows="5" name="description">{{$group->description}}</textarea><br>
                   <input onchange="changeImagePreview(event)" id="file-upload" name="group_avatar" type="file" accept="image/*"/><br>

                   <button type="submit">Guardar</button> --}}
               </form>
           </div>
           <div class="modal-footer">
               <h3>Opciones avanzadas</h3>
               <form action="{{route('group.destroy')}}" method="POST">
                    @csrf
                    <input type="text" name="group_id" value="{{$group->id}}" hidden>
                    <button class="btn-gray-basic" type="submit">Eliminar grupo</button>
                </form>
           </div>
       </div>
   </div>

   <script>
       function changeImagePreview(event){
            if (event.target.files.length > 0){
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = $('#group_avatar_preview')[0];
                preview.src = src; 
            }
       }
   </script>