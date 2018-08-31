<div class="jumbotron">
    <h3>Список банков для редактирования</h3>
    <div class="jumbotron" style="max-width: 100%; margin: auto;">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название банка</th>
                <th>Редактирование</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($banks as $bank) { ?>
            <tr>
                <th scope="row"><?=$bank['id']?></th>
                <td><img src="files/img/ico/<?=$bank['ico']?>"> <?=htmlspecialchars($bank['name'])?></td>
                <td><a href="../admin/index.php?action=editbank&id=<?=$bank['id']?>" role="button"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a></td></tr>
            <?php } ?>
            </tbody>
        </table>
        <p>
            <a class="btn btn-lg btn-primary" href="../admin/index.php?action=editbank&id=0" role="button">Добавить банк &raquo;</a>
        </p>
    </div>
</div>
