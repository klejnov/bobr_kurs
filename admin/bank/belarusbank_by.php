<?php

function belarusbank_by()
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    //header('Content-Type: text/html; charset=utf-8');

    $xml = simplexml_load_file('https://belarusbank.by/dev/kursyValut');

    $data_return = array();
    $array_banks_id = array();

    foreach ($xml->page->date->content->trader as $bank) {
        if ((string)$bank->address->city == "Бобруйск") {
            if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. С.Горелика 59А') {
                $banks_id = 13;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Батова 14/46') {
                $banks_id = 14;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. 50 лет ВЛКСМ 33') {
                $banks_id = 15;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street) == 'Бобруйск  Минское шоссе центр.проходная ОАО Белшина') {
                $banks_id = 16;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Железнодорожная 13') {
                $banks_id = 17;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Социалистическая 92') {
                $banks_id = 18;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Интернациональная 76') {
                $banks_id = 19;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Лынькова 6') {
                $banks_id = 20;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Ульяновская 49') {
                $banks_id = 21;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Минская 73') {
                $banks_id = 22;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Рокоссовского 78') {
                $banks_id = 23;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Октябрьская 92') {
                $banks_id = 24;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Советская 53') {
                $banks_id = 25;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Сикорского 26') {
                $banks_id = 26;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. М.Горького 2') {
                $banks_id = 27;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Парковая 57') {
                $banks_id = 28;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Кирова 139') {
                $banks_id = 29;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Западная 21') {
                $banks_id = 30;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Орджоникидзе 44а') {
                $banks_id = 31;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Куйбышева 57') {
                $banks_id = 32;
            } else if (((string)$bank->address->city . " " . (string)$bank->address->street . " " . (string)$bank->address->home) == 'Бобруйск ул. Ульяновская 94') {
                $banks_id = 33;
            }
            $array_banks_id[] = $banks_id;
            if (
                (string)$bank->rates->USD->buy == '' &&
                (string)$bank->rates->USD->sale == '' &&
                (string)$bank->rates->EUR->buy == '' &&
                (string)$bank->rates->EUR->sale == '' &&
                (string)$bank->rates->RUB->buy == '' &&
                (string)$bank->rates->RUB->sale == ''
            ) {
                $status = 0;
            } else {
                $status = 1;
            }
            $data_return[] = array(
                'usd_buy' => (string)$bank->rates->USD->buy,
                'usd_sell' => (string)$bank->rates->USD->sale,
                'eur_buy' => (string)$bank->rates->EUR->buy,
                'eur_sell' => (string)$bank->rates->EUR->sale,
                'rub_buy' => (string)$bank->rates->RUB->buy,
                'rub_sell' => (string)$bank->rates->RUB->sale,
                'banks_id' => $banks_id,
                'status' => $status,
            );
            $banks_id = 0;
        }
    }

    if (!in_array(13, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 13,
            'status' => 0,
        );
    }

    if (!in_array(14, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 14,
            'status' => 0,
        );
    }

    if (!in_array(15, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 15,
            'status' => 0,
        );
    }

    if (!in_array(16, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 16,
            'status' => 0,
        );
    }

    if (!in_array(17, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 17,
            'status' => 0,
        );
    }

    if (!in_array(18, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 18,
            'status' => 0,
        );
    }

    if (!in_array(19, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 19,
            'status' => 0,
        );
    }

    if (!in_array(20, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 20,
            'status' => 0,
        );
    }

    if (!in_array(21, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 21,
            'status' => 0,
        );
    }

    if (!in_array(22, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 22,
            'status' => 0,
        );
    }

    if (!in_array(23, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 23,
            'status' => 0,
        );
    }

    if (!in_array(24, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 24,
            'status' => 0,
        );
    }

    if (!in_array(25, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 25,
            'status' => 0,
        );
    }

    if (!in_array(26, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 26,
            'status' => 0,
        );
    }

    if (!in_array(27, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 27,
            'status' => 0,
        );
    }

    if (!in_array(28, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 28,
            'status' => 0,
        );
    }

    if (!in_array(29, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 29,
            'status' => 0,
        );
    }

    if (!in_array(30, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 30,
            'status' => 0,
        );
    }

    if (!in_array(31, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 31,
            'status' => 0,
        );
    }

    if (!in_array(32, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 32,
            'status' => 0,
        );
    }

    if (!in_array(33, $array_banks_id)) {
        $data_return[] = array(
            'usd_buy' => 0,
            'usd_sell' => 0,
            'eur_buy' => 0,
            'eur_sell' => 0,
            'rub_buy' => 0,
            'rub_sell' => 0,
            'banks_id' => 33,
            'status' => 0,
        );
    }


    //print_r($data_return);
    return $data_return;
}
//belarusbank_by();
?>
