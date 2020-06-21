<!-- Add Members to Group -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addMembers">
    <!-- Modal content -->
       <div class="modal-content" @click.away="addMembers=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="addMembers=!addMembers">&times;</span>
               <h2>Opciones de la cuota</h2>
           </div>
           <div class="modal-body">
            <form action="{{route('group.addMember')}}" method="POST">
                @csrf
                <input type="text" name="group_id" hidden value="{{$group->id}}">
                <ul id="ul_addMembers">
                @if(Auth::user()->trainer->trained_by_me != null)
                    @foreach(Auth::user()->trainer->trained_by_me as $key=>$athlete_id)
                        <li id="li_member_{{$athlete_id}}" style="{{athleteIsNotMemberOfThisGroup($group->id, $athlete_id) ? '' : 'display: none;'}}">
                            <p>{{getUserUsingAthleteId($athlete_id)->name . ' ' . getUserUsingAthleteId($athlete_id)->surname}}</p>
                            <input type="checkbox" name="athletesId[]" value="{{$athlete_id}}" id="cbox_{{$key}}"> <label for="cbox_{{$key}}">Añadir</label> 
                        </li>               
                    @endforeach
                @endif
                    </ul>
                    <button type="submit">Confirmar</button>
            </form>
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>

<script>

    // function prueba(){
    //     var array = new Array(); 
    //     $('input[name^="addUsers"]:checked').each(function() {
    //         array.push($(this).val());
    //         alert($(this).val());
    //     });

    //     console.log(array);
    // }

</script>