<?php

function belapb_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("https://banki24.by/bobrujsk/banks/belagroprombank/otdeleniya/1082/kurs");

    if (preg_match("/<td class=\"active\"><strong>USD<\/strong>, Доллар<\/td>.*?<td align=\"center\">([^<]+)<\/td>.*?<td align=\"center\">([^<]+)<\/td>.*?<td class=\"active\"><strong>EUR<\/strong>, Евро<\/td>.*?<td align=\"center\">([^<]+)<\/td>.*?<td align=\"center\">([^<]+)<\/td>.*?<td class=\"active\"><strong>RUB<\/strong>, Российский рубль<\/td>.*?<td align=\"center\">([^<]+)<\/td>.*?<td align=\"center\">([^<]+)<\/td>/ms", $html, $valuta)) {
        $status = 1;
        $data = array(array(
            'usd_buy' => str_replace(",",".",trim($valuta[1])),
            'usd_sell' => str_replace(",",".",trim($valuta[2])),
            'eur_buy' => str_replace(",",".",trim($valuta[3])),
            'eur_sell' => str_replace(",",".",trim($valuta[4])),
            'rub_buy' => str_replace(",",".",trim($valuta[5])),
            'rub_sell' => str_replace(",",".",trim($valuta[6])),
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

    //echo $id_pages;
    //print_r($valuta);
    //print_r($eur);


    //print_r($data);
    return $data;

}
//belapb_by()
?>
