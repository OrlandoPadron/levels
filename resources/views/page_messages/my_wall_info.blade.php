<div class="explanation-info">
    <div class="info-message">
        @if($user->id == Auth::user()->id)
        <p>¡Bienvenido a tu muro!</p>
        <p>Aquí podrás incluir cualquier tipo de información que consideres relevante sobre ti.</p>
        <p>Pulsa sobre el botón <span class="bold">'Añadir sección'</span> para comenzar.</p>
        @else
        <p>¡Bienvenido al muro de {{getName($user->id)}}!</p>
        <p>Actualmente su muro está vacío. ¡Esperemos que por poco tiempo!</p>

        @endif
    </div>
</div>