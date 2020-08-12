<!-- Create New Group Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openNewGroupForm">
    <!-- Modal content -->
       <div class="modal-content new-group-modal" @click.away="openNewGroupForm=false">
           <div class="modal-header">
               <span class="close" @click="openNewGroupForm=!openNewGroupForm">&times;</span>
               <h2>Crear nuevo grupo</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" action="{{route('group.store')}}" method="POST">
                   @csrf
                   <div class="modal-body-container">
                        <div class="item-with-input">
                            <p>Título</p>
                            <input type="text" name="title" placeholder="Título del grupo" required>
                        </div>
                        <div class="item-with-text-area">
                            <p>Descripción</p>
                            <textarea name="description" placeholder="Escriba aquí la descripción del grupo... "></textarea>
                        </div>
                        <div class="modal-buttons">
                            <div class="principal-button">
                                <button class="btn-add-basic" type="submit">Crear grupo</button>
                            </div>
                        </div>
                    
                    </div>
                   <input type="text" name="created_by" value="{{Auth::user()->trainer->id}}" hidden>
               </form>
   
           </div>
       </div>
   </div>