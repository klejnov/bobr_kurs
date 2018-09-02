<?php

function belarusbank_by()
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    //header('Content-Type: text/html; charset=utf-8');

    $json = file_get_contents("https://belarusbank.by/api/kursExchange?city=%C1%EE%E1%F0%F3%E9%F1%EA");
    $arr = json_decode($json, true);

    $data_return = array();
    $array_banks_id = array();

    foreach ($arr as $bank) {
        if ($bank['name'] == "Бобруйск") {
            if ($bank['filials_text'] == 'Отделение 703/104') {
                $banks_id = 13;
            } else if ($bank['filials_text'] == 'Обменный пункт 703/11') {
                $banks_id = 14;
            } else if ($bank['filials_text'] == 'Отделение 703/112') {
                $banks_id = 15;
            } else if ($bank['filials_text'] == 'Отделение 703/114') {
                $banks_id = 16;
            } else if ($bank['filials_text'] == 'Обменный пункт 703/12') {
                $banks_id = 17;
            } else if ($bank['filials_text'] == 'Отделение 703/80') {
                $banks_id = 18;
            } else if ($bank['filials_text'] == 'Отделение 703/81') {
                $banks_id = 19;
            } else if ($bank['filials_text'] == 'Отделение 703/84') {
                $banks_id = 20;
            } else if ($bank['filials_text'] == 'Отделение 703/86') {
                $banks_id = 21;
            } else if ($bank['filials_text'] == 'Отделение 703/87') {
                $banks_id = 22;
            } else if ($bank['filials_text'] == 'Отделение 703/92') {
                $banks_id = 24;
            } else if ($bank['filials_text'] == 'Отделение 703/94') {
                $banks_id = 25;
            } else if ($bank['filials_text'] == 'Отделение 703/96') {
                $banks_id = 26;
            } else if ($bank['filials_text'] == 'Филиал 703/Операционная служба') {
                $banks_id = 27;
            } else if ($bank['filials_text'] == 'Отделение 703/19') {
                $banks_id = 28;
            } else if ($bank['filials_text'] == 'Отделение 703/24') {
                $banks_id = 29;
            } else if ($bank['filials_text'] == 'Отделение 703/38') {
                $banks_id = 30;
            } else if ($bank['filials_text'] == 'Отделение 703/59') {
                $banks_id = 31;
            } else if ($bank['filials_text'] == 'Отделение 703/9') {
                $banks_id = 32;
            }
            $array_banks_id[] = $banks_id;
            if (
                $bank['USD_in'] == '' &&
                $bank['USD_out'] == '' &&
                $bank['EUR_in'] == '' &&
                $bank['EUR_out'] == '' &&
                $bank['RUB_in'] == '' &&
                $bank['RUB_out'] == ''
            ) {
                $status = 0;
            } else {
                $status = 1;
            }
            $data_return[] = array(
                'usd_buy'  => $bank['USD_in'],
                'usd_sell' => $bank['USD_out'],
                'eur_buy'  => $bank['EUR_in'],
                'eur_sell' => $bank['EUR_out'],
                'rub_buy'  => $bank['RUB_in'],
                'rub_sell' => $bank['RUB_out'],
                'banks_id' => $banks_id,
                'status'   => $status,
                'html'     => $json,
            );
            $banks_id = 0;
        }
    }

    if (!in_array(13, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 13,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(14, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 14,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(15, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 15,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(16, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 16,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(17, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 17,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(18, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 18,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(19, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 19,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(20, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 20,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(21, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 21,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(22, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 22,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(24, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 24,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(25, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 25,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(26, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 26,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(27, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 27,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(28, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 28,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(29, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 29,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(30, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 30,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(31, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 31,
            'status'   => 0,
            'html'     => $json,
        );
    }

    if (!in_array(32, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy'  => 0,
            'usd_sell' => 0,
            'eur_buy'  => 0,
            'eur_sell' => 0,
            'rub_buy'  => 0,
            'rub_sell' => 0,
            'banks_id' => 32,
            'status'   => 0,
            'html'     => $json,
        );
    }

    //print_r($data_return);
    return $data_return;
}

//belarusbank_by();
?>
