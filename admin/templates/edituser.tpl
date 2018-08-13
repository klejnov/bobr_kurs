    <div class="jumbotron">
    <h4>Редактирование пользователя</h4>
    <div class="jumbotron" style="max-width: 500px; margin: auto;">
        <div class="card">
            <img src="files/img/avatars/<?=$user_data2['avatar']?>" alt="Avatar" style="width:100%">
            <div class="container">
                <h4><b><?=$user_data2['login']?></b></h4>
                <p><?=$user_data2['name']?></p>
            </div>
        </div>
        <br>
        <div class="form-group">
            <form>
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input value="<?=$user_data2['login']?>" type="text" class="form-control" id="login_user" placeholder="Введите новый логин">
                </div>
                <div class="form-group">
                    <label for="">Ваше имя</label>
                    <input value="<?=$user_data2['name']?>" type="text" class="form-control" id="name_user" placeholder="Введите ваше имя">
                </div>
                <div class="form-group">
                    <label for="">Аватарка</label>
                    <button type="button" data-id="input_file" class="bfs btn btn-success" data-placeholder="Загрузить файл" data-style="fileStyle-l">
                        <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>  Выбрать фото
                    </button>
                    <input type="file" id="input_file" style="display: none">
                </div>
            <script>
                var filestyler = new buttontoinputFile();
            </script>
            </form>
        </div>
        <p>
            <button class="btn btn-lg btn-primary" onclick="edituser()" role="button">Сохранить &raquo;</button>
        </p>
    </div>
</div>