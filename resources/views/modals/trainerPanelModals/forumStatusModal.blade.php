<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="forumStatusModal">
    <!-- Modal content -->
       <div class="modal-content training-status-modals" @click.away="forumStatusModal=false">
           @dump($notifications['athletesThreads'])
            <div class="modal-header">
               <span id="closeModal" class="close" @click="forumStatusModal=!forumStatusModal">&times;</span>
               <h2>Actividad en Foros</h2>
           </div>
           <div class="modal-body">
            <div class="modal-body-container">
                <div class="item-with-container">
                    <p>Actualizaciones pendientes</p>
                    <div>
                        @if($notifications['athletesThreads']['totalChanges'] > 0)
                        <ul>
                            @foreach ($notifications['athletesThreads'] as $athleteId => $array)
                                @if (!$loop->last)
                                    @foreach($array as $threadId => $threadArray)
                                        @if(!$loop->last)
                                        @php
                                            $user = getUserUsingAthleteId($athleteId);
                                            $thread = getThreadGivenItsId($threadId); 
                                        @endphp
                                        <li>
                                            <div class="flexbox-vertical-container">
                                                <div class="user-and-avatar">
                                                    <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                                                    <div class="title-and-subtitle">
                                                        <p>Foro de {{$user->name . ' ' . $user->surname}}</p>
                                                        {{-- <p class="purple">{{$plan->title}} 
                                                            <span class="low-emphasis">
                                                                | Archivos actualizados: {{$numOfFilesUpdated}}
                                                            </span>
                                                        </p> --}}
                                                    </div>
                                                </div>
                                                <button class="soft-btn" onclick="window.location='{{route('profile.show', ['user'=> $user->id, 'tab'=>'plan'])}}'">
                                                    Ver
                                                </button>
                                            </div>
                                        </li>
                                        @endif
                                    @endforeach    

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



            {{-- <p>Forum status</p>
            <h2>Foro</h2>
            @foreach ($notifications['athletesThreads'] as $athleteId => $array)
                @if (!$loop->last)
                @foreach($array as $threadId => $array)
                    @if(!$loop->last)
                        @php
                            $user_associated = getUserUsingAthleteId($athleteId);
                            $thread = getThreadGivenItsId($threadId);
                        @endphp
                        <p>{{$thread->title}}</p>
                        <p>{{$user_associated->name}}</p>
                        <p>Número de cambios sin ver: {{$array['numOfChanges']}}</p>
                    @endif
                    
                @endforeach
                @endif
            @endforeach --}}
           </div>
       </div>
   </div>

<script>
</script>