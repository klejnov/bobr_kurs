<?php

function bps_sberbank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("http://www.bps-sberbank.by/43257F17004E948D/currency_rates?OpenForm&tabnum=1&city=%D0%9C%D0%BE%D0%B3%D0%B8%D0%BB%D0%B5%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C&bankbranch=369-601");
    if (preg_match("/ДОЛЛАР США < 200.*?Покупка<\/div><\/div>([^<]*)<.*?Продажа<\/div><\/div>([^<]*)<.*?ЕВРО < 200.*?Покупка<\/div><\/div>([^<]*)<.*?Продажа<\/div><\/div>([^<]*)<.*?РОССИЙСКИЙ РУБЛЬ.*?Покупка<\/div><\/div>([^<]*)<.*?Продажа<\/div><\/div>([^<]*)</ms", $html, $valuta)) {
    $status = 1;

    //echo $id_pages;
    //print_r($valuta);
    //print_r($eur);
    //global $banks_id;

    $data = array(array(
        'usd_buy' => trim($valuta[1]),
        'usd_sell' => trim($valuta[2]),
        'eur_buy' => trim($valuta[3]),
        'eur_sell' => trim($valuta[4]),
        'rub_buy' => trim($valuta[5]),
        'rub_sell' => trim($valuta[6]),
        'banks_id' => $banks_id,
        'status' => $status,
    ));
} else {
    $status = 0;
    $data = array(array(
        'usd_buy' => 0,
        'usd_sell' => 0,
        'eur_buy' => 0,
        'eur_sell' => 0,
        'rub_buy' => 0,
        'rub_sell' => 0,
        'banks_id' => $banks_id,
        'status' => $status,
    ));
}
    //print_r($data);
    return $data;

}
//bps_sberbank_by()
?>
