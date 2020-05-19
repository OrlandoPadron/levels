<h1 class="primary-blue-color">Cuotas</h1>
<div class="fee-training">
    <div class="fee-training-title">
        <p class="bold second_title">Detalles de la cuota</p>
    </div>
    <div class="fee-training-details shadow-container">
        <div class="fee-training-details-status">
           <p class="bold">Estado de Abril: <span class="light">(01/04/20 - 01/05/2020)</span></p>
           <p id="fee-payment-info" class="month_paid">PAGADO</p>
        </div>
        <div class="fee-training-details-details">
            <div class="separation-plan"></div>
            <div id="fee-details">
                <div class="suscription-type">
                    <p class="bold">Tipo de entrenamiento</p>
                    <p id="fee-details">Entrenamiento básico por <span id="fee-monthly-price">30€ /mes</span></p>
                </div>
                <div class="next-fee">
                    <p class="bold">Próxima factura</p>
                    <p id="next-fee-date">1 de mayo de 2020</p>
                </div>

            </div>
            
        </div>
        <div class="fee-training-details-buttons">
            <button class="btn-purple-basic">Cancelar pago</button>
            <form action="" method="POST">
                @csrf
                <input type="text" value="" name="id_plan" hidden>
                <input type="text" value="" name="user_id" hidden>
                <button class="btn-gray-basic"><i class="fas fa-user-slash"></i> Desactivar cuenta</button>
            </form>
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
                <td>01/03/2020</td>
                <td>Entrenamiento básico</td>
                <td>01/03/2020 - 01/04/2020</td>
                <td>30,00 € </td>
            </tr>
        </table>
    </div>
</div>