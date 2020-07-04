<!-- Edit Group Details Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="editGroupDetails">
    <!-- Modal content -->
       <div class="modal-content" @click.away="editGroupDetails=false">
           <div class="modal-header">
               <span class="close" @click="editGroupDetails=!editGroupDetails">&times;</span>
               <h2>Editar</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" action="{{route('thread.store')}}" method="POST">
                   @csrf
                   <label for="title">Titulo</label><br>
                   <input type="text" name="title"><br>
                   <label for="description">Descripción</label><br>
                   <textarea cols="50" rows="5" name="description"></textarea><br>
                   <input type="text" name="group_associated" value="{{$group->id}}">
                   <button type="submit">Guardar</button>
               </form>
   
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>