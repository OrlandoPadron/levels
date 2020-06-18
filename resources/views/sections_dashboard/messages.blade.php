<div class="heading-section">
    @if ($user->account_activated == 1)
    <button class="btn-add-basic button-position"
                @click="addTutorshipSession=!addTutorshipSession"
                @keydown.escape.window="addTutorshipSession=false">
        <i style="margin-right: 5px;" class="fas fa-plus"></i> Añadir Mensaje
    </button>

    {{-- <form action="{{route('tutorship.toggleBookmark')}}" method="POST">
        @csrf
        <input type="text" name="user_id" value="22">
        <input type="text" name="id_tutorship" value="6">
        <button type="submit">pruebas</button>
    </form> --}}
    @endif
    <h1 class="primary-blue-color">Mensajes</h1>
</div>
<div class="message-container shadow-container message-pinned">
    <div class="message-heading">
        <div class="message-details">
            <img src="/uploads/avatars/{{Auth::user()->user_image}}" alt="user_img">
            <div class="message-details-autor">
                <p class="bold">Escrito por <span>Orlando Padrón</span></p>
                <p>Hace 2 horas</p>
            </div>
        </div>
        <div class="message-options">
            <a id="anchor_edit_button_" onclick="edit()"><i class="far fa-edit"></i></a>
            <a onclick="deleteTutorship()"><i class="fas fa-trash"></i></a>
            {{-- <a><i class="fas fa-edit"></i></a>
            <a><i class="far fa-bookmark"></i></a> --}}
            <a class="pinned"><i class="fas fa-thumbtack"></i></a>
        </div>
    </div>
    <div class="message-content">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla molestias repellat labore quidem corporis ut autem similique. Fugit, consectetur quidem, voluptatem aperiam impedit commodi a suscipit omnis animi ipsam obcaecati mollitia tempore adipisci est facere nostrum ullam nisi amet nihil. Dignissimos impedit, aut deleniti rerum, rem illum quibusdam consequatur ducimus dolores ab minus, accusantium aliquam fuga qui soluta numquam cupiditate obcaecati et ad voluptates iste laboriosam optio. Exercitationem dolorem rerum dignissimos dolorum eius, soluta, totam omnis ex iste ipsa suscipit porro excepturi laborum quibusdam. Harum aut sapiente ratione molestias aliquid, voluptas autem doloribus enim accusantium magnam ab cum nobis fuga numquam explicabo nostrum repudiandae asperiores soluta blanditiis recusandae sunt debitis voluptatum suscipit voluptate! Reiciendis mollitia tempore nesciunt, eligendi, porro perspiciatis, iusto atque laboriosam qui saepe vero cupiditate magnam placeat id natus quis labore voluptatibus! Nemo magni hic a sunt et, quae quibusdam eveniet est!</p>
    </div>
    <div class="message-reply">
        <input type="text" name="" id="">
    </div>
</div>