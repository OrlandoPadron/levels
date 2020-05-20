<h1 class="primary-blue-color">Detalles Generales</h1>
@if ($user->account_activated == 0)
    @include('page_messages.account_deactivated_message')
@endif