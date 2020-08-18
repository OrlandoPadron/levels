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