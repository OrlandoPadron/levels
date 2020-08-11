<div id="remove-group">
    <div class="heading-section">
        <h1 class="primary-blue-color">Gestionar Grupo</h1>
    </div>
    <form action="{{route('group.destroy')}}" method="POST">
        @csrf
        <input type="text" name="group_id" value="{{$group->id}}" hidden>
        <button class="btn-activate-account" type="submit">Eliminar grupo</button>
    </form>

</div>