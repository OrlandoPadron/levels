<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="planStatusModal">
    <!-- Modal content -->
       <div class="modal-content" @click.away="planStatusModal=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="planStatusModal=!planStatusModal">&times;</span>
               <h2>Estado de Mes</h2>
           </div>
           <div class="modal-body">
            <p>Training Plan status</p>
            <h2>Planes actualizados</h2>
            @foreach ($notifications['trainingPlansUpdates'] as $array)
                @if (!$loop->last)
                @php
                    $user = getUserUsingAthleteId($array['trainingPlan']['athlete_associated']);
                @endphp
                <p>{{$array['trainingPlan']['title']}}</p>
                <p>Usuario: {{$user->name}}</p>
                <p>Ficheros modificados</p>
                @foreach ($array['idOfFilesUpdated'] as $fileid)
                    @php
                        $file = getFileModelGivenItsId($fileid);
                    @endphp
                    <p>{{$file->file_name}}</p>
                    <a style="color:black;" href="{{route('profile.show', ['user'=> $file->user->id, 'tab'=>'plan'])}}">Ver sección</a>
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