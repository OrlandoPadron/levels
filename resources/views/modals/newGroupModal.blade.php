<!-- Create New Group Modal -->
<div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="openNewGroupForm">
    <!-- Modal content -->
       <div class="modal-content" @click.away="openNewGroupForm=false">
           <div class="modal-header">
               <span class="close" @click="openNewGroupForm=!openNewGroupForm">&times;</span>
               <h2>Crear nuevo grupo</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" action="{{route('group.store')}}" method="POST">
                   @csrf
                   <h2 class="underlined">Información general</h2>
                   <label for="title">Título</label><br>
                   <input type="text" name="title"><br>
                   <label for="description">Descripción / Objetivos</label><br>
                   <textarea cols="50" rows="5" name="description"></textarea><br>
                   <input type="text" name="created_by" value="{{Auth::user()->trainer->id}}">
                   <button type="submit">Crear</button>
               </form>
   
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>