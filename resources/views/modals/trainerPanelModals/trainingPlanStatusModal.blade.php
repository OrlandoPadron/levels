<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="planStatusModal">
    <!-- Modal content -->
    <div class="modal-content training-status-modals" @click.away="planStatusModal=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="planStatusModal=!planStatusModal">&times;</span>
               <h2>Planes de Entrenamiento</h2>
           </div>
           <div class="modal-body">
                <div class="modal-body-container">
                    <div class="item-with-container">
                        <p>Actualizaciones pendientes</p>
                        <div>
                            @if($notifications['trainingPlansUpdates']['totalChanges'] > 0)
                            <ul>
                                @foreach ($notifications['trainingPlansUpdates'] as $array)
                                    @if (!$loop->last)
                                    @php
                                        $user = getUserUsingAthleteId($array['trainingPlan']['athlete_associated']);
                                        $plan = $array['trainingPlan'];
                                        $numOfFilesUpdated = count($array['idOfFilesUpdated']);
                                    @endphp
                                    <li>
                                        <div class="flexbox-vertical-container">
                                            <div class="user-and-avatar">
                                                <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                                                <div class="title-and-subtitle">
                                                    <p>{{$user->name . ' ' . $user->surname}}</p>
                                                    <p class="purple">{{$plan->title}} 
                                                        <span class="low-emphasis">
                                                            | Archivos actualizados: {{$numOfFilesUpdated}}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <button class="soft-btn" onclick="window.location='{{route('profile.show', ['user'=> $user->id, 'tab'=>'plan'])}}'">
                                                Ver
                                            </button>
                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                            @else
                            <div class="no-users-left-message">
                                <p>Sin actividad reciente</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
           </div>
       </div>
   </div>