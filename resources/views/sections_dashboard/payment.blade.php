<h1 class="primary-blue-color">Cuotas</h1>
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
    
@endif
<div class="fee-training">
    <div class="fee-training-title">
        <p class="bold second_title">Detalles de la cuota</p>
    </div>
    <div class="fee-training-details shadow-container {{$user->account_activated == 1 ? '' : 'account_deactivated'}}">
        <div class="fee-training-details-status">
           <p class="bold container-title">Estado de Abril </p>
           <span class="light container-data">({{date('01/m/Y')}} - {{date('t/m/Y')}})</span>
           <p id="fee-payment-info" class="{{$user->athlete->monthPaid == 1 ? 'month_paid' : 'month_unpaid'}}">{{$user->athlete->monthPaid == 1 ? 'PAGADO' : 'PENDIENTE'}}</p>
        </div>
        <div class="fee-training-details-details">
            <div class="separation-plan"></div>
            <div id="fee-details">
                <div class="suscription-type">
                    <p class="bold">Tipo de entrenamiento</p>
                    <p id="fee-details">Entrenamiento básico por <span id="fee-monthly-price">30€ /mes</span></p>
                </div>
                <div class="next-fee">
                    <p class="bold">Próximo pago</p>
                    <p id="next-fee-date">{{date('1 \d\e %B \d\e Y', strtotime('+ 1 month'))}}</p>
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
        <p class="bold second_title">Historial de facturación <span class="light">(último año)</span></p>
        <table class="fee-table">
            <tr>
                <th>Fecha</th>
                <th>Tipo de entrenamiento</th>
                <th>Período del servicio</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>01/03/2020</td>
                <td>Entrenamiento básico</td>
                <td>01/03/2020 - 01/04/2020</td>
                <td>30,00 € </td>
            </tr>
            <tr>
                <td>01/02/2020</td>
                <td>Entrenamiento básico</td>
                <td>01/02/2020 - 01/03/2020</td>
                <td>30,00 € </td>
            </tr>
        </table>
    </div>
</div>