<div class="trainer-info-account">
    <i class="fas fa-dumbbell"></i>
    <div class="trainer-info-message">
        @if($user->athlete->trainer_id != null)
            <p>{{getTrainersNameByTrainerId($user->athlete->trainer_id)}} es el entrenador de {{$user->name .' '. $user->surname}}.</p>
            <p>No podrás entrenar a {{$user->name}} si ya está entrenando otra persona.</p>
        @else
            <p>Puedes entrenar a {{$user->name .' '. $user->surname}}.</p>
            <p>Pulsa sobre el botón <span class="bold">'Entrenar'</span> para empezar.</p>
        @endif
    </div>
</div>