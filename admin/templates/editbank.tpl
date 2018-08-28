<style>
    option.imagebacked {
        padding: 0px 0 0px 20px;
        background-repeat: no-repeat;
        background-position: 1px 2px;
        vertical-align: middle;
</style>
<div class="jumbotron">
    <h4><?php if ($bank_data['id'] > 0) { echo "Редактирование банка";} else { echo "Добавление банка";} ?>
</h4>
    <div class="jumbotron" style="max-width: 500px; margin: auto;">
        <div class="form-group">
            <form>
                <label for="exampleInputPassword1">Имя банка</label>
                <input value="<?=$bank_data['name']?>" type="text" class="form-control" id="name_bank" placeholder="Введите имя банка">
                <div class="checkbox">
                    <label><input id="auto" type="checkbox" <?php if ($bank_data['auto'] == 1) echo "checked"; ?> >Автоматическое обновление</label>
                </div>
                <div class="form-group">
                    <label for="comment">Адрес и телефон</label>
                    <textarea class="form-control" rows="3" id="address_bank"><?=$bank_data['address']?></textarea>
                </div>
                <div class="form-group">
                    <label for="">Ссылка на каталог</label>
                <input value="<?=$bank_data['url']?>" type="text" class="form-control" id="url_bank" placeholder="Введите ссылку страницу в каталоге BOBR.by">
                </div>
                <div class="form-group">
                    <label for="">Координаты</label>
                <input value="<?=$bank_data['latlng']?>" type="text" class="form-control" id="latlng_bank" placeholder="Введите координаты банка">
                </div>
            </div>
            <div class="form-group">
                <label for="">Ссылка для ручной проверки курсов</label>
                <input value="<?=$bank_data['url_parser']?>" type="text" class="form-control" id="url_parser_bank" placeholder="Введите ссылку на страницу банка">
            </div>
            <div class="form-group">
                <label for="comment">Заметки</label>
                <textarea class="form-control" rows="3" id="note_bank"><?=$bank_data['note']?></textarea>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="ico_select">Выбрать иконку:</label>
                    <select class="form-control" id="ico_select">
                        <option value="1">Загрузить новый файл</option>
                        <?=$select_ico?>
                    </select>
                </div>
                <?php if ($bank_data['id'] > 0) {
                    echo "<div class=\"form-group\">";
                    echo "<label for=\"\">Текущая иконка:</label>";
                    echo " <img src=\"files/img/ico/" . $bank_data['ico'] . "\"> (" . $bank_data['ico'] . ")";
                    echo "</div>";
                } ?>
                <div class="form-group" id="hide_file"<?=$display_none?>>
                <label for="">Загрузить новую:</label>
                <button type="button" data-id="input_file" class="bfs btn btn-success" data-placeholder="Загрузить иконку" data-style="fileStyle-l">
                    <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>  Выбрать иконку
                </button>
                    <input type="file" id="input_file" style="display: none">
                </div>
            </div>
                <script>
                  var filestyler = new buttontoinputFile();
                </script>
            </form>
        <p>
            <button class="btn btn-lg btn-primary" onclick="editbank()" role="button">Сохранить &raquo;</button>
            <?php if ($bank_data['id'] > 0) {
            echo "<button class=\"btn btn-lg btn-danger\" onclick=\"delbank(" . $bank_data['id'] . ")\" role=\"button\">Удалить &raquo;</button>";
            } ?>
        </p>


    </div>
</div>

<?php if ($bank_data['id'] > 0) {
echo "
<link rel=\"stylesheet\" href=\"libs/leaflet/leaflet.css\" />
<!--[if lte IE 8]>
<link rel=\"stylesheet\" href=\"libs/leaflet/leaflet.ie.css\" />
<![endif]-->
<div>
    <h4>Карта</h4>
    <div>
        <p>
            <script src=\"libs/leaflet/leaflet.js\"></script>

        <div id=\"map\" style=\"width: 100%; height: 500px;\"></div>

    <script type='text/javascript'>
        //Определяем карту, координаты центра и начальный масштаб
        var map = L.map('map').setView([" . $bank_data['latlng'] . "], 16);
        L.marker([" . $bank_data['latlng'] . "]).addTo(map)
            .bindPopup(\"<strong><img width='25px' src='files/img/ico/" . $bank_data['ico'] . "'> " . $bank_data['name'] . "</strong><br>" . $bank_data['address'] . "\").openPopup();
        //Добавляем на нашу карту слой OpenStreetMap
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a rel=\"nofollow\" href=\"http://osm.org/copyright\">OpenStreetMap</a> contributors'
        }).addTo(map);

    </script>
</div>
</div>
";
} ?>