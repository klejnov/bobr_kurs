<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div class="jumbotron">
    <h3>Список банков</h3>
    <style>

        .btn {
            border: none; /* Remove borders */
            color: white; /* Add a text color */
            padding: 14px 28px; /* Add some padding */
            cursor: pointer; /* Add a pointer cursor on mouse-over */
        }

        .success {background-color: #4CAF50;} /* Green */
        .success:hover {background-color: #46a049;} .info {background-color: #2196F3;} /* Blue */
        .info:hover {background: #0b7dda;} .warning {background-color: #ff9800;} /* Orange */
        .warning:hover {background: #e68a00;} .danger {background-color: #f44336;} /* Red */
        .danger:hover {background: #da190b;} .default {background-color: #e7e7e7; color: black;} /* Gray */
        .default:hover

        {background: #ddd;}
    </style>
    <!--<button class="btn success">Success</button>
    <button class="btn info">Info</button>
    <button class="btn warning">Warning</button>
    <button class="btn danger">Danger</button>
    <button class="btn default">Default</button>
    <span class="label label-info">24 ч</span>
    <span class="label label-warning">3 сут</span>-->

    <div class="jumbotron divhome" style="max-width: 100%; margin: auto;">
        <table class="table table-home">
            <thead>
            <tr>
                <th>ID</th>
                <th>Назва&shy;ние банка</th>
                <th>USD, покупка</th>
                <th>USD, продажа</th>
                <th>EUR, покупка</th>
                <th>EUR, продажа</th>
                <th>RUB, покупка</th>
                <th>RUB, продажа</th>
                <th>UPD</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <?php $error_count = 0; ?>
            <?php $warning_count = 0; ?>
            <?php $info_count = 0; ?>
            <?php $height_top = 95; ?>

            <?php foreach($banks as $key => $bank) { ?>
            <?php if ($bank['auto'] == 1) { ?>
            <tr>
                <th scope="row"><a href="../admin/index.php?action=editbank&id=<?=$bank['id']?>"><?=$bank['id']?></a></th>
                <td><a href="<?=$bank['url_parser']?>" target="_blank" rel="nofollow" rel="noopener noreferrer"><img src="files/img/ico/<?=$bank['ico']?>" data-toggle="tooltip" data-placement="auto" style="vertical-align: -3px;" title="<?=$bank['note']?>"></a> <?=htmlspecialchars($bank['name'])?></td>
                <td><?=htmlspecialchars($bank['usd_buy'])?></td>
                <td><?=htmlspecialchars($bank['usd_sell'])?></td>
                <td><?=htmlspecialchars($bank['eur_buy'])?></td>
                <td><?=htmlspecialchars($bank['eur_sell'])?></td>
                <td><?=htmlspecialchars($bank['rub_buy'])?></td>
                <td><?=htmlspecialchars($bank['rub_sell'])?></td>
                <td><?=$bank['time']?>
                    <br>
                    <?php if ($bank['alarm_time'] >= 3) {
                    $warning_count += 1;
                    echo "<span class=\"label label-warning\">{$bank['alarm_time']} сут.</span>";
                    } else if ($bank['alarm_time'] >= 1){
                    $info_count += 1;
                    echo "<span class=\"label label-info\">{$bank['alarm_time']} сут.</span>";
                    }?>
                    <?php if ($bank['status'] == 1) {
                    echo "<span data-toggle=\"tooltip\" data-placement=\"auto\" title=\"Нет проблем при последнем обновлении\" class=\"label label-success\">OK</span>";
                    } else if ($bank['status'] == 0){
                    $error_count += 1;
                    echo "<span data-toggle=\"tooltip\" data-placement=\"auto\" title=\"Проблема при последнем обновлении. Сообщите администратору!\" class=\"label label-danger\">ERROR</span>";
                    }?>
                </td>
                <td></td>
            </tr>
            <?php } else { ?>
            <tr>
                <th scope="row"><a href="../admin/index.php?action=editbank&id=<?=$bank['id']?>"><?=$bank['id']?></a></th>
                <td><a href="<?=$bank['url_parser']?>" target="_blank" rel="nofollow" rel="noopener noreferrer"><img src="files/img/ico/<?=$bank['ico']?>" data-toggle="tooltip" data-placement="auto" style="vertical-align: -3px;" title="<?=$bank['note']?>"></a> <?=htmlspecialchars($bank['name'])?></td>
                <td><input type="text" class="usd_buy kursinput" value="<?=htmlspecialchars($bank['usd_buy'])?>"></td>
                <td><input type="text" class="usd_sell kursinput" value="<?=htmlspecialchars($bank['usd_sell'])?>"></td>
                <td><input type="text" class="eur_buy kursinput" value="<?=htmlspecialchars($bank['eur_buy'])?>"></td>
                <td><input type="text" class="eur_sell kursinput" value="<?=htmlspecialchars($bank['eur_sell'])?>"></td>
                <td><input type="text" class="rub_buy kursinput" value="<?=htmlspecialchars($bank['rub_buy'])?>"></td>
                <td><input type="text" class="rub_sell kursinput" value="<?=htmlspecialchars($bank['rub_sell'])?>"></td>
                <td><?=$bank['time']?>
                    <br>
                    <?php if ($bank['alarm_time'] >= 3) {
                    $warning_count += 1;
                    echo "<span class=\"label label-warning\">{$bank['alarm_time']} сут.</span>";
                    } else if ($bank['alarm_time'] >= 1){
                    $info_count += 1;
                    echo "<span class=\"label label-info\">{$bank['alarm_time']} сут.</span>";
                    }?>
                </td>
                <td><i onclick="editkurs(<?=$bank['id']?>, this)" class="fa fa-floppy-o fa-2x savebutton"
                       aria-hidden="true"></i></td>
            </tr>
            <?php }?>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="mySidenav sidenav-changes">
        <a href="#" id="count-changes" style="top:<?= $height_top ?>px;">Количество изменений: <?=$stats_count['COUNT(*)']?></a>
    </div>
    <?php if ($error_count) { ?>
        <div class="mySidenav sidenav-error">
            <a href="#" id="count-error" style="top:<?= $height_top += 75 ?>px;">Количество ошибок: <?= $error_count ?></a>
        </div>
    <?php } ?>
    <?php if ($warning_count) { ?>
        <div class="mySidenav sidenav-warning">
            <a href="#" id="count-warning" style="top:<?= $height_top += 75 ?>px;">Устаревшие курсы: <?= $warning_count ?></a>
        </div>
    <?php } ?>
    <?php if ($info_count) { ?>
    <div class="mySidenav sidenav-info">
        <a href="#" id="count-info" style="top:<?= $height_top += 75 ?>px;">Устаревшие курсы: <?= $info_count ?></a>
    </div>
    <?php } ?>

</div>