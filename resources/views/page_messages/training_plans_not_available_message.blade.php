<div class="info-account">
    <i class="fas fa-info-circle"></i>
    <div class="info-message">
        @if($user->id == Auth::user()->id)
        <p>Aún no tienes ningún plan de entrenamiento asociado.</p>
        <p>Espera a que tu entrenador/a añada uno.</p>
        @else
        <p>{{$user->name . ' ' . $user->surname}} aún no tiene ningún plan de entrenamiento.</p>
        <p>Puedes añadir uno nuevo pulsando sobre el botón <span class="bold">'Nuevo plan'</span>.</p>
        @endif
    </div>
</div>