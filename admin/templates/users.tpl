<script src="../../libs/timeago/jquery.timeago.js"></script>
<script src="../../libs/timeago/jquery.timeago.ru.js"></script>
<script>

    $(function() {
        $("time.timeago").timeago();
    });

</script>

<div class="jumbotron">
    <h3>Модераторы</h3>
    <div class="jumbotron" style="max-width: 100%; margin: auto;">
        <table class="table table-home">
            <thead>
            <tr>
                <th></th>
                <th>Логин</th>
                <th>Имя</th>
                <th>Роль</th>
                <th>Последний вход</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($user_list as $user) { ?>
            <tr>
                <td><img id="avatar" src="files/img/avatars/<?=$user['avatar']?>"></td>
                <td><?=htmlspecialchars($user['login'])?></td>
                <td><?=htmlspecialchars($user['name'])?></td>
                <td><?=$user['role'] == 1 ? "Администратор" : "Модератор"?></td>
                <td><?php if($user['logined_at']) { ?>
                    <time class="news-date timeago" datetime="<?=$user['logined_at_timeago'] ?>" title="<?=$user['logined_at'] ?>"></time>
                    <?php } else { ?>
                    Очень давно
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>
</div>
