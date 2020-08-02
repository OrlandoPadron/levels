<!-- Add New Section to My Wall -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="uploadFile">
    <!-- Modal content -->
       <div class="modal-content" @click.away="uploadFile=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="uploadFile=!uploadFile">&times;</span>
               <h2>Subir fichero a mi muro</h2>
           </div>
           @if(!isset($isGroup))
           <div class="modal-body">
                <h2 class="primary-blue-color">Subida/Descarga de Archivos</h2>

                <progress value="0" max="100" id="uploader">0%</progress>
                <input id="file-upload" name="fileuploaded" type="file" accept="application/pdf, application/msword, image/*, application/vnd.ms-powerpoint, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, video/*, audio/*"/>
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
           </div>
           @else
           <p>Nada que ver</p>
           @endif
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>