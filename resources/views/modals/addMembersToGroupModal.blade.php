<!-- Add Members to Group -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addMembers">
    <!-- Modal content -->
       <div class="modal-content add-member-to-group-modal" @click.away="addMembers=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="addMembers=!addMembers">&times;</span>
               <h2>Añadir usuarios al grupo</h2>
           </div>
           <div class="modal-body">
               
               <form action="{{route('group.addMember')}}" method="POST">
                    @csrf
                    <input type="text" name="group_id" value="{{$group->id}}" hidden>
                    <div class="modal-body-container">
                        <div class="item-with-container">
                            <p>Deportistas que entrenas <span class="members-selected">(3 seleccionados)</span></p>
                            @if(getUsersTrainedByMeWhoArentInTheGroupYet($group->id)->count() == 0)
                                <p>Todos los deportistas que entrenas están metidos en el grupo.</p>
                            @else
                            <div>
                                <ul>
                                    @foreach (getUsersTrainedByMeWhoArentInTheGroupYet($group->id) as $key=>$user)  
                                    <li>
                                        <div class="flexbox-vertical-container">
                                            <input onchange="prueba()" type="checkbox" name="usersId[]" value="{{$user->id}}" id="cbox_{{$key}}">
                                            <div class="user-and-avatar">
                                                <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                                                <p>{{$user->name . ' ' . $user->surname}}</p>
                                            </div>
                                            <label for="cbox_{{$key}}" class="soft-btn">
                                                Añadir
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="item-with-container">
                            <p>Entrenadores <span class="members-selected">(3 seleccionados)</span></p>
                            <div>
                                <ul>
                                    @foreach(getAllTrainersWhoArentInThisGroupYet($group->id) as $key => $user)
                                    <li>
                                        <div class="flexbox-vertical-container">
                                            <input onchange="prueba()" type="checkbox" name="usersId[]" value="{{$user->id}}" id="cboxT_{{$user->id}}">
                                            <div class="user-and-avatar">
                                                <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                                                <p>{{$user->name . ' ' . $user->surname}}</p>
                                            </div>
                                            <label for="cboxT_{{$user->id}}" class="soft-btn">
                                                Añadir
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="modal-buttons">
                            <div class="principal-button">
                                <button disabled class="btn-add-basic" id="upload-btn" type="submit"
                                onclick="">Guardar cambios</button>
                            </div>
    
                        </div>
                    </div>








                {{-- 
                
                <label for="">Deportistas que entrenas</label>
                @foreach(collect(getArrayOfUsersTrainedByMe(Auth::user()->trainer->id))->filter(function ($user){
                    return $user;
                }) as $key=>$user)
                <p>{{$user->name}}</p>
                <input type="checkbox" name="usersId[]" value="{{$user->id}}" id="cbox_{{$key}}"> <label for="cbox_{{$key}}">Añadir</label> 

                @endforeach

                <br><label for="">Entrenadores</label>
                @foreach(getAllTrainersAsUsers() as $key=>$userT)
                <p>{{$userT->name}}</p>
                <input type="checkbox" name="usersId[]" value="{{$userT->id}}" id="cbox_{{$key}}"> <label for="cbox_{{$key}}">Añadir</label> 

                @endforeach --}}
                {{-- 
                <ul id="ul_addMembers">
                @if(Auth::user()->trainer->trained_by_me != null)
                    @foreach(Auth::user()->trainer->trained_by_me as $key=>$athlete_id)
                        <li id="li_member_{{$athlete_id}}" style="{{athleteIsNotMemberOfThisGroup($group->id, $athlete_id) ? '' : 'display: none;'}}">
                            <p>{{getUserUsingAthleteId($athlete_id)->name . ' ' . getUserUsingAthleteId($athlete_id)->surname}}</p>
                            <input type="checkbox" name="usersId[]" value="{{$athlete_id}}" id="cbox_{{$key}}"> <label for="cbox_{{$key}}">Añadir</label> 
                        </li>               
                    @endforeach
                @endif --}}
                    
            </form>
           </div>
       </div>
   </div>

<script>


    function prueba(){
        var total=$(document).find('input[name="usersId[]"]:checked').length;
        if (total > 0){
            $('#upload-btn').prop('disabled', false);
        }else{
            $('#upload-btn').prop('disabled', true);
        }
    }

</script>