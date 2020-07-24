<!-- Add New Section to My Wall -->
<div id="myModal" style="display: none;" class="modal" x-show.transition.duration.250ms.opacity="addWallSection">
    <!-- Modal content -->
       <div class="modal-content" @click.away="addWallSection=false">
           <div class="modal-header">
               <span id="closeModal" class="close" @click="addWallSection=!addWallSection">&times;</span>
               <h2>Añadir sección a mi muro</h2>
           </div>
           <div class="modal-body">
                <form action="{{route('user.myWall')}}" method="POST">
                    @csrf
                    <h2 class="underlined">Información general</h2>
                    <label for="title">Título</label><br>
                    <input type="text" name="title"><br>
                    <label for="description">Descripción</label><br>
                    <textarea cols="50" rows="5" name="content"></textarea><br>
                    <input type="text" name="method" hidden value="newSection">
                    <button type="submit">Crear</button>
                </form>
           </div>
           <div class="modal-footer">
               <h3>Modal Footer</h3>
           </div>
       </div>
   </div>

<script>
</script>