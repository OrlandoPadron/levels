<h1 class="primary-blue-color">Detalles de la cuenta</h1>
@if ($user->account_activated == 0)
<div class="info-account">
    <i class="fas fa-info-circle"></i>
    <div class="info-message">
        <p>La cuenta se encuentra desactivada.</p>
        <p>Puedes volver a activarla pulsando sobre el botón <span class="bold">'Activar Cuenta'</span>.</p>
    </div>
</div>
@endif
@if($user->account_activated == 1)
<form action="{{route('profile.deactivate')}}" method="POST">
    @csrf
    <input type="text" value="{{$user->id}}" name="user_id" hidden>
    <button class="btn-gray-basic"><i class="fas fa-user-slash"></i> Desactivar cuenta</button>
</form>
@else
<form action="{{route('profile.activate')}}" method="POST">
    @csrf
    <input type="text" value="{{$user->id}}" name="user_id" hidden>
    <button class="btn-activate-account"><i class="fas fa-user-check"></i> Activar cuenta</button>
</form>
@endif