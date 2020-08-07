<!-- Add New Section to My Wall -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="shareFile">
    <!-- Modal content -->
       <div class="modal-content share-file-modal" @click.away="shareFile=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="shareFile=!shareFile">&times;</span>
               <h2>Compartir un archivo</h2>
           </div>
           <div class="modal-body">
                <div class="modal-body-container">
                    <div class="item-with-select">
                        <p>Selecciona el archivo que deseas compartir</p>
                        <p>Sólo aparecerán los archivos que hayas subido anteriormente a tu perfil y que no hayas compartido ya con {{getName($user->id)}}.</p>
                        <select onchange= "changeUI('share')" name="userFiles" id="filesNotShared">
                            <option selected value="0"> -- Archivo no seleccionado --</option>
                            @foreach(getUserFilesNotSharedWithCurrentUser(Auth::user()->id, $user->id) as $key => $file)
                                <option value="{{$file->id}}">{{$file->file_name . '.' . $file->extension}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-buttons">
                        <div class="principal-button">
                            <button disabled class="btn-add-basic" id="share-btn" type="submit"
                            onclick="shareFile({{$user->id}})">Compartir archivo</button>
                        </div>
                    </div>
                
                </div>
           </div>
               
       </div>
   </div>

   {{-- <h2 class="primary-blue-color">Subida/Descarga de Archivos</h2>
            @if(!isset($isGroup))

                <progress value="0" max="100" id="uploader">0%</progress>
                <button onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'AthleteFileSection')">Subir</button>
                @if (getUserFilesNotSharedWithCurrentUser(Auth::user()->id, $user->id)->count() >0)
                <p>Compartir un fichero propio</p>
                <select name="cars" id="filesNotShared">
                    @foreach(getUserFilesNotSharedWithCurrentUser(Auth::user()->id, $user->id) as $key => $file)
                        <option value="{{$file->id}}">{{$file->file_name}}</option>
                    @endforeach
                </select>
                <button onclick="shareFile({{$user->id}})">Compartir</button>
            @endif
            @else
            <input id="file-upload" name="fileuploaded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
            <button onclick="uploadFile({{Auth::user()->id}}, {{$group->id}}, 'GroupFileSection')">Subir</button>
            @endif
            </div> --}}