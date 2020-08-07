<!-- UploadFile Modal -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="uploadFile">
    <!-- Modal content -->
       <div class="modal-content upload-file-modal" @click.away="uploadFile=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="uploadFile=!uploadFile">&times;</span>
               <h2>Subir archivo</h2>
           </div>
           <div class="modal-body">
                <div class="modal-body-container">
                    <div class="item-with-button-add-file">
                        <button class="soft-btn" onclick="document.getElementById('file-upload').click();">Seleccionar archivo</button>
                        <p id="selected-file-name">Ningún archivo seleccionado</p>
                        <i id="file-load-status-icon" class="fas fa-check-circle"></i>
                        <input onchange="changeUI('upload')" id="file-upload" name="fileuploaded" type="file" 
                        accept="application/pdf, application/msword, image/*, 
                        application/vnd.ms-powerpoint, .csv, 
                        application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, 
                        application/vnd.ms-excel, video/*, audio/*" hidden/>

                    </div>
                    <div class="item-with-input">
                        <p>Nombre del archivo</p>
                        <input type="text" name="title" id="file-name-input" placeholder="Nombre del archivo" required>
                    </div>
                    <div class="item-with-progressbar">
                        <p>Estado de la subida</p>
                        <progress value="0" max="100" id="uploader">0%</progress>

                    </div>
                    <div class="modal-buttons">
                        <div class="principal-button">
                            <button disabled class="btn-add-basic" id="upload-btn" type="submit"
                            onclick="uploadFile({{Auth::user()->id}}, {{$user->id}}, 'AthleteFileSection')">Subir archivo</button>
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