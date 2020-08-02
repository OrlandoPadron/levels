<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="forumStatusModal">
    <!-- Modal content -->
       <div class="modal-content" @click.away="forumStatusModal=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="forumStatusModal=!forumStatusModal">&times;</span>
               <h2>Forum</h2>
           </div>
           <div class="modal-body">
            <p>Forum status</p>
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
            @endforeach
           </div>

           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>

<script>
</script>