<?php

function alfabank_by($banks_id)
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    try {
        $xml = simplexml_load_file("https://www.alfabank.by/personal/currency/office/");

        $html = $xml->asXML();

        foreach ($xml as $arr) {
            if ($arr->city == "Бобруйск") {
                $usd = $arr->rates->exch_rate->exch_rate_record[0];
                $atts_object = $usd->attributes();
                $atts_array = (array)$atts_object;
                $valuta[0] = $atts_array['@attributes']['rate_buy'];
                $valuta[1] = $atts_array['@attributes']['rate_sell'];

                $eur = $arr->rates->exch_rate->exch_rate_record[1];
                $atts_object = $eur->attributes();
                $atts_array = (array)$atts_object;
                $valuta[2] = $atts_array['@attributes']['rate_buy'];
                $valuta[3] = $atts_array['@attributes']['rate_sell'];

                $rub = $arr->rates->exch_rate->exch_rate_record[2];
                $atts_object = $rub->attributes();
                $atts_array = (array)$atts_object;
                $valuta[4] = $atts_array['@attributes']['rate_buy'];
                $valuta[5] = $atts_array['@attributes']['rate_sell'];

                //print_r($valuta);
            }
        }
    } catch (Throwable $e) {
        $valuta = ['', '', '', '', '', ''];
    }

    $data = [];

    if (
        (string)$valuta[0] == '' &&
        (string)$valuta[1] == '' &&
        (string)$valuta[2] == '' &&
        (string)$valuta[3] == '' &&
        (string)$valuta[4] == '' &&
        (string)$valuta[5] == ''
    ) {
        $status = 0;
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
    } else {
        $status = 1;
        $data[] = array(
            'usd_buy'  => trim($valuta[0]),
            'usd_sell' => trim($valuta[1]),
            'eur_buy'  => trim($valuta[2]),
            'eur_sell' => trim($valuta[3]),
            'rub_buy'  => trim($valuta[4]),
            'rub_sell' => trim($valuta[5]),
            'banks_id' => $banks_id,
            'status'   => $status,
            'html'     => $html,
        );
    }
    //print_r($data);
    return $data;
}

//alfabank_by();
?>
