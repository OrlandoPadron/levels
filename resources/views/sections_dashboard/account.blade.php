<div class="heading-section">
    <h1 class="primary-blue-color">Detalles de la cuenta</h1>
</div>

<h2 class="primary-blue-color heading-text-container">Información general</h2>
<div class="text-container shadow-container">
    <div class="text-container-content">
        <ul>
            <li>
                <span class="text-container-content-section">Nombre:</span>
                <p>{{$user->name}}</p>
            </li>
            <li>
                <span class="text-container-content-section">Apellidos:</span> 
                <p>{{$user->surname}}</p>
            </li>
            <li>
                <span class="text-container-content-section">Email:</span> 
                <p>{{$user->email}}</p>
            </li>
            <li>
                <span class="text-container-content-section">Administrador:</span> 
                <p>{{$user->admin == 0 ? 'No' : 'Sí'}}</p>
            </li>
            <li>
                <span class="text-container-content-section">Cuenta creada:</span> 
                <p>{{$user->created_at->format("d/m/Y")}} <span class="dot-separation">·</span> {{$user->created_at->diffForHumans()}}</p>
            </li>
        </ul>
    </div>
</div>

@if($user->account_activated == 1)
<!--DEACTIVE ACCOUNT-->
<form action="{{route('profile.deactivate')}}" method="POST">
    @csrf
    <input type="text" value="{{$user->id}}" name="user_id" hidden>
    <button class="btn-gray-basic"><i class="fas fa-user-slash"></i> Desactivar cuenta</button>
</form>
@else
<form action="{{route('profile.activate')}}" method="POST">
    @csrf
    <input type="text" value="{{$user->id}}" name="user_id" hidden>
    <button class="btn-add-basic"><i class="fas fa-user-check"></i> Activar cuenta</button>
</form>
@endif