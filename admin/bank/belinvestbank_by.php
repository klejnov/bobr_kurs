<?php

function belinvestbank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("https://www.belinvestbank.by/bank-profile/courses.php?print=y");
    if (preg_match("/<td rowspan=\"4\">Доллар США \(за 1 USD\)<\/td>.*?<td>До 200<\/td>.*?<td align=\"center\"><b>([^ ]*) BYN<\/b>.*?<td align=\"center\"><b>([^ ]*) BYN<\/b>.*?<td rowspan=\"4\">ЕВРО \(за 1 EUR\)<\/td>.*?<td>До 200<\/td>.*?<td align=\"center\"><b>([^ ]*) BYN<\/b>.*?<td align=\"center\"><b>([^ ]*) BYN<\/b>.*?<td rowspan=\"4\">Российский рубль \(за 100 RUB\)<\/td>.*?<td>До 12000<\/td>.*?<td align=\"center\"><b>([^ ]*) BYN<\/b>.*?<td align=\"center\"><b>([^ ]*) BYN<\/b>/ms", iconv( "windows-1251", "UTF-8", $html ), $valuta)) {
        $status = 1;

    //echo iconv( "windows-1251", "UTF-8", $html );
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
//belinvestbank_by()
?>
