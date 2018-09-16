<?php

function stbank_by_1($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("https://stbank.by/bitrix/templates/include/index/currency.php?CBU_ID=731&DATE=&TYPE=currencyps-sberbank.by/432579A7004D99C5/cur_rates%3fOpenForm&tabnum=1&city=%25CC%25EE%25E3%25E8%25EB%25E5%25E2%25F1%25EA%25E0%25FF%2520%25EE%25E1%25EB%25E0%25F1%25F2%25FC&bankbranch=369-601");
    if (preg_match("/<span class=\"aux_font\">покупаем<\/span>.*?<span class=\"aux_font\">продаем<\/span>.*?<span class=\"currency\">1 USD<\/span>.*?<span class=\"value\">([^<]*)<\/span>.*?<span class=\"value\">([^<]*)<\/span>.*?<span class=\"aux_font\">покупаем<\/span>.*?<span class=\"aux_font\">продаем<\/span>.*?<span class=\"currency\">1 EUR<\/span>.*?<span class=\"value\">([^<]*)<\/span>.*?<span class=\"value\">([^<]*)<\/span>.*?<span class=\"aux_font\">покупаем<\/span>.*?<span class=\"aux_font\">продаем<\/span>.*?<span class=\"currency\">100 RUB<\/span>.*?<span class=\"value\">([^<]*)<\/span>.*?<span class=\"value\">([^<]*)<\/span>/ms",
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

//stbank_by_1()
?>
