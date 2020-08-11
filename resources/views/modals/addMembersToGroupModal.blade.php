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
                            <p>Deportistas que entrenas</p>
                            
                            <div>
                                <ul>
                                    @if(getUsersTrainedByMeWhoArentInTheGroupYet($group->id)->count() != 0)
                                        @foreach (getUsersTrainedByMeWhoArentInTheGroupYet($group->id) as $key=>$user)  
                                        <li>
                                            <div class="flexbox-vertical-container">
                                                <input onchange="changeUI('addMembersToGroup', {{$user->id}})" type="checkbox" name="usersId[]" value="{{$user->id}}" id="cbox_{{$user->id}}">
                                                <div class="user-and-avatar">
                                                    <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                                                    <p>{{$user->name . ' ' . $user->surname}}</p>
                                                </div>
                                                <label for="cbox_{{$user->id}}" class="soft-btn" id="addLabelGroup_{{$user->id}}">
                                                    Añadir
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                    <li class="no-members-left-to-add">
                                        <p>Todos los deportistas que entrenas están metidos en el grupo.</p>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                        <div class="item-with-container">
                            <p>Entrenadores</p>
                            <div>
                                <ul>
                                    @if(getAllTrainersWhoArentInThisGroupYet($group->id)->count() != 0)

                                        @foreach(getAllTrainersWhoArentInThisGroupYet($group->id) as $key => $user)
                                        <li>
                                            <div class="flexbox-vertical-container">
                                                <input onchange="changeUI('addMembersToGroup', {{$user->id}})" type="checkbox" name="usersId[]" value="{{$user->id}}" id="cbox_{{$user->id}}">
                                                <div class="user-and-avatar">
                                                    <img src="/uploads/avatars/{{$user->user_image}}" alt="avatar">
                                                    <p>{{$user->name . ' ' . $user->surname}}</p>
                                                </div>
                                                <label for="cbox_{{$user->id}}" class="soft-btn"  id="addLabelGroup_{{$user->id}}">
                                                    Añadir
                                                </label>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                    <li class="no-members-left-to-add">
                                        <p>Todos los entrenadores del sistema están metidos en el grupo.</p>
                                    </li>
                                    @endif
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
            </form>
           </div>
       </div>
   </div>