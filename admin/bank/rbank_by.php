<?php

function rbank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');


    $html0 = file_get_contents("https://rbank.by/currency/?dept=0");
    preg_match("/<option  value=\"([0-9]+)\">ЦБУ 08\/02 г.Бобруйск, ЗАО «Банк «Решение»<\/option>/ms", $html0, $matches0);
    //print_r($matches0);

    $id_pages = $matches0[1];
    //echo $id_pages;

    $html = file_get_contents("https://rbank.by/currency/?dept=$id_pages");

    //preg_match("/.*(<div class=\"title\">на [^<]+<\/div>.*?<td>1 Доллар США<\/td>.*?)<div id=\"tab-2\" role=\"tabpanel\"/ms", $html, $matches);
    preg_match("/.*(<div class=\"title\">на ([^<]+)<\/div>.*?)<div id=\"tab-2\" role=\"tabpanel\"/ms", $html, $matches);
    //print_r($matches);
    //exit;
    $usd_logic = preg_match("/<td><span class=\"summ\">([^<]*)<\/span><\/td>\n                                    <td><span class=\"summ\">([^<]*)<\/span><\/td>\n                                    <td>USD<\/td>/", $matches[1], $usd);
    $eur_logic = preg_match("/<td><span class=\"summ\">([^<]*)<\/span><\/td>\n                                    <td><span class=\"summ\">([^<]*)<\/span><\/td>\n                                    <td>EUR<\/td>/", $matches[1], $eur);
    $rub_logic = preg_match("/<td><span class=\"summ\">([^<]*)<\/span><\/td>\n                                    <td><span class=\"summ\">([^<]*)<\/span><\/td>\n                                    <td>RUB<\/td>/", $matches[1], $rub);

    if ($usd_logic == true && $eur_logic == true && $rub_logic == true) {
    $status = 1;
    } else {
    $status = 0;
    }
    //global $banks_id;

    $data = array(array(
        'usd_buy' => $usd[1],
        'usd_sell' => $usd[2],
        'eur_buy' => $eur[1],
        'eur_sell' => $eur[2],
        'rub_buy' => $rub[1],
        'rub_sell' => $rub[2],
        'banks_id' => $banks_id,
        'status' => $status,
    ));
    //print_r($data);
    return $data;

}
//rbank_by()
?>
