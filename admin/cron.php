<?php
header('Content-Type: text/html; charset=utf-8');

require_once 'kurs.php';

$banks_id = 1;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/paritetbank_by_parser3.php';
    $paritetbank3 = paritetbank_by_parser3($banks_id);
    addkurs($paritetbank3);
}

$banks_id = 2;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/paritetbank_by_parser4.php';
    $paritetbank4 = paritetbank_by_parser4($banks_id);
    addkurs($paritetbank4);
}

$banks_id = 3;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/paritetbank_by_parser12.php';
    $paritetbank12 = paritetbank_by_parser12($banks_id);
    addkurs($paritetbank12);
}

//Удаляет из массива $priorbank_by банки для которых установлено ручное обновление
require 'bank/priorbank_by.php';
$priorbank_by = priorbank_by();
foreach ($priorbank_by as $key => $priorbank_by2) {
    $bank_data = getbanksinfo($priorbank_by2['banks_id']);
    if ($bank_data['auto'] == 0) {
        unset($priorbank_by[$key]);
    }
}
addkurs($priorbank_by);

/*
$banks_id = 5;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/rbank_by.php';
    $rbank_by = rbank_by($banks_id);
    addkurs($rbank_by);
}
*/

$banks_id = 6;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/mtbank_by.php';
    $mtbank_by = mtbank_by($banks_id);
    addkurs($mtbank_by);
}

$banks_id = 7;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belveb_by_s.php';
    $belveb_by_s = belveb_by_s($banks_id);
    addkurs($belveb_by_s);
}

$banks_id = 8;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belveb_by_m.php';
    $belveb_by_m = belveb_by_m($banks_id);
    addkurs($belveb_by_m);
}

$banks_id = 9;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_16_id56.php';
    $ideabank_by_16_id56 = ideabank_by_16_id56($banks_id);
    addkurs($ideabank_by_16_id56);
}

$banks_id = 10;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_27_id79.php';
    $ideabank_by_27_id79 = ideabank_by_27_id79($banks_id);
    addkurs($ideabank_by_27_id79);
}

$banks_id = 11;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_39_id40.php';
    $ideabank_by_39_id40 = ideabank_by_39_id40($banks_id);
    addkurs($ideabank_by_39_id40);
}

$banks_id = 12;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/ideabank_by_44_id113.php';
    $ideabank_by_44_id113 = ideabank_by_44_id113($banks_id);
    addkurs($ideabank_by_44_id113);
}

//Удаляет из массива $belarusbank_by банки для которых установлено ручное обновление
require 'bank/belarusbank_by.php';
$belarusbank_by = belarusbank_by();
foreach ($belarusbank_by as $key => $belarusbank_by2) {
    $bank_data = getbanksinfo($belarusbank_by2['banks_id']);
    if ($bank_data['auto'] == 0) {
        unset($belarusbank_by[$key]);
    }
}
//print_r($belarusbank_by);
addkurs($belarusbank_by);

$banks_id = 35;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/alfabank_by.php';
    $alfabank_by = alfabank_by($banks_id);
    addkurs($alfabank_by);
}

$banks_id = 36;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/mmbank_by.php';
    $mmbank_by = mmbank_by($banks_id);
    addkurs($mmbank_by);
}

$banks_id = 37;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/belgazprombank_by.php';
    $belgazprombank_by = belgazprombank_by($banks_id);
    addkurs($belgazprombank_by);
}

//Удаляет из массива $belinvestbank_by банки для которых установлено ручное обновление
require 'bank/belinvestbank_by.php';
$belinvestbank_by = belinvestbank_by();
foreach ($belinvestbank_by as $key => $belinvestbank_by2) {
    $bank_data = getbanksinfo($belinvestbank_by2['banks_id']);
    if ($bank_data['auto'] == 0) {
        unset($belinvestbank_by[$key]);
    }
}
addkurs($belinvestbank_by);

$banks_id = 39;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/bps_sberbank_by.php';
    $bps_sberbank_by = bps_sberbank_by($banks_id);
    addkurs($bps_sberbank_by);
}

$banks_id = 40;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/rrb_by.php';
    $rrb_by = rrb_by($banks_id);
    addkurs($rrb_by);
}

$banks_id = 41;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/stbank_by_1.php';
    $stbank_by_1 = stbank_by_1($banks_id);
    addkurs($stbank_by_1);
}

$banks_id = 43;
$bank_data = getbanksinfo($banks_id);
if ($bank_data['auto'] == 1) {
    require 'bank/vtb_bank_by.php';
    $vtb_bank_by = vtb_bank_by($banks_id);
    addkurs($vtb_bank_by);
}

//Удаляет из массива $belapb_by банки для которых установлено ручное обновление
require 'bank/belapb_by.php';
$belapb_by = belapb_by();
foreach ($belapb_by as $key => $belapb_by2) {
    $bank_data = getbanksinfo($belapb_by2['banks_id']);
    if ($bank_data['auto'] == 0) {
        unset($belapb_by[$key]);
    }
}
addkurs($belapb_by);

function widgetGet()
{

    $start_time = new DateTime();
    $end_time = new DateTime();

    $start_time->modify('-14 day');
    $end_time->modify('+1 day');

    $stats_period = getCurrencyRatesWidget(
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

    $fileName = __DIR__ . '/../js/widget.json';
    file_put_contents($fileName, $dataTotalArr);
}

function tableGet()
{

    $dataTotalArr = getBanksRatesTable();

    $dataTotalArr = json_encode($dataTotalArr);

    $fileName = __DIR__ . '/../js/table.json';
    file_put_contents($fileName, $dataTotalArr);
}

function lastIdCurrencyGet()
{

    $id = getLastIdCurrency();

    $id = json_encode($id);

    $fileName = __DIR__ . '/../js/lastID.json';
    file_put_contents($fileName, $id);
}

function saveExchangeRates($arr_news_new)
{

    $arr_news_new = json_encode($arr_news_new);

    $fileName = __DIR__ . '/../js/arr_news.json';
    file_put_contents($fileName, $arr_news_new);

}

widgetGet();
tableGet();
lastIdCurrencyGet();
parseExchangeRates();

