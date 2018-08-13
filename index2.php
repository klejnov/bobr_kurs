<?php

define('DS', DIRECTORY_SEPARATOR);

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

        $start_time = new DateTime();
        $end_time = new DateTime();

        $start_time->modify('-14 day');
        $end_time->modify('+1 day');

        $db = new DataBase();

        $stats_period = $db->getCurrencyRatesWidget(
            $start_time->format('Y-m-d'),
            $end_time->format('Y-m-d'));

        $time_arr = [];

        foreach($stats_period as $stat){
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

            'graph_usd_buy' => $usd_buy_arr,
            'graph_usd_sell' => $usd_sell_arr,
            'graph_eur_buy' => $eur_buy_arr,
            'graph_eur_sell' => $eur_sell_arr,
            'graph_rub_buy' => $rub_buy_arr,
            'graph_rub_sell' => $rub_sell_arr,

            'current_rate_usd_buy' => round((float)$stat['usd_buy'], 3),
            'current_rate_usd_sell' => round((float)$stat['usd_sell'], 3),
            'current_rate_eur_buy' => round((float)$stat['eur_buy'], 3),
            'current_rate_eur_sell' => round((float)$stat['eur_sell'], 3),
            'current_rate_rub_buy' => round((float)$stat['rub_buy'], 3),
            'current_rate_rub_sell' => round((float)$stat['rub_sell'], 3),

        ];

        $dataTotalArr = json_encode($dataTotalArr);
        print_r($dataTotalArr);

        exit();
    }


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

require "templates/home2.tpl";