<!-- Payment settings -->
<div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="paymentSettings">
    <!-- Modal content -->
       <div class="modal-content" @click.away="paymentSettings=false">
           <div class="modal-header">
               <span class="close" @click="paymentSettings=!paymentSettings">&times;</span>
               <h2>Opciones de la cuota</h2>
           </div>
           <div class="modal-body">
               <form class="form-newplan" action="{{route('profile.updateSubscription')}}" method="POST">
                   @csrf
                   <h2 class="underlined">Cuota</h2>
                   <input type="text" hidden name="user_id" value="{{$user->id}}">
                   <label for="title">Tipo de cuota</label><br>
                   <input type="text" name="subscription" value="{{$user->athlete->subscription_description == null ? '' : $user->athlete->subscription_description}}"><br>
                   <label>Precio</label><br>
                   <input type="text" name="price" value="{{$user->athlete->subscription_price == null ? '' : $user->athlete->subscription_price}}"><br>
                   <input type="number" hidden name="athlete_associated" value="{{$user->athlete->id}}">
                   <button type="submit">Guardar</button>
               </form>
   
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>