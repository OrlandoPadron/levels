<div class="heading-section">
    <button class="btn-gray-basic button-position"
                    @click="paymentSettings=!paymentSettings" 
                    @keydown.escape.window="paymentSettings=false"
                    
                ><i style="margin-right: 5px;" class="fas fa-cog"></i> Configurar cuota
    </button>
    <h1 class="primary-blue-color">Cuotas</h1>
</div>
@include('modals.paymentSettingsModal')
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
    
@endif
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
                    {{-- date('1 \d\e F \d\e Y', strtotime('+ 1 month')) --}}
                    <p id="next-fee-date">{{Date::parse('first day next month')->format('1 \d\e F \d\e Y')}}</p>
                </div>

            </div>
            
        </div>
        <div class="fee-training-details-buttons">
            @if($user->athlete->monthPaid == 1)
                <form action="{{route('profile.setMonthAsNotPaid')}}" method="POST">
                    @csrf
                    <input type="text" value="{{$user->id}}" name="user_id" hidden>
                    <button class="btn-purple-basic"><i style="font-size: 15px;" class="fas fa-times"></i> Marcar como no pagado</button>
                </form>
            @else
                <form action="{{route('profile.setMonthAsPaid')}}" method="POST">
                    @csrf
                    <input type="text" value="{{$user->id}}" name="user_id" hidden>
                    <button class="btn-add-basic"><i style="font-size: 15px;" class="fas fa-coins"></i> Marcar como pagado</button>
                </form>
            @endif    
        </div>
    </div>
    <div class="fee-training-history">
        <p class="bold second_title">Historial de facturación <span class="light">(meses anteriores)</span></p>
        {{-- {{$invoices->links("pagination::default")}} --}}
        <table class="fee-table">
            <tr>
                <th>Período del servicio</th>
                <th>Fecha de la aceptación</th>
                <th>Tipo de entrenamiento</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Gestionar</th>
            </tr>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{$invoice->active_month}}</td>
                    <td>{{$invoice->date}}</td>
                    <td>{{$invoice->subscription_title}}</td>
                    <td>{{$invoice->price}} € </td>
                    <td style="color:{{$invoice->isPaid == 1 ? 'green' : 'red'}};">{{$invoice->isPaid == 1 ? 'Pagado' : 'Sin pagar'}}</td>
                    <td>
                        @if ($invoice->isPaid==0)
                        <form action="{{route('profile.setInvoiceAsPaid')}}" method="POST">
                            @csrf
                            <input type="text" value="{{$user->id}}" name="user_id" hidden>
                            <input type="text" value="{{$invoice->id}}" name="invoice_id" hidden>
                            <button><i style="font-size: 15px;" class="fas fa-coins"></i> Pagado</button>
                        </form>

                        @else
                        <form action="{{route('profile.setInvoiceAsUnpaid')}}" method="POST">
                            @csrf
                            <input type="text" value="{{$user->id}}" name="user_id" hidden>
                            <input type="text" value="{{$invoice->id}}" name="invoice_id" hidden>
                            <button><i style="font-size: 15px;" class="fas fa-times"></i> Anular pago</button>
                        </form>
                        @endif
                        
                    </td>
                        
                </tr>
                
            @endforeach
        </table>
    </div>
</div>