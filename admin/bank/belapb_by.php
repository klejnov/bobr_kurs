<?php

function belapb_by()
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    //$html = file_get_contents("https://banki24.by/bobrujsk/banks/belagroprombank/otdeleniya/1082/kurs");

//    $day = date('d');
//    $month = date('m');
//    $year = date('Y');
//
//    $html = file_get_contents("http://www.belapb.by/rus/nalichnye-kursy-valut/vse-kursy-po-gorodu/?bank=2&ratesBlock=1&more=3&CITY_ID=96436&DATE_RATE_DAY=" . $day . "&DATE_RATE_MONTH=" . $month . "&DATE_RATE_YEAR=" . $year . "&VAL1=USD&VAL2=EUR&VAL3=RUB");
//    if (preg_match("/<table class=\"table3cols\">.*(Могилевской области<\/th>.*?<td style=\"width: 5%;\">([^<]+)<\/td>.*?<td style=\"width: 5%;\">([^<]+)<\/td>.*?<td style=\"width: 5%;\">([^<]+)<\/td>.*?<td style=\"width: 5%;\">([^<]+)<\/td>.*?<td style=\"width: 5%;\">([^<]+)<\/td>.*?<td style=\"width: 5%;\">([^<]+)<\/td>.*?<td style=\"width: 20%;\">г\.Бобруйск)/ms",

        $html = file_get_contents("http://www.belapb.by/?blockAjax=1&cityID=96436&REGION_ID=6");

    $data = [];
    $array_banks_id = [34, 49, 50, 51, 52, 53];

    if (preg_match("/USD&SORT=FROM\">([^<]+)<.*?USD&SORT=TO\">([^<]+)<.*?EUR&SORT=FROM\">([^<]+)<.*?EUR&SORT=TO\">([^<]+)<.*?RUB&SORT=FROM\">([^<]+)<.*?RUB&SORT=TO\">([^<]+)<.*?/ms",
        $html, $valuta)) {
        $status = 1;
        foreach ($array_banks_id as $banks_id) {
            $data[] = array(
                'usd_buy'  => str_replace(",", ".", trim($valuta[1])),
                'usd_sell' => str_replace(",", ".", trim($valuta[2])),
                'eur_buy'  => str_replace(",", ".", trim($valuta[3])),
                'eur_sell' => str_replace(",", ".", trim($valuta[4])),
                'rub_buy'  => str_replace(",", ".", trim($valuta[5])),
                'rub_sell' => str_replace(",", ".", trim($valuta[6])),
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => $html,
            );
        };
    } else {
        $status = 0;
        foreach ($array_banks_id as $banks_id) {
            $data[] = array(
                'usd_buy'  => 0,
                'usd_sell' => 0,
                'eur_buy'  => 0,
                'eur_sell' => 0,
                'rub_buy'  => 0,
                'rub_sell' => 0,
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => $html,
            );
        };
    }

    //echo $id_pages;
    //print_r($valuta);
    //print_r($eur);

    //print_r($data);
    return $data;
}

//belapb_by();
?>
