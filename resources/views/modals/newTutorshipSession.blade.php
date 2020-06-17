<!-- Payment settings -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addTutorshipSession">
    <!-- Modal content -->
       <div class="modal-content" @click.away="addTutorshipSession=false">
           <div class="modal-header">
               <span class="close" @click="addTutorshipSession=!addTutorshipSession">&times;</span>
               <h2>Nueva tutoría</h2>
           </div>
           <div class="modal-body">
               <form class="form-newTutorshipSession" action="{{route('tutorship.store')}}" method="POST">
                   @csrf
                   <h2 class="underlined">Detalles de la tutoría</h2>
                   <input type="text" hidden name="user_id" value="{{$user->id}}">
                   <label for="title">Título</label><br>
                   <input type="text" name="title" value="Tutoría #{{$user->athlete->tutorships->count()+1}}"><br>
                   <label>Fecha</label><br>
                   <input type="date" name="date" value="{{date("Y-m-d")}}"><br>
                   <label>Objetivo</label><br>
                   <input type="text" name="goal" value=""><br>
                   <label>Descripción</label><br>
                   <textarea name="description" rows="4" cols="50"></textarea><br>
                   <label>Marcar como importante</label><br>
                   <input type="checkbox" name="bookmark" value="bookmark_set"><br>

                   <input type="number" hidden name="athlete_associated" value="{{$user->athlete->id}}">
                   <button type="submit">Añadir</button>
               </form>
   
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>