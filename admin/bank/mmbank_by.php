<?php

function mmbank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("https://www.mmbank.by/personal/currency_exchange/?town=29");
    if (preg_match("/<div class=\"blueName\">Наличный курс<\/div>.*?<td class=\"curr\">Доллар США<\/td>\n<td class=\"pok\".*?span class=\"num\">([^<]*)<.*?<td class=\"prod\".*?span class=\"num\">([^<]*)<.*?<td class=\"curr\">Евро<\/td>\n<td class=\"pok\".*?span class=\"num\">([^<]*)<.*?<td class=\"prod\".*?span class=\"num\">([^<]*)<.*?<td class=\"curr\">Российский рубль<\/td>\n<td class=\"pok\".*?span class=\"num\">([^<]*)<.*?<td class=\"prod\".*?span class=\"num\">([^<]*)<.*?<div class=\"blueName\">Курс конверсии<\/div>/ms",
        $html, $valuta)) {
        $status = 1;

        //echo $id_pages;
        //print_r($valuta);
        //print_r($eur);
        //global $banks_id;

        $data = array(
            array(
                'usd_buy'  => trim($valuta[1]),
                'usd_sell' => trim($valuta[2]),
                'eur_buy'  => trim($valuta[3]),
                'eur_sell' => trim($valuta[4]),
                'rub_buy'  => trim($valuta[5]),
                'rub_sell' => trim($valuta[6]),
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => 'Лог отключён',

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
                'html'     => 'Лог отключён',
            )
        );
    }
    //print_r($data);
    return $data;
}

//mmbank_by()
?>
