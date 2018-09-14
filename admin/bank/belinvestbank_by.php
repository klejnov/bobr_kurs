<?php

function belinvestbank_by()
{
    error_reporting(E_ALL);
    //header('Content-Type: text/html; charset=utf-8');

    $xml = simplexml_load_file("https://ibank.belinvestbank.by/api/cashCourses.php");

    $html = $xml->asXML();

    $valuta[0] = $xml->BankSvcRs->ForExRateInqRs[0]->ForExRateRec->ForExRateInfo->CurRate;
    $valuta[1] = $xml->BankSvcRs->ForExRateInqRs[1]->ForExRateRec->ForExRateInfo->CurRate;
    $valuta[2] = $xml->BankSvcRs->ForExRateInqRs[8]->ForExRateRec->ForExRateInfo->CurRate;
    $valuta[3] = $xml->BankSvcRs->ForExRateInqRs[9]->ForExRateRec->ForExRateInfo->CurRate;
    $valuta[4] = $xml->BankSvcRs->ForExRateInqRs[16]->ForExRateRec->ForExRateInfo->CurRate;
    $valuta[5] = $xml->BankSvcRs->ForExRateInqRs[17]->ForExRateRec->ForExRateInfo->CurRate;

    $data = [];
    $array_banks_id = [38, 45, 46, 47, 48];

    if (
        (string)$valuta[0] == '' &&
        (string)$valuta[1] == '' &&
        (string)$valuta[2] == '' &&
        (string)$valuta[3] == '' &&
        (string)$valuta[4] == '' &&
        (string)$valuta[5] == ''
    ) {
        $status = 0;
        foreach ($array_banks_id as $banks_id) {
            $data[] = array(
                'usd_buy'  => 0,
                'usd_sell' => 0,
                'eur_buy'  => 0,
                'eur_sell' => 0,
                'rub_buy'  => 0,
                'rub_sell' => 0,
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => 'Лог отключён',
            );
        }
    } else {
        $status = 1;
        foreach ($array_banks_id as $banks_id) {
            $data[] = array(
                'usd_buy'  => trim($valuta[0]),
                'usd_sell' => trim($valuta[1]),
                'eur_buy'  => trim($valuta[2]),
                'eur_sell' => trim($valuta[3]),
                'rub_buy'  => trim($valuta[4]),
                'rub_sell' => trim($valuta[5]),
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => 'Лог отключён',
            );
        }
    }
    //print_r($data);
    return $data;
}

//belinvestbank_by();
?>
