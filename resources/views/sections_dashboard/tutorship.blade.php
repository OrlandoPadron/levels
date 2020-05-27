<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                @click="addTutorshipSession=!addTutorshipSession" 
                @keydown.escape.window="addTutorshipSession=false">
        <i style="margin-right: 10px;" class="fas fa-people-arrows"></i> Añadir tutoría
    </button>

    {{-- <form action="{{route('tutorship.toggleBookmark')}}" method="POST">
        @csrf
        <input type="text" name="user_id" value="22">
        <input type="text" name="id_tutorship" value="6">
        <button type="submit">pruebas</button>
    </form> --}}
    @endif
    <h1 class="primary-blue-color">Tutorías</h1>
</div>
@include('modals.newTutorshipSession')
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
@endif

@foreach($user->athlete->tutorships->sortByDesc('created_at') as $key => $tutorship)
    @if($loop->first)
        <div id="tutorship-container-{{$tutorship->id}}" class="tutorship-container {{$tutorship->bookmarked == 1 ? 'tutorship-bookmarked' : ''}} shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
            <div class="tutorship-heading">
                <div class="tutorship-heading-title">
                    <p class="bold container-title">{{$tutorship->title}} <span id="tutorship_date" class="light">({{$tutorship->date}})</span> </p>
                <p class="tutorship-goal"><span class="tutorship-number"> #{{$tutorship->tutorship_number}} </span>{{$tutorship->goal}}</p>
                </div>
                <div class="tutorship-options">
                    <a><i class="far fa-edit"></i></a>
                    {{-- <a><i class="fas fa-edit"></i></a>
                    <a><i class="far fa-bookmark"></i></a> --}}
                    <a id="anchor-{{$tutorship->id}}" 
                        {{$tutorship->bookmarked == 1 ? 'class=tutorship-option-bookmarked':''}} 
                        onclick="setBookmark({{$tutorship->id}})">
                        <i 
                            id="icon-{{$tutorship->id}}" 
                            class="{{$tutorship->bookmarked == 1 ? 'fas ' : 'far '}}fa-bookmark">
                        </i>
                    </a>
                </div>
                <div class="separation-tutorship"></div>
            </div>
            <div class="tutorship-content">
                <div class="tutorship-description">
                    <p class="tutorship-section-title">Descripción</p>
                    <p class="tutorship-section-content">{{$tutorship->description}}
                    </p>
                </div>
                
            </div>
            {{-- <div class="tutorship-add-details">
                <button>Añadir detalles</button>
            </div> --}}
            {{-- <div class="tutorship-buttons">
                <button class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
                <button class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
            </div> --}}
        </div>
    @else
        <div id="tutorship-container-{{$tutorship->id}}" class="tutorship-container {{$tutorship->bookmarked == 1 ? 'tutorship-bookmarked' : ''}} shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
            <div class="tutorship-heading">
                <div class="tutorship-heading-title">
                    <p class="bold container-title">{{$tutorship->title}} <span id="tutorship_date" class="light">({{$tutorship->date}})</span> </p>
                <p class="tutorship-goal"><span class="tutorship-number"> #{{$tutorship->tutorship_number}} </span>{{$tutorship->goal}}</p>
                </div>
                <div class="tutorship-options">
                    <a><i class="far fa-edit"></i></a>
                    {{-- <a><i class="fas fa-edit"></i></a>
                    <a><i class="far fa-bookmark"></i></a> --}}
                    <a id="anchor-{{$tutorship->id}}" {{$tutorship->bookmarked == 1 ? 'class=tutorship-option-bookmarked':''}} onclick="setBookmark({{$tutorship->id}})"><i id="icon-{{$tutorship->id}}" class="{{$tutorship->bookmarked == 1 ? 'fas ' : 'far '}}fa-bookmark"></i></a>
                </div>
                <div class="separation-tutorship"></div>
            </div>
            <div class="tutorship-content">
                <div class="tutorship-description">
                    <p class="tutorship-section-title">Descripción</p>
                    <p class="tutorship-section-content">{{$tutorship->description}}
                    </p>
                </div>
                
            </div>
            {{-- <div class="tutorship-add-details">
                <button>Añadir detalles</button>
            </div> --}}
            {{-- <div class="tutorship-buttons">
                <button class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
                <button class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
            </div> --}}
        </div>
    @endif

    

@endforeach


{{-- <div class="tutorship-container tutorship-collapse shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
    <div class="tutorship-heading">
        <div class="tutorship-heading-title">
            <p class="bold container-title">Título de tutoría  <span id="tutorship_date" class="light">(26/05/2020)</span> </p>
            <p class="tutorship-goal"><span class="tutorship-number"> #1 </span>Tutoría inicial. Empieza a entrenar.</p>
        </div>
        <div class="tutorship-options">
            <a><i class="far fa-edit"></i></a>
            <a><i class="fas fa-edit"></i></a>
            <a><i class="far fa-bookmark"></i></a>
            <a><i class="fas fa-bookmark"></i></a>
        </div>
        <div class="separation-tutorship"></div>
    </div>
    <div class="tutorship-content">
        <div class="tutorship-description">
            <p class="tutorship-section-title">Descripción</p>
            <p class="tutorship-section-content">Analizamos planing Julio y Agosto: bien, las series bien. Nota mejoría en pulsaciones, le han bajado y se mantiene en la zona.
                Días de descanso? LUNES Y MIÉRCOLES.
                Actividad en Tenerife
                Objetivos de Artenara y Summer run no llegamos, son sólo test.
                Marcar zonas de entrenamiento en base a test de esfuerzo. Test de Cooper.
                Empieza con rutinas básicas de gimnasio. Más adelante metemos las SESIONES.
                En el primer mes construimos base aeróbica.
                Pasar número de cuenta BBVA. Paga Junio ya por transferencia.
                Se hizo test de esfuerzo muy básico, voy a tener que hacerle test de campo.
                35018
                En 150 y 170 ppm no se encuentra mal. Va a 6´el km a gusto.
                Fechas de Julio normal.
            </p>
        </div>
        <div class="tutorship-description">
            <p class="tutorship-section-title">A tener en cuenta</p>
            <p class="tutorship-section-content">Prefiere lunes y miércoles de descanso.</p>
        </div>
        <div class="tutorship-description">
            <p class="tutorship-section-title">Pendiente</p>
            <p class="tutorship-section-content">Enviarme analítica.</p>
        </div>
        
    </div>
    <div class="tutorship-add-details">
        <button>Añadir detalles</button>
    </div>
    <div class="tutorship-buttons">
        <button class="btn-add-basic"><i class="fas fa-save"></i> Guardar cambios</button>
        <button class="btn-gray-basic"><i style="margin-right: 5px;" class="fas fa-times"></i> Cancelar</button>
    </div>
</div> --}}
<script>
    function setBookmark(tutorshipId){ 
        console.log("Bookmarked");
        $.ajax({
            url: "{{route("tutorship.toggleBookmark")}}",
            type: "POST",
            data: {
                id_tutorship: tutorshipId,
                user_id: "{{$user->id}}",
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var id_container = "#tutorship-container-".concat(tutorshipId);
                var id_icon = "#icon-".concat(tutorshipId);
                var id_anchor = "#anchor-".concat(tutorshipId);

                if ( $(id_container).hasClass( "tutorship-bookmarked" )){
                    $(id_container).removeClass("tutorship-bookmarked");
                    $(id_icon).removeClass("fas");
                    $(id_icon).addClass("far");
                    $(id_anchor).removeClass("tutorship-option-bookmarked");
                }else{
                    $(id_container).addClass("tutorship-bookmarked");
                    $(id_icon).removeClass("far");
                    $(id_icon).addClass("fas");
                    $(id_anchor).addClass("tutorship-option-bookmarked");
                }
                
            },
            error: function(){
                console.log('Error on ajax call "setBookmark" function');
            }  
        });
    }
</script>