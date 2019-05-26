<?php
# Отсылаем заголовок который "обьясняет" клиенту ,что это wml документ 
header("Content-type: text/vnd.wap.wml");
#Выводим саму страницу
print  '<?xml version="1.0" encoding="UTF-8"?> 
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">';
?>
<?php

$arr_avg = file_get_contents("../js/widget.json");
$arr_avg = json_decode($arr_avg, true);

$arr_news = file_get_contents("../js/arr_news.json");
$arr_news = json_decode($arr_news, true);

$filename = "../js/widget.json";
$update_time = date("d.m.Y в H:i", filectime($filename));
?>
<wml>
    <template>
        <do type="prev" label="Назад">
            <prev/>
        </do>
    </template>
    <card id="main" title="Главная:: BOBR.by">
        <p align="center"><img src="logo.wbmp" alt="LOGO"/></p>
        <p align="center">
            <small>Курсы валют в Бобруйске</small>
        </p>
        <p align="center">
            <a href="#avg" accesskey="1">Средний курс</a><br/>
            <a href="banks.wml" accesskey="2">Курсы в банках</a><br/>
            <a href="#news" accesskey="3">Новости валют</a><br/>
        </p>

        <p align="center" mode="wrap">
            <img src="http://wap.kurs.bobr.by/counter/see_count.php" alt="counter"/>
        </p>
        <p align="center" mode="wrap">
            <small>
                <small>
                    <small>2006 - <?= date('Y') ?></small>
                </small>
            </small>
        </p>
    </card>
    <card id="avg" title="Средний курс">
        <p>
        <table columns="3" align="LCC">
            <tr>
                <td></td>
                <td>
                    <small>
                        <small><u>Покупка</u></small>
                    </small>
                </td>
                <td>
                    <small>
                        <small><u>Продажа</u></small>
                    </small>
                </td>
            </tr>
            <tr>
                <td><b>USD</b></td>
                <td><?= $arr_avg['current_rate_usd_buy'] ?></td>
                <td><?= $arr_avg['current_rate_usd_sell'] ?></td>
            </tr>
            <tr>
                <td><b>EUR</b></td>
                <td><?= $arr_avg['current_rate_eur_buy'] ?></td>
                <td><?= $arr_avg['current_rate_eur_sell'] ?></td>
            </tr>
            <tr>
                <td><b>RUB</b></td>
                <td><?= $arr_avg['current_rate_rub_buy'] ?></td>
                <td><?= $arr_avg['current_rate_rub_sell'] ?></td>
            </tr>
        </table>
        </p>
        <p align="center" mode="wrap">
            <small>
                <small>Обновлено: <?= $update_time ?></small>
            </small>
        </p>
    </card>
    <card id="news" title="Новости валют">
        <?php foreach($arr_news as $news) { ?>
            <small>
                <small><?= date("d.m.Y в H:i", strtotime($news[4]))?></small>
            </small>
            <p align="center" mode="wrap"><?= $news[1] ?></p>
            <p align="center" mode="wrap"><a href="<?= str_replace("page", "wap", $news[2]); ?>">Читать на сайте</a><br/></p>
        <?php } ?>
    </card>
</wml>

