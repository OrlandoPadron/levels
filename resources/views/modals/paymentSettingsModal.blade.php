<!-- Payment settings -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="paymentSettings">
    <!-- Modal content -->
       <div class="modal-content set-payment-modal" @click.away="paymentSettings=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="paymentSettings=!paymentSettings">&times;</span>
               <h2>Configurar cuota</h2>
           </div>
           <div class="modal-body">
            <div class="modal-body-container">
                <div class="item-with-input">
                    <p>Tipo de cuota</p>
                    <input type="text" name="subscription" value="{{$user->athlete->subscription_description == null ? '' : $user->athlete->subscription_description}}">
                </div>
                <div class="item-with-input">
                    <p>Precio</p>
                    <input type="text" name="price" value="{{$user->athlete->subscription_price == null ? '' : $user->athlete->subscription_price}}">
                </div>
                <div class="modal-buttons">
                    <div class="principal-button">
                        <button class="btn-add-basic" onclick="updateSubscriptionOnAthlete()">Guardar</button>
                    </div>
                </div>
            </div>
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
                    if (subscription != "" && price != ""){
                        $("p#fee-details").html(subscription+'<span id="fee-monthly-price"> '+parseFloat(price)+'€ /mes</span>');
                        $('.subscription_needed').hide();
                        $('.fee-training').show();
                    }else{
                        $('.subscription_needed').show();
                        $('.fee-training').hide();
                    }
                    $("#closeModal").click();
                    

                },
                error: function(){
                    alert('Se ha producido un error.');
                    console.log('Error on ajax call "updateSubscriptionOnAthlete" function');
                }  
            });
    }

   </script>