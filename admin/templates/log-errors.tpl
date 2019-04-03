<div class="jumbotron">
    <h3>Логирование ошибок</h3>
    <h5>(курсов, выходящих за пределы среднего курса)</h5>
    <div class="jumbotron" style="max-width: 100%; margin: auto;">
        <?php if ($log_errors) { ?>
            <table class="table table-bordered table-home">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название банка</th>
                    <th>Текст ошибки</th>
                    <th style="width: 90px;">Время</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($log_errors as $log_error) { ?>
                <tr>
                    <td scope="row"><a href="../admin/index.php?action=editbank&id=<?=$log_error['id_bank']?>" role="button"><?=$log_error['id_bank']?></a></td>
                    <td class="bank-title" style="text-align:left;"><img src="files/img/ico/<?=$log_error['ico']?>"> <?=htmlspecialchars($log_error['name'])?></td>
                    <td style="text-align:left;"><?=htmlspecialchars($log_error['html'])?></td>
                    <td><?=$log_error['time']?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
        <div style="text-align: center;">Пусто</div>
        <?php } ?>

    </div>
</div>
