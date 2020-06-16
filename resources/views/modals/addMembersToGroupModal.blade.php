<!-- Add Members to Group -->
<div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="addMembers">
    <!-- Modal content -->
       <div class="modal-content" @click.away="addMembers=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="addMembers=!addMembers">&times;</span>
               <h2>Opciones de la cuota</h2>
           </div>
           <div class="modal-body">
            @foreach(Auth::user()->trainer->trained_by_me as $key=>$athlete_id)
                <ul>
                    <li>
                        <p>{{getAthleteById($athlete_id)->name . ' ' . getAthleteById($athlete_id)->surname}}</p>
                        <input type="checkbox" name="" value="{{$athlete_id}}" id="cbox_{{$key}}"> <label for="cbox_{{$key}}">Añadir</label> 
                    </li>
                </ul>
            @endforeach
                <button onclick="">Confirmar</button>
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>