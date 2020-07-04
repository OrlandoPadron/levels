<!-- Create New Group Thread Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openNewThreadForm">
    <!-- Modal content -->
       <div class="modal-content" @click.away="openNewThreadForm=false">
           <div class="modal-header">
               <span class="close" @click="openNewThreadForm=!openNewThreadForm">&times;</span>
               <h2>Nuevo hilo</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" action="{{route('thread.store')}}" method="POST">
                   @csrf
                   <h2 class="underlined">Información general</h2>
                   <label for="title">Título</label><br>
                   <input type="text" name="title"><br>
                   <label for="description">Descripción</label><br>
                   <textarea cols="50" rows="5" name="description"></textarea><br>
                   <input type="text" name="created_by" value="{{Auth::user()->id}}">
                   <input type="text" name="group_associated" value="{{$group->id}}">
                   <button type="submit">Crear</button>
               </form>
   
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>