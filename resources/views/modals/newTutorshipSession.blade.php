<!-- Payment settings -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addTutorshipSession">
    <!-- Modal content -->
       <div class="modal-content new-tutorship-modal" @click.away="addTutorshipSession=false">
           <div class="modal-header">
               <span class="close" @click="addTutorshipSession=!addTutorshipSession">&times;</span>
               <h2>Nueva tutoría</h2>
           </div>
           <div class="modal-body">
               <form class="form-newTutorshipSession" action="{{route('tutorship.store')}}" method="POST">
                    @csrf
                    <div class="modal-body-container">
                            <div class="item-with-input">
                                <p>Título</p>
                                <input type="text" name="title" value="Tutoría #{{$user->athlete->tutorships->count()+1}}" required>
                            </div>
                            <div class="item-with-input">
                                <p>Fecha</p>
                                <input type="date" name="date" value="{{date("Y-m-d")}}" required>
                            </div>
                            <div class="item-with-input">
                                <p>Objetivo</p>
                                <input type="text" name="goal" value="Objetivo de Tutoría #{{$user->athlete->tutorships->count()+1}}">
                            </div>
                            <div class="modal-buttons">
                                <div class="principal-button">
                                    <button class="btn-add-basic" type="submit">Añadir tutoría</button>
                                </div>
                            </div>
                        </div>
                        <input type="number" name="athlete_associated" value="{{$user->athlete->id}}" hidden>
               </form>
   
           </div>
       </div>
   </div>