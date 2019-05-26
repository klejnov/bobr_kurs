<?php
# Отсылаем заголовок который "обьясняет" клиенту ,что это wml документ 
header("Content-type: text/vnd.wap.wml");
#Выводим саму страницу
print  '<?xml version="1.0" encoding="UTF-8"?> 
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">';
?>
<?php
$arr_banks = file_get_contents("../js/table.json");
$arr_banks = json_decode($arr_banks, true);
//var_dump($arr_banks);
if (isset($_GET['bank'])) {

    $bank_id = $_GET['bank'];

    function search($array, $key, $value)
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, search($subarray, $key, $value));
            }
        }

        return $results;
    }

    $arr_bank = search($arr_banks, 'id', $bank_id);

    $address = explode("Тел.:", htmlspecialchars($arr_bank[0]['address']));
}
?>
<wml>
    <template>
        <do type="prev" label="Назад">
            <prev/>
        </do>
    </template>
        <card id="bank-<?= $arr_bank[0]['id'] ?>" title="<?= htmlspecialchars(str_replace('№', '#', $arr_bank[0]['name'])) ?>">
            <do type="options" name="refresh">
                <noop/>
            </do>
            <p><?= htmlspecialchars(str_replace('№', '#', $arr_bank[0]['name'])) ?></p>

            <p align="center"><small>ПОКУПКА|ПРОДАЖА</small></p>
            <p align="center">USD</p>
            <p align="center"><?= $arr_bank[0]['usd_buy'] ?> | <?= $arr_bank[0]['usd_sell'] ?></p>
            <p align="center">EUR</p>
            <p align="center"><?= $arr_bank[0]['eur_buy'] ?> | <?= $arr_bank[0]['eur_sell'] ?></p>
            <p align="center">RUB</p>
            <p align="center"><?= $arr_bank[0]['rub_buy'] ?> | <?= $arr_bank[0]['rub_sell'] ?></p>

            <p><small><?= $address[0] ?></small></p>
            <p><small><?= "Тел.:" . $address[1] ?></small></p>
            <p><small>Банк обновлял курсы:</small></p>
            <p><small><?= date("d.m.Y в H:i", strtotime($arr_bank[0]['time'])) ?></small></p>
            <p align="center">
                Ошибочный курс?<br/>
                <a href="#error" accesskey="1">Сообщить</a>
            </p>
        </card>
        <card id="error" title="Сообщить об ошибке">
            <p>Пожалуйста, выберите ошибочные курсы:</p>
            <br/>
            USD: <select name="USD">
                <option value="ok"> Верный курс </option>
                <option value="error">Ошибочный курс</option>
            </select>
            <br/>
            EUR: <select name="EUR">
                <option value="ok"> Верный курс </option>
                <option value="error">Ошибочный курс</option>
            </select>
            <br/>
            RUB: <select name="RUB">
                <option value="ok"> Верный курс </option>
                <option value="error">Ошибочный курс</option>
            </select>
            <br/>
            Ваше сообщение: <input name="WapText" />
            <br/>
            <anchor>Сообщить
                <go href="send.php" method="post">
                    <postfield name="bankID" value="<?= $arr_bank[0]['id'] ?>"/>
                    <postfield name="WapText" value="$(WapText)"/>
                    <postfield name="USD" value="$(USD)"/>
                    <postfield name="EUR" value="$(EUR)"/>
                    <postfield name="RUB" value="$(RUB)"/>
                    <postfield name="usdBank" value="<?= $arr_bank[0]['usd_buy'] . " / " . $arr_bank[0]['usd_sell'] ?>"/>
                    <postfield name="eurBank" value="<?= $arr_bank[0]['eur_buy'] . " / " . $arr_bank[0]['eur_sell'] ?>"/>
                    <postfield name="rubBank" value="<?= $arr_bank[0]['rub_buy'] . " / " . $arr_bank[0]['rub_sell'] ?>"/>
                    <postfield name="wap" value="true"/>
                </go>
            </anchor>
            <br/>
            <do label="Сообщить" type="accept">
                <go href="send.php" method="post">
                    <postfield name="bankID" value="<?= $arr_bank[0]['id'] ?>"/>
                    <postfield name="WapText" value="$(WapText)"/>
                    <postfield name="USD" value="$(USD)"/>
                    <postfield name="EUR" value="$(EUR)"/>
                    <postfield name="RUB" value="$(RUB)"/>
                    <postfield name="usdBank" value="<?= $arr_bank[0]['usd_buy'] . " / " . $arr_bank[0]['usd_sell'] ?>"/>
                    <postfield name="eurBank" value="<?= $arr_bank[0]['eur_buy'] . " / " . $arr_bank[0]['eur_sell'] ?>"/>
                    <postfield name="rubBank" value="<?= $arr_bank[0]['rub_buy'] . " / " . $arr_bank[0]['rub_sell'] ?>"/>
                    <postfield name="wap" value="true"/>
                </go>
            </do>
        </card>
</wml>
