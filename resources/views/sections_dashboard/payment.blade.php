<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-gray-basic button-position"
                    @click="paymentSettings=!paymentSettings" 
                    @keydown.escape.window="paymentSettings=false"
                    
                ><i style="margin-right: 5px;" class="fas fa-cog"></i> Configurar cuota
    </button>
    @endif
    <h1 class="primary-blue-color">Cuotas</h1>
</div>
@include('modals.paymentSettingsModal')
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')   
@endif
<div class="subscription_needed">
    @include('page_messages.subscription_needed_message')
</div>
<div class="fee-training">
    <div class="fee-training-title">
        <p class="bold second_title">Detalles mensualidad actual</p>
    </div>
    <div class="fee-training-details shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
        <div class="fee-training-details-status">
           <p class="bold container-title">Estado de {{ucfirst(strval(Date::now()->format('F')))}} </p>
           <span class="light container-data">({{date('01/m/Y')}} - {{date('t/m/Y')}})</span>
           <p id="fee-payment-info" class="{{$user->athlete->monthPaid == 1 ? 'month_paid' : 'month_unpaid'}}">{{$user->athlete->monthPaid == 1 ? 'PAGADO' : 'PENDIENTE'}}</p>
        </div>
        <div class="fee-training-details-details">
            <div class="separation-plan"></div>
            <div id="fee-details">
                <div class="suscription-type">
                    <p class="bold">Tipo de entrenamiento</p>
                    <p id="fee-details">{{$user->athlete->subscription_description}} <span id="fee-monthly-price">{{$user->athlete->subscription_price}}€ /mes</span></p>
                </div>
                <div class="next-fee">
                    <p class="bold">Próximo pago</p>
                    <p id="next-fee-date">{{Date::parse('first day next month')->format('1 \d\e F \d\e Y')}}</p>
                </div>

            </div>
            
        </div>
        @if ($user->account_activated == 1)
            <div class="fee-training-details-buttons">
                @if($user->athlete->monthPaid == 1)
                    <button id="unpay_button" onclick="toggleMonthPayment({{$user->athlete->id}}, {{$user->athlete->monthPaid}})" class="btn-purple-basic"><i style="font-size: 15px;" class="fas fa-times"></i> Marcar como no pagado</button>
                    <button id="pay_button" style="display: none;" onclick="toggleMonthPayment({{$user->athlete->id}}, {{$user->athlete->monthPaid}})" class="btn-add-basic"><i style="font-size: 15px;" class="fas fa-coins"></i> Marcar como pagado</button>

                @else
                    <button id="unpay_button" style="display: none;" onclick="toggleMonthPayment({{$user->athlete->id}}, {{$user->athlete->monthPaid}})" class="btn-purple-basic"><i style="font-size: 15px;" class="fas fa-times"></i> Marcar como no pagado</button>
                    <button id="pay_button"  onclick="toggleMonthPayment({{$user->athlete->id}}, {{$user->athlete->monthPaid}})" class="btn-add-basic"><i style="font-size: 15px;" class="fas fa-coins"></i> Marcar como pagado</button>
                
                @endif    
            </div>
        @endif
    </div>
    @if($invoices->isNotEmpty())
        <div class="fee-training-history">
            <p class="bold second_title">Historial de facturación <span class="light">(meses anteriores)</span></p>
            {{-- {{$invoices->links("pagination::default")}} --}}
            <table id="fee-table" class="fee-table">
                <thead>
                    <tr>
                        <th>Período del servicio</th>
                        <th>Fecha de la aceptación</th>
                        <th>Tipo de entrenamiento</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Gestionar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->active_month}}</td>
                            <td id="invoice_date_acceptation{{$invoice->id}}">{{$invoice->date}}</td>
                            <td>{{$invoice->subscription_title}}</td>
                            <td>{{$invoice->price}} € </td>
                            <td id="invoice_payment_status{{$invoice->id}}" style="color:{{$invoice->isPaid == 1 ? 'green' : 'red'}};">{{$invoice->isPaid == 1 ? 'Pagado' : 'Sin pagar'}}</td>
                            <td>
                                @if ($invoice->isPaid==0)
                                <button id="payInvoice_button{{$invoice->id}}" onclick="setInvoiceAsPaid({{$invoice->id}}, '{{date('d/m/Y')}}')"><i style="font-size: 15px;" class="fas fa-coins"></i> Pagado</button>
                                <button style="display: none;" id="unpayInvoice_button{{$invoice->id}}" onclick="setInvoiceAsUnpaid({{$invoice->id}}, '{{date('d/m/Y')}}')"><i style="font-size: 15px;" class="fas fa-times"></i> Anular pago</button>
                                {{-- <form action="{{route('profile.setInvoiceAsPaid')}}" method="POST">
                                    @csrf
                                    <input type="text" value="{{$user->id}}" name="user_id" hidden>
                                    <input type="text" value="{{$invoice->id}}" name="invoice_id" hidden>
                                </form> --}}
                                @else
                                <button id="unpayInvoice_button{{$invoice->id}}" onclick="setInvoiceAsUnpaid({{$invoice->id}}, '{{date('d/m/Y')}}')"><i style="font-size: 15px;" class="fas fa-times"></i> Anular pago</button>
                                <button style="display: none;" id="payInvoice_button{{$invoice->id}}" onclick="setInvoiceAsPaid({{$invoice->id}}, '{{date('d/m/Y')}}')"><i style="font-size: 15px;" class="fas fa-coins"></i> Pagado</button>
    
                                @endif
                                
                            </td>
                                
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>
            
        </div>
    @endif
</div>
<script>
    var status = -1; 

    $(document).ready(function() {
        $('#fee-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": 5 },
                { "searchable": false, "targets": 0 }
            ],
            "bFilter": false
        });
    } );

    //Payment Configuration message required. 
    $(document).ready(function(){
        var subs_description = "{{$user->athlete->subscription_description}}";
        var subscription_price = "{{$user->athlete->subscription_price}}";
        if(subs_description == "" && subscription_price == ""){
            $('.subscription_needed').show();
            $('.fee-training').hide();
            
        }else{
            $('.subscription_needed').hide();
            $('.fee-training').show();
        }
    })

    function toggleMonthPayment(athlete_id, statusWhenInitialized){ 
        console.log("Toggle Month Payment");
        $.ajax({
            url: "{{route("athlete.toggleMonthPayment")}}",
            type: "POST",
            data: {
                athlete_id: athlete_id,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                if (status == -1){
                    status = statusWhenInitialized;
                }
                if (status == 1){
                    status = 0;
                    $("#fee-payment-info").text("PENDIENTE");
                    $("#fee-payment-info").removeClass("month_paid");
                    $("#fee-payment-info").addClass("month_unpaid");
                    $("#unpay_button").hide();
                    $("#pay_button").show();



                }else{
                    status = 1; 
                    $("#fee-payment-info").text("PAGADO");
                    $("#fee-payment-info").removeClass("month_unpaid");
                    $("#fee-payment-info").addClass("month_paid");
                    $("#pay_button").hide();
                    $("#unpay_button").show();
                }
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "toggleMonthPayment" function');
            }  
        });
    }

    function setInvoiceAsPaid(invoice_id, date){
        console.log('Set Invoice ' + invoice_id + ' as Paid');
        $.ajax({
            url: "{{route("invoice.setInvoiceAsPaid")}}",
            type: "POST",
            data: {
                invoice_id: invoice_id,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var invoice_acceptation = "#invoice_date_acceptation".concat(invoice_id);
                var invoice_payment_status = "#invoice_payment_status".concat(invoice_id);
                var pay_button = "#payInvoice_button".concat(invoice_id);
                var unpay_button =  "#unpayInvoice_button".concat(invoice_id);

                $(invoice_acceptation).text(date);
                $(invoice_payment_status).css("color", "green");
                $(invoice_payment_status).text("Pagado");
                $(pay_button).hide();
                $(unpay_button).show();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "setInvoiceAsPaid" function');
            }  
        });
    }

    function setInvoiceAsUnpaid(invoice_id, date){
        console.log('Set Invoice ' + invoice_id + ' as Unpaid');
        $.ajax({
            url: "{{route("invoice.setInvoiceAsUnpaid")}}",
            type: "POST",
            data: {
                invoice_id: invoice_id,
                _token: "{{csrf_token()}}",
            },
            success: function(){
                var invoice_acceptation = "#invoice_date_acceptation".concat(invoice_id);
                var invoice_payment_status = "#invoice_payment_status".concat(invoice_id);
                var pay_button = "#payInvoice_button".concat(invoice_id);
                var unpay_button =  "#unpayInvoice_button".concat(invoice_id);

                $(invoice_acceptation).text("");
                $(invoice_payment_status).css("color", "red");
                $(invoice_payment_status).text("Sin pagar");
                $(unpay_button).hide();
                $(pay_button).show();
                
            },
            error: function(){
                alert('Se ha producido un error.');
                console.log('Error on ajax call "setInvoiceAsPaid" function');
            }  
        });
    }
</script>