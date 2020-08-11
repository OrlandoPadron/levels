<!-- Create New Thread Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="openNewThreadForm">
    <!-- Modal content -->
       <div class="modal-content add-thread-modal" @click.away="openNewThreadForm=false">
           <div class="modal-header">
               <span class="close" @click="openNewThreadForm=!openNewThreadForm">&times;</span>
               <h2>Nuevo hilo</h2>
           </div>
           <div class="modal-body">
               <form style="color: black;" class="form-newplan" action="{{route('thread.store')}}" method="POST">
                   @csrf
                   <div class="modal-body-container">
                        <div class="item-with-input">
                            <p>Título</p>
                            <input type="text" name="title" placeholder="Título del hilo" required>
                        </div>
                        <div class="item-with-text-area">
                            <p>Descripción</p>
                            <textarea name="description" placeholder="Escriba aquí el contenido del hilo... "></textarea><br>
                        </div>
                        <div class="modal-buttons">
                            <div class="principal-button">
                                <button class="btn-add-basic" type="submit">Crear hilo</button>
                            </div>
                        </div>
                    
                    </div>
                   <input type="text" name="created_by" value="{{Auth::user()->id}}" hidden>
                   <input type="text" name="user_associated" value="{{$user->id}}" hidden>
               </form>
   
           </div>
       </div>
   </div>