<?php

function alfabank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("https://www.alfabank.by/online/banking/insync/");

    if (preg_match("/.*?<div class=\"informer_tab js-tabs_tab\" data-tab=\"1\">.*?<span class=\"informer-currencies_name\">USD<\/span>.*?<span class=\"informer-currencies_value-txt\">([^<]*)<\/span>.*?<span class=\"informer-currencies_value-txt\">([^<]*)<\/span>.*?<span class=\"informer-currencies_name\">EUR<\/span>.*?<span class=\"informer-currencies_value-txt\">([^<]*)<\/span>.*?<span class=\"informer-currencies_value-txt\">([^<]*)<\/span>.*?<span class=\"informer-currencies_name\">RUB<\/span>.*?<span class=\"informer-currencies_value-txt\">([^<]*)<\/span>.*?<span class=\"informer-currencies_value-txt\">([^<]*)<\/span>.*?<div class=\"informer_tab js-tabs_tab\" data-tab=\"2\">/ms",
        $html, $valuta)) {
        $status = 1;
        $data = array(
            array(
                'usd_buy'  => str_replace(",", ".", trim($valuta[1])),
                'usd_sell' => str_replace(",", ".", trim($valuta[2])),
                'eur_buy'  => str_replace(",", ".", trim($valuta[3])),
                'eur_sell' => str_replace(",", ".", trim($valuta[4])),
                'rub_buy'  => str_replace(",", ".", trim($valuta[5])),
                'rub_sell' => str_replace(",", ".", trim($valuta[6])),
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

    //echo $id_pages;
    //print_r($valuta);
    //print_r($data);
    return $data;
}

//alfabank_by();
?>
