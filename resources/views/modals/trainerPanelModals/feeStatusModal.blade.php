<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="feeStatusModal">
    <!-- Modal content -->
       <div class="modal-content training-status-modals" @click.away="feeStatusModal=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="feeStatusModal=!feeStatusModal">&times;</span>
               <h2>Estado de {{ucfirst(Date::now()->format('F'))}}</h2>
           </div>
           <div class="modal-body">
                <div class="modal-body-container">
                    <div class="item-with-container">
                        <p>Deportistas pendientes</p>
                        <div>
                            @if($notifications['athletesHaventPaid']->count() > 0)
                            <ul>
                                @foreach ($notifications['athletesHaventPaid'] as $athlete)
                                <li>
                                    <div class="flexbox-vertical-container">
                                        <div class="user-and-avatar">
                                            <img src="/uploads/avatars/{{$athlete->user->user_image}}" alt="avatar">
                                            <div class="title-and-subtitle">
                                                <p>{{$athlete->user->name . ' ' . $athlete->user->surname}}</p>
                                                @if($athlete->subscription_description == null && $athlete->payment_date == null)
                                                <p class="red-message">Cuota no determinada</p>
                                                @else
                                                <p class="red-message">Mes pendiente <span class="low-emphasis">| {{$athlete->subscription_description}}</span></p>
                                                @endif
                                            </div>
                                        </div>
                                        <button class="soft-btn" onclick="window.location='{{route('profile.show', ['user'=>$athlete->user->id, 'tab'=>'cuotas'])}}'">
                                            Ver
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="no-users-left-message">
                                <p>Ningún deportista pendiente</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @php
                        $collectionOfAthletesWhoHavePaid = collect(getArrayOfAthletesTrainedByTrainerId(Auth::user()->trainer->id))
                        ->filter->monthPaid->sortByDesc('payment_date');
                    @endphp
                    <div class="item-with-container">
                        <p>Deportistas al día</p>
                        <div>
                            @if($collectionOfAthletesWhoHavePaid->count() > 0)
                            <ul>
                                @foreach($collectionOfAthletesWhoHavePaid as $key => $athlete)
                                <li>
                                    <div class="flexbox-vertical-container">
                                        <div class="user-and-avatar">
                                            <img src="/uploads/avatars/{{$athlete->user->user_image}}" alt="avatar">
                                            <div class="title-and-subtitle">
                                                <p>{{$athlete->user->name . ' ' . $athlete->user->surname}}</p>
                                                <p class="green-message">Pagado el {{$athlete->payment_date}} <span class="low-emphasis">| {{$athlete->subscription_description}}</span></p>
                                            </div>
                                        </div>
                                        <button class="soft-btn" onclick="window.location='{{route('profile.show', ['user'=>$athlete->user->id, 'tab'=>'cuotas'])}}'">
                                            Ver
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="no-users-left-message">
                                <p>Ninguno de tus deportistas está al día</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
           </div>
       </div>
   </div>

<script>
</script>