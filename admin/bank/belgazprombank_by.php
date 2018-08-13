<?php

function belgazprombank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("http://i.belgazprombank.by/index_mobile.php");
    if (preg_match("/<div class=\"box-t-in\">Курсы валют.*?<th>USD<\/th>.*?<td>1<\/td>\n.*?<td>([^<]*)<.*?<td>([^<]*)<.*?<th>EUR<\/th>.*?<td>1<\/td>\n.*?<td>([^<]*)<.*?<td>([^<]*)<.*?<th>RUR<\/th>.*?<td>100<\/td>\n.*?<td>([^<]*)<.*?<td>([^<]*)<.*?Держателям карточек/ms", $html, $valuta)) {
        $status = 1;
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
//belgazprombank_by()
?>