<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="groupForumStatusModal">
    <!-- Modal content -->
       <div class="modal-content training-status-modals" @click.away="groupForumStatusModal=false">
            <div class="modal-header">
               <span id="closeModal" class="close" @click="groupForumStatusModal=!groupForumStatusModal">&times;</span>
               <h2>Actividad en Foros Grupales</h2>
           </div>
           <div class="modal-body">
            <div class="modal-body-container">
                <div class="item-with-container">
                    <p>Actualizaciones pendientes</p>
                    <div>
                        @if($notifications['gThreads']['totalNumOfNewChanges'] > 0)
                        <ul>
                            @foreach ($notifications['gThreads'] as $groupId => $array)
                                @if (!$loop->last)
                                    @foreach($array as $threadId => $threadArray)
                                        @php
                                            $group = getGroupById($groupId);
                                            $thread = getThreadGivenItsId($threadId); 
                                            $isNew = isset($threadArray['isNew']) ? true : false ;
                                        @endphp
                                        <li>
                                            <div class="flexbox-vertical-container">
                                                <div class="user-and-avatar">
                                                    <img src="/uploads/group_avatars/{{$group->group_image}}" alt="avatar">
                                                    <div class="title-and-subtitle">
                                                        <p>Grupo "{{$group->title}}"</p>
                                                        <p class="purple">Hilo: "{{$thread->title}}"
                                                            <span class="low-emphasis">
                                                                @if($isNew) 
                                                                | Nuevo  
                                                                @else
                                                                | Respuestas nuevas: {{$threadArray['numOfChanges']}}
                                                                @endif
                                                            </span>

                                                        </p>
                                                    </div>
                                                </div>
                                                <button class="soft-btn" onclick="window.location='{{route('group.show', [$group->id, 'foro'])}}'">
                                                    Ver
                                                </button>
                                            </div>
                                        </li>
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
           </div>
       </div>
   </div>
