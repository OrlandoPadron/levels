<div class="explanation-info">
    <div class="info-message">
        @if($user->id == Auth::user()->id)
        <p>Tu sección, a tu gusto</p>
        <p>Aquí podrás incluir cualquier tipo de información que consideres relevante sobre ti.</p>
        <p>Pulsa sobre el botón <span class="bold">'Añadir sección'</span> para comenzar.</p>
        @else
        <p>¡Bienvenido al perfil de {{getName($user->id)}}!</p>
        <p>Actualmente su esta sección está vacía. ¡Esperemos que por poco tiempo!</p>

        @endif
    </div>
</div>