<!-- Fee Status modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="feeStatusModal">
    <!-- Modal content -->
       <div class="modal-content" @click.away="feeStatusModal=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="feeStatusModal=!feeStatusModal">&times;</span>
               <h2>Estado de Mes</h2>
           </div>
           <div class="modal-body">
            <p>Fee status</p>
            <h2>Gente que no ha pagado</h2>
            @foreach (getArrayOfAthletesWhoHaventPayMonthYet(Auth::user()->trainer->id) as $athlete)
                <p>{{$athlete->user->name}}</p>
            @endforeach
            <h2>Gente que ha pagado</h2>
            @foreach(collect(getArrayOfAthletesTrainedByTrainerId(Auth::user()->trainer->id))->filter->monthPaid as $key => $athlete)
                <p>{{$athlete->user->name}}</p>
            @endforeach
           </div>

           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>

<script>
</script>