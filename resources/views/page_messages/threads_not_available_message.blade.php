<div class="info-account">
    <i class="fas fa-info-circle"></i>
    <div class="info-message">
        @if($user->id == Auth::user()->id)
        <p>Aún no tienes ningún hilo activo.</p>
        <p>Puedes crear uno nuevo pulsando sobre <span class="bold">'Nuevo hilo'</span>.</p>
        @else
        <p>El foro de {{$user->name . ' ' . $user->surname}} no tiene ningún hilo activo.</p>
        <p>Puedes crear uno nuevo pulsando sobre <span class="bold">'Nuevo hilo'</span>.</p>
        
        @endif
    </div>
</div>