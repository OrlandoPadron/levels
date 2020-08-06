<h2 class="primary-blue-color heading-text-container">Imagen de usuario</h2>
<div class="settings-content-section">
  <h3 class="primary-blue-color settings-sub-heading">Cambiar imagen de usuario
  </h3>
  <div class="settings-change-img-container">
      <img class="inner-shadow" src="/uploads/avatars/{{Auth::user()->user_image}}" alt="profile_picture" />
      <form action="{{route('profile.update_avatar')}}" enctype="multipart/form-data" method="POST" id="myForm">
        @csrf
        
        <input onchange="submit();" id="file-upload" name="avatar" type="file" accept="image/*" hidden/>
        <input type="button" class="btn-purple-basic" value="Seleccionar imagen" onclick="document.getElementById('file-upload').click();"/>
        <label for="delete-file">Eliminar imagen actual</label>
        <input onchange="submit()" type="checkbox" name="delete-avatar" id="delete-file" hidden>
      </form>
  </div>

</div>