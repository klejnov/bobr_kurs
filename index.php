<?php

define('DS', DIRECTORY_SEPARATOR);

function sendSMS($banks_id, $text, $db)
{

    $sms_arr = require "admin/config_sms.php";

    $sql = "SELECT name from banks WHERE id=$banks_id;";

    $name_bank = $db->query($sql);

    $name_bank_telegram = $name_bank[0]["name"];

    $name_bank = urlencode($name_bank[0]["name"]);

    file_get_contents($sms_arr['site'] . "?r=api%2Fmsg_send&user=" . $sms_arr['user'] .
                      "&apikey=" . $sms_arr['apikey'] . "&recipients=" . $sms_arr['recipients'] .
                      "&message=Неверный%20курс%20в%20" . $name_bank . ".&sender=" . $sms_arr['sender'] . "&urgent=1&test=0");

    $telegram_msg = new TelegramBot();
    $telegram_msg->sendMessageTelegramBot("Пользователь сообщает о неверном курсе в <b>$name_bank_telegram</b>.\n<code>$text</code>\n<a href='https://kurs.bobr.by/admin/'>Посмотреть</a>");
}

/**
 * Автоматическая загрузка классов
 */

spl_autoload_register(function ($class_name) {

    $patchFile = 'classes' . DS . $class_name . '.php';

    if (!file_exists($patchFile)) {
        echo "Файла с классом $class_name нет";
        die();
    }
    include $patchFile;
});

try {

    if (isset($_POST["AjaxAction"]) && $_POST['AjaxAction'] == 'WidgetGet') {

        if ($_POST['AjaxPeriod'] == 'WidgetWeek') {

            print_r(file_get_contents("js/widget.json"));

            exit();
        }

        $start_time = new DateTime();
        $end_time = new DateTime();

        if ($_POST['AjaxPeriod'] == 'WidgetMonth') {

            $start_time->modify('-30 day');
            $end_time->modify('+1 day');
        }
        if ($_POST['AjaxPeriod'] == 'WidgetYear') {

            $start_time->modify('-365 day');
            $end_time->modify('+1 day');
        }

        $db = new DataBase();

        $stats_period = $db->getCurrencyRatesWidget(
            $start_time->format('Y-m-d'),
            $end_time->format('Y-m-d'));

        $time_arr = [];

        foreach ($stats_period as $stat) {
            $time_arr[] = $stat['time'];
            $usd_buy_arr[] = round((float)$stat['usd_buy'], 3);
            $usd_sell_arr[] = round((float)$stat['usd_sell'], 3);
            $eur_buy_arr[] = round((float)$stat['eur_buy'], 3);
            $eur_sell_arr[] = round((float)$stat['eur_sell'], 3);
            $rub_buy_arr[] = round((float)$stat['rub_buy'], 3);
            $rub_sell_arr[] = round((float)$stat['rub_sell'], 3);
        };

        $dataTotalArr = [
            'graph_time' => $time_arr,

            'graph_usd_buy'  => $usd_buy_arr,
            'graph_usd_sell' => $usd_sell_arr,
            'graph_eur_buy'  => $eur_buy_arr,
            'graph_eur_sell' => $eur_sell_arr,
            'graph_rub_buy'  => $rub_buy_arr,
            'graph_rub_sell' => $rub_sell_arr,

            'current_rate_usd_buy'  => round((float)$stat['usd_buy'], 3),
            'current_rate_usd_sell' => round((float)$stat['usd_sell'], 3),
            'current_rate_eur_buy'  => round((float)$stat['eur_buy'], 3),
            'current_rate_eur_sell' => round((float)$stat['eur_sell'], 3),
            'current_rate_rub_buy'  => round((float)$stat['rub_buy'], 3),
            'current_rate_rub_sell' => round((float)$stat['rub_sell'], 3),

        ];

        $dataTotalArr = json_encode($dataTotalArr);

        print_r($dataTotalArr);

        exit();
    }

    if (isset($_POST["AjaxAction"]) && $_POST['AjaxAction'] == 'TableInfoGet') {

        print_r(file_get_contents("js/table.json"));

        exit();
    }

    if (isset($_GET['mobile']) && $_GET['mobile'] == 'getInfoBanks') {

        $arr_banks = file_get_contents("js/table.json");

        $arr_banks = json_decode($arr_banks, true);

        $i = 0;

        $url_utm = "?utm_source=kursbobrby&utm_medium=mobile&utm_campaign=table_and_maps_balloon";

        if (!empty($arr_banks)) {

            foreach ($arr_banks as $arr_bank_item) {
                $arr_banks[$i++]['url'] = $arr_bank_item['url'] . $url_utm;
            }
        }

        $arr_banks = json_encode($arr_banks, true);

        echo $arr_banks;

        exit();
    }

    if (isset($_POST["AjaxAction"]) && $_POST['AjaxAction'] == 'ChartInfoGet') {


        $currency = $_POST["AjaxCurrency"];
        $id_bank_select = $_POST["AjaxIdBank"];
        $period_bank_select = $_POST["AjaxPeriod"];

        $start_time = new DateTime();
        $end_time = new DateTime();
        if ($period_bank_select == 'day') {
            $start_time->modify('-1 day');
        } else if ($period_bank_select == 'week') {
            $start_time->modify('-7 day');
        } else if ($period_bank_select == 'month') {
            $start_time->modify('-30 day');
        }
        //print_r($id_bank_select . $period_bank_select . $start_time->format('Y-m-d H:i:s') . $end_time->format('Y-m-d H:i:s'));

        $db = new DataBase();

        $stats_period = $db->getCurrencyRatesChart(
            $id_bank_select,
            $currency,
            $start_time->format('Y-m-d H:i:s'),
            $end_time->format('Y-m-d H:i:s')
        );

        $index_buy = $currency . "_buy";
        $index_sell = $currency . "_sell";

        foreach ($stats_period as $stat) {
            $time_arr[] = $stat['time'];
            $buy_arr[] = round((float)$stat["$index_buy"], 3);
            $sell_arr[] = round((float)$stat["$index_sell"], 3);
        };

        //print_r($stats_period);

        $dataTotalArr = [
            'graph_time' => $time_arr,
            'graph_buy'  => $buy_arr,
            'graph_sell' => $sell_arr,

        ];
        //print_r($dataTotalArr);
        $dataTotalArr = json_encode($dataTotalArr);
        print_r($dataTotalArr);

        exit();
    }

    if (isset($_GET['banksKursLog']) && $_GET['banksKursLog'] == 'clear') {

        $db = new DataBase();

        $sql = "DELETE FROM banks_kurs_log WHERE time < DATE_SUB(NOW(), INTERVAL 5 DAY) AND type_log <> 1;";

        $db->execute($sql);

        echo "Лог очищен";

        exit();
    }

    if (isset($_GET['widget']) && $_GET['widget'] == 'show') {

        require "templates/widget.tpl";

        exit();
    }

    if (isset($_GET['classic']) && $_GET['classic'] == 'show') {

        $year = date("Y");

        require "templates/old_table.tpl";

        exit();
    }
    if (isset($_GET['action']) && $_GET['action'] == '404') {

        header("HTTP/1.0 404 Not Found");

        $year = date("Y");

        require "templates/404.tpl";

        exit();
    }

    if (isset($_POST["AjaxAction"]) && $_POST['AjaxAction'] == 'Message') {

        $text = $_POST["AjaxText"];
        $banks_id = $_POST["AjaxBanksId"];
        $ip = $_SERVER['REMOTE_ADDR'];

        try {
            $db = new DataBase();
            $db->saveMessage($banks_id, $text, $ip);

            $result = [
                'send' => true
            ];
            $result = json_encode($result);
            echo $result;

            sendSMS($banks_id, $text, $db);
        } catch (Throwable $e) {
            $result = [
                'send'      => false,
                'error-msg' => $e->getMessage()
            ];
            $result = json_encode($result);
            echo $result;
        }

        exit();
    }

    if (isset($_GET['mobile']) && $_GET['mobile'] == 'getNews') {

        $arr_news = file_get_contents("js/arr_news.json");

        $arr_news = json_decode($arr_news, true);

        $i = 0;

        if (!empty($arr_news)) {

            foreach ($arr_news as $arr_news_item) {

                $arr_news[$i++] = str_replace("page", "mobile", $arr_news_item);
            }
        }

        $arr_news = json_encode($arr_news, true);

        echo $arr_news;

        exit();
    }

    if (isset($_POST['AjaxAction']) && $_POST['AjaxAction'] == 'lastIdCurrency') {

        print_r(file_get_contents("js/lastID.json"));

        exit();
    }

    if ($_REQUEST) {

        header("HTTP/1.0 404 Not Found");

        $year = date("Y");

        require "templates/404.tpl";

        exit();
    }

    function extractExchangeRates()
    {
        $i = 0;
        $arr_news = file_get_contents("js/arr_news.json");

        $arr_news = json_decode($arr_news, true);

        if (!empty($arr_news)) {

            $arr_news = array_values($arr_news);

            foreach ($arr_news as $arr_news_item) {

                $arr_news[$i++] = array_values($arr_news_item);
            }
        }

        return $arr_news;
    }

    $arr_news = extractExchangeRates();
    //var_dump($arr_news);

} catch (Throwable $e) {

    print <<<HTML_BLOCK
Выброшено исключение:   <b>{$e->getMessage()}</b><br>
Строка:                 <b>{$e->getLine()}</b><br>
В файле:                <b>{$e->getFile()}</b><br>
HTML_BLOCK;
}

/**
 * Вызов метода резервного копирования текущей базы данных
 */

//DataBase::backup();

$year = date("Y");

require "templates/home.tpl";
