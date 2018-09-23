<div class="jumbotron">
    <h3>Сообщения</h3>
    <div class="jumbotron" style="max-width: 100%; margin: auto;">
        <button class="bfs btn btn-success reload" style="display: none; margin: auto 46% 20px;" onclick="location.reload()" role="button">Обновить <i class="fa fa-refresh" aria-hidden="true"></i></button>
        <table class="table table-bordered table-home">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название банка</th>
                <th>Сообщение</th>
                <th>IP</th>
                <th style="width: 90px;">Время</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($messages as $message) { ?>
            <tr>
                <td scope="row"><a href="../admin/index.php?action=editbank&id=<?=$message['banks_id']?>" role="button"><?=$message['banks_id']?></a></td>
                <td class="bank-title" style="text-align:left;"><img src="files/img/ico/<?=$message['ico']?>"> <?=htmlspecialchars($message['name'])?></td>
                <td style="text-align:left;"><?=htmlspecialchars($message['text'])?></td>
                <td><?=$message['ip']?></td>
                <td><?=$message['time']?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
