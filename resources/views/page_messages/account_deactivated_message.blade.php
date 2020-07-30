<div class="warning-account">
    <i class="fas fa-exclamation-triangle"></i>
    <div class="warning-message">
        @if(Auth::user()->admin == 1)
        <p>La cuenta se encuentra desactivada.</p>
        <p>Puedes volver a activarla en el <span class="bold">'Panel de Administrador'</span>.</p>
        @else
        <p>La cuenta se encuentra desactivada.</p>
        <p>Contacta con un administrador para más información.</p>
        @endif
    </div>
</div>