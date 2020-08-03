<!-- Edit Group Details Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="editGroupDetails">
    <!-- Modal content -->
       <div class="modal-content" @click.away="editGroupDetails=false">
           <div class="modal-header">
               <span class="close" @click="editGroupDetails=!editGroupDetails">&times;</span>
               <h2>Editar</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" enctype="multipart/form-data" action="{{route('group.update')}}" method="POST">
                   @csrf
                   <label for="title">Titulo</label><br>
                   <input type="text" name="title" value="{{$group->title}}"><br>
                   <label for="description">Descripción</label><br>
                   <textarea cols="50" rows="5" name="description">{{$group->description}}</textarea><br>
                   <input type="text" name="group_id" value="{{$group->id}}"><br>
                   <input onchange="changeImagePreview(event)" id="file-upload" name="group_avatar" type="file" accept="image/*"/><br>

                   <button type="submit">Guardar</button>
               </form>
               <img src="/uploads/group_avatars/{{$group->group_image}}" alt="group_avatar" style="width: 100px;" id="group_avatar_preview">   
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
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