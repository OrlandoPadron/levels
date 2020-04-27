@extends('layouts.base-inside-app')
@section('head')
<link href="{{asset('css/edit_profile.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div class="content-edit">
    <div class="image-pack">
      <div class="image-container">
        <img src="/uploads/avatars/{{Auth::user()->user_image}}" alt="profile_picture" />
        <form action="{{route('profile.update_avatar')}}" enctype="multipart/form-data" method="POST">
          @csrf
          <label id="swap-image" for="file-upload">Cambiar imagen</label>
          <input id="file-upload" name="avatar" type="file" />
          <label for="delete-file">Eliminar imagen</label>
          <input type="checkbox" name="delete-avatar" id="delete-file" hidden>
          <button id="save-changes" type="submit">
            <i class="fas fa-check-circle"></i>Guardar
          </button>
        </form>
      </div>
    </div>
    <div class="data-pack">
      <div class="profile-data">
        <div class="personal-data">
          <h1>Información perfil</h1>
          <form action="">
            <h2>Datos personales</h2>
            <div class="basic-inputs">
              <label for="">Nombre</label>
              <input type="text" name="name" value="{{Auth::user()->name}}" />

              <label for="">Apellidos</label>
              <input type="text" name="surname" value="{{Auth::user()->surname}}" />
            </div>
            <button id="add-category">
              <i class="fas fa-plus-circle"></i>Añadir nuevo campo
            </button>
            <button id="save-changes" type="submit">
              <i class="fas fa-check-circle"></i>Guardar
            </button>
          </form>
          <form id="form-additional-info" action="">
            <h2>Información adicional</h2>
            <textarea
              rows="7"
              name="additional-info"
              form="form-additional-info"
            >
Escríbenos sobre ti...</textarea
            >
            <button id="save-changes" type="submit">
              <i class="fas fa-check-circle"></i>Guardar
            </button>
          </form>
          <div class="file-list">
            <h2>Archivos adjuntos</h2>
            <table>
              <tr>
                <th>Nombre fichero</th>
                <th>Descripción</th>
                <th>Gestionar</th>
              </tr>
              <tr>
                <td>Peter</td>
                <td>Griffin</td>
                <td>$100</td>
              </tr>
            </table>
            <form
              id="add-files-documentation"
              action=""
              enctype="multipart/form-data"
            >
              <label>Descripción fichero:</label>
              <input
                type="text"
                placeholder="Por ejemplo: 'Pruebas físicas'"
              />
              <input type="file" />
              <button id="save-changes" type="submit">
                <i class="fas fa-cloud-upload-alt"></i> Subir archivo
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection