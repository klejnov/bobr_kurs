<?php

function paritetbank_by_parser4($banks_id)
{

    $html = file_get_contents("http://www.paritetbank.by/services/private/valute/bobruisk-sovetskaya85/");
    //$html = file_get_contents("http://www.paritetbank.by/services/private/valute/gamarnika/");

    $html = iconv('cp1251', 'utf-8', $html);

    if (preg_match("/USD \(Доллар США\).*?<div  align=\"center\" >([^<]*)<.*?<div  align=\"center\" >([^<]*)<.*?EUR \(Евро\).*?<div  align=\"center\" >([^<]*)<.*?<div  align=\"center\" >([^<]*)<.*?100 RUB \(Российский рубль\).*?<div  align=\"center\" >([^<]*)<.*?<div  align=\"center\" >([^<]*)</ms",
        $html, $matches)) {
        $status = 1;
        $matches[1] = str_replace("&nbsp;", "", $matches[1]);
        $matches[2] = str_replace("&nbsp;", "", $matches[2]);
        $matches[3] = str_replace("&nbsp;", "", $matches[3]);
        $matches[4] = str_replace("&nbsp;", "", $matches[4]);
        $matches[5] = str_replace("&nbsp;", "", $matches[5]);
        $matches[6] = str_replace("&nbsp;", "", $matches[6]);
        $data = array(
            array(
                'usd_buy'  => $matches[1],
                'usd_sell' => $matches[2],
                'eur_buy'  => $matches[3],
                'eur_sell' => $matches[4],
                'rub_buy'  => $matches[5],
                'rub_sell' => $matches[6],
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => $html,
            )
        );
    } else {
        $status = 0;
        $data = array(
            array(
                'usd_buy'  => 0,
                'usd_sell' => 0,
                'eur_buy'  => 0,
                'eur_sell' => 0,
                'rub_buy'  => 0,
                'rub_sell' => 0,
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => $html,
            )
        );
    }
    //print_r($data);
    return $data;
}

?>

