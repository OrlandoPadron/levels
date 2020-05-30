<!-- Payment settings -->
<div id="myModal" class="modal" x-show.transition.duration.250ms.opacity="paymentSettings">
    <!-- Modal content -->
       <div class="modal-content" @click.away="paymentSettings=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="paymentSettings=!paymentSettings">&times;</span>
               <h2>Opciones de la cuota</h2>
           </div>
           <div class="modal-body">
                <h2 class="underlined">Cuota</h2>
                <input type="text" hidden name="user_id" value="{{$user->id}}">
                <label for="title">Tipo de cuota</label><br>
                <input type="text" name="subscription" value="{{$user->athlete->subscription_description == null ? '' : $user->athlete->subscription_description}}"><br>
                <label>Precio</label><br>
                <input type="text" name="price" value="{{$user->athlete->subscription_price == null ? '' : $user->athlete->subscription_price}}"><br>
                <input type="number" hidden name="athlete_associated" value="{{$user->athlete->id}}">
                <button onclick="updateSubscriptionOnAthlete()">Guardar</button>
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>

   <script>
        function updateSubscriptionOnAthlete(){
            console.log('Update subscription on Athlete');
            var subscription = $("input[name=subscription]").val();
            var price = $("input[name=price]").val();
            console.log("Subscription: " + subscription + " Price: " + price);
            $.ajax({
                url: "{{route("athlete.updateSubscription")}}",
                type: "POST",
                data: {
                    athlete_id: {{$user->athlete->id}},
                    subscription: subscription,
                    price: price,
                    _token: "{{csrf_token()}}",
                },
                success: function(){
                    $("p#fee-details").html(subscription+'<span id="fee-monthly-price"> '+parseFloat(price)+'€ /mes</span>');
                    $("#closeModal").click();

                },
                error: function(){
                    alert('Se ha producido un error.');
                    console.log('Error on ajax call "updateSubscriptionOnAthlete" function');
                }  
            });
    }

   </script>