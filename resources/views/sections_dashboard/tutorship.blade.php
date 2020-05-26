<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                    @click="addTutorship=!addTutorship" 
                    @keydown.escape.window="addTutorship=false"
                    
                ><i style="margin-right: 10px;" class="fas fa-people-arrows"></i> Añadir tutoría
    </button>
    @endif
    <h1 class="primary-blue-color">Tutorías</h1>
</div>
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
@endif

<div class="tutorship-container tutorship-bookmarked shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}"">
    <div class="tutorship-heading">
        <p class="bold container-title">Título de tutoría  <span id="tutorship_date" class="light">(26/05/2020)</span> </p>
        <p class="tutorship-goal">Tutoría inicial. Empieza a entrenar.</p>
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
</div>