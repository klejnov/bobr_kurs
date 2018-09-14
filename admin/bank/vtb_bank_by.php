<?php

function vtb_bank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $html = file_get_contents("https://www.vtb-bank.by/");
    if (preg_match("/<td class='usd'><span><\/span><101<\/td>.*?<span>([^<]*)<\/span>.*?<span>([^<]*)<\/span>.*?<td class='usd'><span><\/span>101 - 1001<\/td>.*?<td class='usd'><span><\/span><105<\/td>.*?<span>([^<]*)<\/span>.*?<span>([^<]*)<\/span>.*?<td class='usd'><span><\/span>105 - 1005<\/td>.*?<td class='usd'><span><\/span><1010<\/td>.*?<span>([^<]*)<\/span>.*?<span>([^<]*)<\/span>.*?<td class='usd'><span><\/span>1010 - 30010<\/td>/ms",
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

//vtb_bank_by()
?>
